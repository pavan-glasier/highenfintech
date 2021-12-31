<?php
/**
 * The template for displaying Author Archive pages
 *
 * Used to display archive-type pages for posts by an author.
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
				/*
				 * Queue the first post, that way we know
				 * what author we're dealing with (if that is the case).
				 *
				 * We reset this later so we can run the loop
				 * properly with a call to rewind_posts().
				 */
				the_post();
			?>
	<section class="inner-wrap">
      <div class="container">
         <div class="row">
            <div class="col-md-12 inner-header">
               <!-- <h1><?php //printf( __( 'Author : %s', 'highen' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' );?></h1> -->

               <!-- <h1><?php //printf( __( 'Author : %s', 'highen' ), '<span class="vcard">' . get_the_author() . '</span>' );?></h1> -->
               
               <div class="card">
               		<div class="pro-img">
               			<?php 
               			$author_bio_avatar_size = apply_filters( 'highen_author_bio_avatar_size', 68 );
						echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
               			?>
               		</div>
               		<div class="details">
               			<h2><?php printf( __( '%s', 'highen' ), '<span class="vcard">' . get_the_author() . '</span>' );?></h2>
               			<p class="author-description"> <?php the_author_meta( 'description' ); ?></p>
               		</div>
               </div>
               

            </div>
         </div>
      </div>
   </section>
			

			<?php
				/*
				 * Since we called the_post() above, we need
				 * to rewind the loop back to the beginning.
				 * That way we can run the loop properly, in full.
				 */
				rewind_posts();
			?>

			<?php //highen_content_nav( 'nav-above' ); ?>



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
											// get_template_part( 'blog/blog', 'grid' );
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
