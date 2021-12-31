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



<?php if( have_rows('sections') ): ?>
<!-- Fintech Solution All Sections -->

<div class="default-padding">
<?php while ( have_rows('sections') ) : the_row();?>
   <?php  if( get_row_layout() == 'section_1' ) :?>
   <?php
   $section_1_image = get_sub_field('image');
   $section_1_title = get_sub_field('title');
   $section_1_content = get_sub_field('content');
   ?>

    <div id="process" class="work-process-area ">
        <div class="container">
            <div class="row pb-70">
                <div class="col-md-6">
                    <img src="<?php echo $section_1_image; ?>" >
                </div>
                <div class="col-md-6 info">
                    <ul>
                        <li>
                            <div class="content">
                                <p class="text-justify">
                                <h4><strong><?php echo $section_1_title; ?></strong></h4>
                                <?php echo $section_1_content; ?>
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
<?php endwhile; ?>



<?php while ( have_rows('sections') ) : the_row();?>
   <?php  if( get_row_layout() == 'section_2' ) :?>
   <?php
   $section_heading = get_sub_field('section_heading');
   ?>

    <section>
        <div id="process" class="work-step-area default-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-lg-offset-2 col-md-offset-2">
                        <div class="site-heading text-center">
                            <h2><?php echo $section_heading;?></h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="work-step-items">
                        <!-- Single Item -->
                        <?php 
                  
                        if( have_rows('image_content_section_2') ):
                            //$a = 1;
                        while( have_rows('image_content_section_2') ) : the_row();
                        $section_2_image = get_sub_field('image');
                        $section_2_title = get_sub_field('title');
                        $section_2_content = get_sub_field('content');
                        $a++;
                        ?>

                        <div class="single-item <?php if ($a%2==0) { ?>reverse<?php } ?>" >
                            <div class="col-md-12">
                                <div class="item">
                                    <div class="row">
                                        <div class="col-md-6 thumb">
                                            <img src="<?php echo $section_2_image;?>" >
                                        </div>
                                        <div class="col-md-6 info">
                                            <div class="title">
                                                <h2><?php echo $section_2_title;?></h2>
                                            </div>
                                            <?php echo $section_2_content;?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php 
                            endwhile;
                        else :
                        endif;
                            ?>

                            

                        
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php endif; ?>
<?php endwhile; ?>




</div>

<?php while ( have_rows('sections') ) : the_row();?>
   <?php  if( get_row_layout() == 'section_3' ) :?>


    <?php 
                  
    if( have_rows('image_content_section_3') ):
        //$a = 1;
    while( have_rows('image_content_section_3') ) : the_row();
    $section_3_image = get_sub_field('image');
    $section_3_title = get_sub_field('title');
    $section_3_content = get_sub_field('content');
       $section_3_link_button = get_sub_field('link_button');

    ?>
    <section class="container">
      <div class="cta-box">
         <div class="row">
            <div class="col-md-6">
               <img src="<?php echo $section_3_image; ?>" >
            </div>
            <div class="col-md-6">
               <h1><?php echo $section_3_title; ?></h1>
               <?php
                    if( (!empty($section_3_link_button)) )   {
                ?>
                <a class="btn btn-theme border btn-md mt-30 mb-10 text-center" href="<?php echo $section_3_link_button['url'];?>"><?php echo $section_3_link_button['title'];?></a>
                <?php }?>
            </div>
         </div>
      </div>
    </section>

  <?php 
       endwhile;
     else :
     endif;
      ?>
    
    <?php endif; ?>
<?php endwhile; ?>



<?php endif; ?>



<!-- Blockchain Solution -->


<?php if( have_rows('blockchain_solution') ): ?>
<!-- MOBILE APP DEVELOPMENT Section -->
<div class="default-padding blockchain-blog">
<?php while ( have_rows('blockchain_solution') ) : the_row();?>
   <?php  if( get_row_layout() == 'block_section_1' ) :?>
   <?php
   $block_sec_1_image = get_sub_field('image');
   $block_sec_1_title = get_sub_field('title');
   $block_sec_1_content = get_sub_field('content');
   ?>
   
      <div id="process" class="work-process-area ">
         <div class="container">
               <div class="row pb-70">
                  <div class="col-md-6">
                     <img src="<?php echo $block_sec_1_image;?>">
                  </div>
                  <div class="col-md-6 info">
                  <ul>
                     
                     <li>
                           <div class="content">
                              <?php
                              if( !empty( $block_sec_1_title ) ){ ?>
                              <h3><strong><?php echo $block_sec_1_title;?></strong></h3>
                              <?php } ?>
                              <?php echo $block_sec_1_content;?>
                           
                        </div>
                     </li>

                  </ul>
                  </div>
               </div>
         </div>
      </div>

      <?php endif; ?>
<?php endwhile; ?> 


<?php while ( have_rows('blockchain_solution') ) : the_row();?>
   <?php  if( get_row_layout() == 'faqs_section' ) :?>
   <?php
   $section_heading = get_sub_field('section_heading');
   $section_sub_heading = get_sub_field('section_sub_heading');
   $faqs = get_sub_field('faqs');
   ?>

         <section class="border-top default-padding bg-gray blockchain-sec">
            <div class="auto-container">
               <div class="row">
                  <div class="col-md-12">
                     <div class="site-heading text-center">
                        <h2><?php echo $section_heading; ?></h2>
                        <p style="margin-top: 30px;"> <?php echo $section_sub_heading; ?> </p>
                     </div>
                  </div>
               </div>
               <?php if( have_rows('faqs') ): ?>
               <?php while( have_rows('faqs') ): the_row();
				$faq_section_image = get_sub_field('faq_section_image');
				?>

               <div class="row clearfix">
                  <div class="col-lg-6 col-md-6 col-sm-12 ">
                     <div id="annual" class="tab-pane">
                        <div class="acd-items acd-arrow mt-30">
                           <div class="panel-group symb" id="accordion">

                              <?php 
                                 
                              if( have_rows('faq') ):
                                 $c = 1;
                                 $d = 1;
                              while( have_rows('faq') ) : the_row();
                                 $faq_title = get_sub_field('title');
                                 $faq_content = get_sub_field('content');
                                 
                              ?>
                                      <div class="panel panel-default">
                                          <div class="panel-heading">
                                              <h4 class="panel-title">
                                                  <a class="<?php if ($c!=1) { ?>collapsed<?php } ?>" data-toggle="collapse" data-parent="#accordion" href="#ac<?php echo $c++;?>"  >
                                                   <?php echo $faq_title;?>
                                                  </a>
                                              </h4>
                                          </div>
                                          <div class="panel-collapse collapse <?php if ($d==1) { ?>in<?php } ?>" id="ac<?php echo $d++;?>" >
                                              <div class="panel-body mobile-app-develop">
                                       <?php echo $faq_content;?>
                                              </div>
                                          </div>
                                      </div>
                                 <?php 
                              endwhile;
                              else :
                              endif;
                                 ?>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 image-column">
                     <div id="image_block_01">
                        <div class="image-box">
                           <figure class="image js-tilt">
                              <img src="<?php echo $faq_section_image; ?>">
                           </figure>
                        </div>
                     </div>
                  </div>
               </div>
               <?php endwhile; ?>
               <?php endif; ?>

            </div>

         </section>

      <?php endif; ?>
<?php endwhile; ?> 




<?php while ( have_rows('blockchain_solution') ) : the_row();?>
   <?php  if( get_row_layout() == 'block_section_2' ) :?>


      <?php 
                  
      if( have_rows('image_content_section_2') ):
          //$a = 1;
      while( have_rows('image_content_section_2') ) : the_row();
      $block_section_2_image = get_sub_field('image');
      $block_section_2_title = get_sub_field('title');
      $block_section_2_content = get_sub_field('content');
      $bb++;
      ?>
         <section class="faq-section faq-page-section sec-pad default-padding">
            <div class="auto-container">
               
               <div class="row clearfix <?php if ($bb%2==0) { ?>reverse<?php } ?>">

                  <div class="col-lg-6 col-md-12 col-sm-12 ">
                    <img src="<?php echo $block_section_2_image;?>">
                  </div>
                  <div class="col-lg-6 col-md-12 col-sm-12 content-column">
                     <div id="content_block_06">
                        <div class="content-box">
                           <div class="sec-title">
                              <h2><?php echo $block_section_2_title;?></h2>
                           </div>
                           <div class="text">
                              <?php echo $block_section_2_content;?>
                           </div>
                        </div>
                     </div>
                  </div>

               </div>

               
            </div>
         </section>

         <?php 
             endwhile;
         else :
         endif;
             ?>

<?php endif; ?>
<?php endwhile; ?>






<?php while ( have_rows('blockchain_solution') ) : the_row();?>
   <?php  if( get_row_layout() == 'block_section_3' ) :

      $block_section_3_title = get_sub_field('title');
      
      $block_section_3_image = get_sub_field('image');

      ?>

         <section class="work-process-area default-padding border-top sucess-back">
            <div class="container">
                <div class="row clearfix">
                    <div class="col-lg-6 col-md-6 col-sm-12 content-column">
                        <div id="content_block_01">
                            <div class="content-box">
                                <div class="sec-title">
                                    <h2><?php echo $block_section_3_title;?></h2>
                                </div>
                                <ul class="list-item clearfix">
                                    <?php 
                  
                                       if( have_rows('listing') ):
                                          while( have_rows('listing') ) : the_row();
                                          $block_section_3_content = get_sub_field('content');
                                       ?>

                                       <li><?php echo $block_section_3_content;?></li>
                                       <?php 
                                           endwhile;
                                       else :
                                       endif;
                                           ?>

                                    <!-- <li>Gathering requirements as well as application roadmaps, analysis of use cases</li>
                                    <li>Definition of the technical architecture, intelligent contracts agreements, and ensuring compliance with regulatory requirements</li>
                                    <li>Designing modules and components and incorporating the intelligent contract terms</li>
                                    <li>Testing on testnet servers Testing, deployment on mainnet, and then going live</li> -->
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 image-column">
                     <img src="<?php echo $block_section_3_image;?>">
                  </div>
                </div>
            </div>
        </section>

 <?php endif; ?>
<?php endwhile; ?>   


</div>

<?php endif; ?>
<?php get_footer(); ?>
