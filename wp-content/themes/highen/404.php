<?php
/**
 * The template for displaying 404 pages (Not Found)
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
                <h1>404 </h1>
            </div>
        </div>
    </div>
</section>

<div class="default-padding">
    <div id="process" class="work-process-area ">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                	<div class="site-heading text-center">
	                  <h2><?php _e( 'Not Found !', 'highen' ); ?></h2>
	                  <p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'highen' ); ?></p>
	               	</div>
	               	<a class="btn btn-theme border btn-md" href="<?=site_url();?>">HOME</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
