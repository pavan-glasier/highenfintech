<?php
/**
 * The template for displaying Category pages
 *
 * Used to display archive-type pages for posts in a category.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage highen
 * @since Highen 1.0
 */

get_header(); ?>


		<?php if ( have_posts() ) : ?>
				<?php
				/* translators: %s: Category title. */
				//printf( __( 'Category Archives: %s', 'highen' ), '<span>' . single_cat_title( '', false ) . '</span>' );
				?>

	<section class="inner-wrap">
      <div class="container">
         <div class="row">
            <div class="col-md-12 inner-header">
               <h1><?php printf( __( 'Category : %s', 'highen' ), '<span>' . single_cat_title( '', false ) . '</span>' );?></h1>
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
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
