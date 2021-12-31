<?php
/**
 * The template for displaying Search Results pages
 *
 * @package WordPress
 * @subpackage highen
 * @since Highen 1.0
 */

get_header(); ?>


<?php if ( have_posts() ) : ?>

<section class="inner-wrap">
    <div class="container">
        <div class="row">
            <div class="col-md-12 inner-header">
                <h1> <?php printf( __( 'Search Results for: %s', 'highen' ), '<span>' . get_search_query() . '</span>' );?> </h1>
            </div>
        </div>
    </div>
</section>



	<?php //get_template_part( 'content', get_post_format() ); ?>

<div class="default-padding">
  	<div class="container">
     	<div class="row">
        	<div class="col-lg-12 col-md-12 col-sm-12">
           		<div class="row ">
              		<div class="col-md-12">
						<div class="address-list text-center col-md-12">
						   <div class="row">
							<?php while ( have_posts() ) : the_post(); ?>

						      <div class="col-md-4 col-sm-12 ">
						         <div class="item item-box search-box" style="position: relative;">
						            <span class="badge"><?php echo get_post_type( get_the_ID());?></span>
						            <a href="<?php the_permalink();?>">
						            	<h3>
						            		<?php $title = get_the_title();
						            		$trim_title = wp_trim_words( $title, 5, "" );
						            		echo $trim_title;
						            		?>
						            			
					            		</h3>
						            </a>
						            <p style="font-size: 13px;line-height: normal;"><?php $content = get_the_content(); 
						            	$trim_cont = wp_trim_words( $content, 10, "" );
						            	echo $trim_cont;
						        	?></p>
						         </div>
						      </div>   

				            <?php endwhile; ?>                                                
						   </div>
						</div>
					</div>
					<div class="col-md-12">
						<!-- <div class="pagination"> -->
							<?php //previous_posts_link( '<span> &larr; Prev </span>' ); ?>
							<?php //next_posts_link( '<span> Next &rarr; </span>' ); ?>
							<?php highen_pagination(); ?>
						<!-- </div> -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>




<?php //highen_content_nav( 'nav-below' ); ?>

<?php else : ?>

					
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
	                  <p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'highen' ); ?></p>
	               	</div>
	               	<a class="btn btn-theme border btn-md" href="<?=site_url();?>">HOME</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>


<?php get_footer(); ?>
