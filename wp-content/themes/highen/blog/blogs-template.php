<?php 

/**
* Template Name: All Blogs
*
*/

get_header();
?>

<section class="inner-wrap">
  <div class="container">
     <div class="row">
        <div class="col-md-12 inner-header">
           <h1>All Blogs</h1>
        </div>
     </div>
  </div>
</section>
<?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;?>
<?php $posts = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 1, 'paged' => $paged ) ); ?>
   	<div class="default-padding">
      	<div class="container">
         	<div class="row">
            	<div class="col-lg-8 col-md-12 col-sm-12">
               		<div class="row ">
                  		<div class="col-md-12">
                     		<div class="slider-news blog-area bottom-less row">
                     			<?php 
                                while($posts->have_posts()) : $posts->the_post();?>
								<?php
								
								include('blog-grid.php');


								endwhile;
								//highen_content_nav( 'nav-below' );
								?>
							</div>

						</div>
						<div class="col-md-12">
							<!-- then the pagination links -->
							<!-- <div class="pagination"> -->
								<?php //previous_posts_link( '&larr; Prev ' ); ?>
								<?php //next_posts_link( 'Next &rarr;' ); ?>
								<?php highen_pagination(); ?>
							<!-- </div> -->
						</div>
					</div>
				</div>

				<?php include('side-bar.php');?>
			</div>

		</div>
	</div>






<?php get_footer(); ?>