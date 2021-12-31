<?php
/**
 * The template for displaying a "No posts found" message
 *
 * @package WordPress
 * @subpackage highen
 * @since Highen 1.0
 */
?>

<?php //get_search_form(); ?>



<section class="inner-wrap">
    <div class="container">
        <div class="row">
            <div class="col-md-12 inner-header">
                <h1><?php _e( 'Nothing Found', 'highen' ); ?></h1>
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
	                  <h2><?php _e( 'Nothing Found !', 'highen' ); ?></h2>
	                  <p><?php _e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'highen' ); ?></p>
	               	</div>
	               	<a class="btn btn-theme border btn-md" href="<?=site_url();?>">HOME</a>
                </div>
            </div>
        </div>
    </div>
</div>
