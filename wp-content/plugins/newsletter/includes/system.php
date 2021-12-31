<?php

defined('ABSPATH') || exit;

class NewsletterSystem {

    static $instance;

    const JOB_OK = 0;
    const JOB_MISSING = 2;
    const JOB_LATE = 1;
    const JOB_SKIPPED = 3;

    /**
     * @return NewsletterSystem
     */
    static function instance() {
        if (self::$instance == null) {
            self::$instance = new NewsletterSystem();
        }
        return self::$instance;
    }

    function __construct() {

    }

    function reset_cron_stats() {
        update_option('newsletter_diagnostic_cron_calls', [], false);
    }

    /**
     * 
     * @param type $calls
     * @return \TNP_Cron_Stats
     */
    function get_cron_stats() {
        $calls = get_option('newsletter_diagnostic_cron_calls', []);

        // Not enough data
        if (count($calls) < 12) {
            return null;
        }

        $stats = new TNP_Cron_Stats();

        for ($i = 1; $i < count($calls); $i++) {
            $delta = $calls[$i] - $calls[$i - 1];
            $stats->deltas[] = $delta;
            if ($stats->min > $delta) {
                $stats->min = $delta;
            }
            if ($stats->max < $delta) {
                $stats->max = $delta;
            }
        }
        $stats->avg = round(array_sum($stats->deltas) / count($stats->deltas));
        $stats->good = $stats->avg < NEWSLETTER_CRON_INTERVAL * 1.1; // 10% error
        return $stats;
    }

    function get_last_cron_call() {
        $calls = get_option('newsletter_diagnostic_cron_calls', []);
        if (empty($calls))
            return 0;
        return end($calls);
    }

    function has_newsletter_schedule() {
        $schedules = wp_get_schedules();
        if (!empty($schedules)) {
            foreach ($schedules as $key => $data) {
                if ($key == 'newsletter') {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * 
     * @return boolean|int
     */
    function get_job_delay() {
        $x = wp_next_scheduled('newsletter');
        return $x === false ? false : time() - $x;
    }

    function get_job_schedule() {
        return wp_next_scheduled('newsletter');
    }

    function get_cache_job_status($refresh = false) {
        $status = get_transient('newsletter_job_status');
        if ($status === false || $refresh) {
            $status = $this->get_job_status();
            set_transient('newsletter_job_status', $status, DAY_IN_SECONDS);
        }
        return $status;
    }

    function get_job_status() {

        $x = wp_next_scheduled('newsletter');
        if ($x === false) {
            return self::JOB_MISSING;
        }

        // Special case: the scheduler has been triggered but the job not executed
        $calls = get_option('newsletter_diagnostic_cron_calls', []);
        if (!empty($calls)) {
            $last = end($calls);
            if ($last > $x) {
                return self::JOB_SKIPPED;
            }
        }

        if (time() - $x > 900) {
            return self::JOB_LATE;
        }
        return self::JOB_OK;
    }

    function reset_send_stats() {
        update_option('newsletter_diagnostic_send_calls', [], false);
    }

    function get_send_stats() {
        // Send calls stats
        $send_calls = get_option('newsletter_diagnostic_send_calls', []);
        if (!$send_calls) {
            return null;
        }
        $send_max = 0;
        $send_min = PHP_INT_MAX;
        $send_total_time = 0;
        $send_total_emails = 0;
        $send_completed = 0;
        $stats = new TNP_Send_stats();

        // Batches
        for ($i = 0; $i < count($send_calls); $i++) {
            // 0 - batch start time
            // 1 - batch end time
            // 2 - number of sent email in this batch
            // 3 - 0: prematurely stopped, 1: completed
            if (empty($send_calls[$i][2])) {
                continue;
            }
            if ($send_calls[$i][2] <= 1) {
                continue;
            }

            $delta = $send_calls[$i][1] - $send_calls[$i][0];
            $send_total_time += $delta;
            $send_total_emails += $send_calls[$i][2];

            $send_mean = $delta / $send_calls[$i][2];
            $stats->means[] = $send_mean;
            $stats->sizes[] = $send_calls[$i][2];
            if ($send_min > $send_mean) {
                $send_min = $send_mean;
            }
            if ($send_max < $send_mean) {
                $send_max = $send_mean;
            }
            if (isset($send_calls[$i][3]) && $send_calls[$i][3]) {
                $send_completed++;
            }
        }

        if (empty($stats->means)) {
            return null;
        }
        $send_mean = $send_total_time / $send_total_emails;

        $stats->min = round($send_min, 2);
        $stats->max = round($send_max, 2);
        $stats->mean = round($send_mean, 2);
        $stats->total_time = round($send_total_time);
        $stats->total_emails = $send_total_emails;
        $stats->total_runs = count($stats->means);

        $stats->completed = $send_completed;
        $stats->interrupted = $stats->total_runs - $stats->completed;
        return $stats;
    }

    /**
     * Returns a list of functions attached to the prvoded filter or action name.
     * 
     * @global array $wp_filter
     * @param string $tag
     * @return string
     */
    function get_hook_functions($tag) {
        global $wp_filter;
        if (isset($wp_filter[$tag])) {
            $b = '';
            foreach ($wp_filter[$tag]->callbacks as $priority => $functions) {

                foreach ($functions as $function) {
                    $b .= '[' . $priority . '] ';
                    if (is_array($function['function'])) {
                        if (is_object($function['function'][0])) {
                            $b .= get_class($function['function'][0]) . '::' . $function['function'][1];
                        } else {
                            $b .= $function['function'][0] . '::' . $function['function'][1];
                        }
                    } else {
                        if (is_object($function['function'])) {
                            $fn = new ReflectionFunction($function['function']);
                            $b .= get_class($fn->getClosureThis()) . '(closure)';
                        } else {
                            $b .= $function['function'];
                        }
                    }
                    $b .= "<br>";
                }
            }
        }
        return $b;
    }

}

class TNP_Cron_Stats {

    var $min = PHP_INT_MAX;
    var $max = 0;
    var $avg = 0;
    /* List of intervals between cron calls */
    var $deltas = [];
    /* If the cron is triggered enough often */
    var $good = true;

}

class TNP_Send_Stats {

    /* Emails sent */
    var $total_emails;
    /* Total batches collected (1 sized-batch by Autoresponder are ignored) */
    var $total_runs;
    /* Total sending time of the collected batches */
    var $total_time;
    /* Batch completed without timeout or max emails limit */
    var $completed;
    /* Batches interrupted due to reached limits */
    var $interrupted;
    /* Min time to send an email */
    var $min = PHP_INT_MAX;
    /* Max time to send an email */
    var $max = 0;
    /* Average time to send all collected emails */
    var $mean = 0;
    /* List of single batches average per email sending time */
    var $means = [];
    /* Number of emails in the single batches */
    var $sizes = [];

}
