<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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
               <h1>All Blogs</h1>
            </div>
         </div>
      </div>
   </section>

	<div class="default-padding">
      	<div class="container">
         	<div class="row">
            	<div class="col-lg-8 col-md-12 col-sm-12">
               		<div class="row ">
                  		<div class="col-md-12">
                     		<div class="slider-news blog-area bottom-less row">
								<?php
								// Start the Loop.
								while ( have_posts() ) :
									the_post();

									/*
									* Include the post format-specific template for the content. If you want
									* to use this in a child theme then include a file called content-___.php
									* (where ___ is the post format) and that will be used instead.
									*/
									//  get_template_part( 'content', get_post_format() );
									include('blog/blog-grid.php');


								endwhile;

								//highen_content_nav( 'nav-below' );

								?>
							</div>
						</div>
						<div class="col-md-12">
							<!-- <div class="pagination"> -->
								<?php //previous_posts_link( '&larr; Prev ' ); ?>
								<?php //next_posts_link( 'Next &rarr;' ); ?>
								<?php highen_pagination(); ?>
							<!-- </div> -->
						</div>
					</div>
				</div>

				<?php include('blog/side-bar.php');?>
			</div>
		</div>
	</div>
		<?php else : ?>

			<?php
			if ( current_user_can( 'edit_posts' ) ) :
				// Show a different message to a logged-in user who can add posts.
				?>
			<section class="inner-wrap">
			    <div class="container">
			        <div class="row">
			            <div class="col-md-12 inner-header">
			                <h1><?php _e( 'No posts to display', 'highen' ); ?></h1>
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
				                  <h2><?php _e( 'No posts to display', 'highen' ); ?></h2>
				                  <p><?php
									/* translators: %s: Post editor URL. */
									printf( __( 'Ready to publish your first post? <br/><br/><a href="%s" class="btn btn-theme border btn-md">Get started here</a>.', 'highen' ), admin_url( 'post-new.php' ) );
									?>
								</p>
				               	</div>
			                </div>
			            </div>
			        </div>
			    </div>
			</div>
				<?php
			else :
				// Show the default message to everyone else.
				?>

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
				                  <h2><?php _e( 'Nothing Found', 'highen' ); ?></h2>
				                  <p><?php _e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'highen' ); ?>
								</p>
				               	</div>
			                </div>
			            </div>
			        </div>
			    </div>
			</div>
			<?php endif; // End current_user_can() check. ?>

		<?php endif; // End have_posts() check. ?>



<?php //get_sidebar(); ?>
<?php get_footer(); ?>
