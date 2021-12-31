<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage highen
 * @since Highen 1.0
 */

get_header(); ?>

<section class="inner-wrap">
    <div class="container">
        <div class="row">
            <div class="col-md-12 inner-header">
                <h1><?php the_title();?></h1>
            </div>
        </div>
    </div>
</section>

<?php if( have_rows('mobile_app_sections') ): 
require get_template_directory() . '/services/mobile_app_development.php'; ?>
<?php endif;?>

<?php if( have_rows('web_development_sections') ): 
require get_template_directory() . '/services/web_development.php'; ?>
<?php endif;?>

<?php if( have_rows('customer_software_sections') ): 
require get_template_directory() . '/services/customer_software.php'; ?>
<?php endif;?>

<?php if( have_rows('ui_ux_sections') ): 
require get_template_directory() . '/services/ui_ux_development.php'; ?>
<?php endif;?>


<?php if( have_rows('team_augmentation_sections') ): 
require get_template_directory() . '/services/team_augmentation.php'; ?>
<?php endif;?>


<?php if( have_rows('mvp_development_sections') ): 
require get_template_directory() . '/services/mvp_development.php'; ?>
<?php endif;?>

<?php get_footer(); ?>
