<?php 

/**
* Template Name: Home
*
*/

get_header();
?>



<?php //$hBanner = new WP_Query( array( 'post_type' => 'banner' , 'order' => 'DESC', 'posts_per_page' => 1 ) );
//while($hBanner->have_posts()) : $hBanner->the_post();?>
   <!----------------------------------- Start Banner ============================================= -->
<?php if( have_rows('sections') ): ?>
   <?php while ( have_rows('sections') ) : the_row();?>
   <?php  if( get_row_layout() == 'banner_section' ) :?>
   <?php
   $banner_title = get_sub_field('banner_title');
   $banner_content = get_sub_field('banner_content');
   $banner_image = get_sub_field('banner_image');

   ?>
   <div class="banner-area content-double box-nav background-move">
      <div class="container">
         <div class="row">
            <div class="double-items">
               <div class="col-md-6 left-info simple-video">
                  <div class="content" data-animation="animated fadeInUpBig">


                     <?php 
                     ?>

                   <?php if( $banner_title ): ?>
                     <h1>
                        <?php echo $banner_title; ?>
                     </h1>
                     <?php endif; ?>
                     

                     <?php if( $banner_content ): ?>
                        <?php echo $banner_content; ?>
                     <?php endif; ?>

                     <a class="btn btn-theme border btn-md" href="#" data-toggle="modal"
                        data-target=".bd-example-modal-md">Connect with us</a>
                     </a>
                     <?php
                     // if( $link ): 
                     //  $link_url = $link['url'];
                     //  $link_title = $link['title'];
                     //  $link_target = $link['target'] ? $link['target'] : '_self';
                      ?>
                         <!-- <a class="button" href="<?php //echo esc_url( $link_url ); ?>" target="<?php //echo esc_attr( $link_target ); ?>"><?php //echo esc_html( $link_title ); ?></a> -->
                     <?php //endif; ?>
                  </div>
               </div>
               <div class="col-md-6 right-info">
                  <?php if( $banner_image ): ?>
                     <p></p>
                  <div class="thumb animated">
                     <img src="<?php echo $banner_image; ?>" >
                  </div>
                  <?php endif; ?>
                  

               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- End Banner -->
   <?php endif ?>
<?php endwhile; ?>




   <!---------------------------------- Start About ============================================= -->
   <div id="about" class="about-area border-top default-padding bg-gray">
      <div class="container">
         <div class="row">
            <div class="col-lg-6 col-md-6 info">
            <?php while ( have_rows('sections') ) : the_row();?>
  
            <?php if( get_row_layout() == 'about_section' ) :?>
            <?php
            $about_title = get_sub_field('about_title');
            $about_content = get_sub_field('about_content');
            ?>
               <h2><?php echo $about_title;?></h2>
               <?php echo $about_content;?>

               <?php endif; ?>
            <?php endwhile; ?>



            <?php while ( have_rows('sections') ) : the_row();?>
  
            <?php if( get_row_layout() == 'counters' ) :?>
            <?php
            $counter_heading = get_sub_field('counter_heading');
            $counter = get_sub_field('counter');
            ?>
               <div class="fun-facts">
                  <h3><?php echo $counter_heading;?></h3>
                  <div class="row">
                  <?php 

                  if( have_rows('counter') ):

                   while( have_rows('counter') ) : the_row();

                       $counter_no = get_sub_field('counter_no');
                       $counter_text = get_sub_field('counter_text');
                        ?>
                     <div class="col-md-4 col-sm-4 item">
                        <div class="fun-fact">
                           <div class="timer" data-to="<?php echo $counter_no; ?>" data-speed="5000">0</div>
                           <span class="medium"><?php echo $counter_text; ?></span>
                        </div>
                     </div>

                   <?php 
                     endwhile;
                  else :
                  endif;
                     ?>
                  </div>
               </div>
            <?php endif; ?>
            <?php endwhile; ?>



            <?php while ( have_rows('sections') ) : the_row();?>
            <?php if( get_row_layout() == 'clients' ) :
               $client_logo = get_sub_field('client_logo'); ?>

               <div id="about" class="about-area companies-area text-center">
                  <div class="fun-facts">
                     <div class="row">
                        <div class="col-md-12">
                           <div class="clients-items owl-carousel owl-theme text-center">
                              <?php 
                              $size = 'full'; // (thumbnail, medium, large, full or custom size)
                              if( $client_logo ): ?>
                             <?php foreach( $client_logo as $image_arr ): ?>
                                 
                              <div class="single-item">
                                 <a href="#"><img src="<?php echo esc_url($image_arr['url']); ?>" alt="Clients"></a>
                              </div>
                             <?php endforeach; ?>
                              
                              <?php endif; ?>
                              
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
             <?php endif; ?>
            <?php endwhile; ?>
            </div>
            <div class="col-lg-6 col-md-6 features">
               <div class="row">
         <?php while ( have_rows('sections') ) : the_row();?>
            <?php if( get_row_layout() == 'features' ) :

                  if( have_rows('feature') ):

                   while( have_rows('feature') ) : the_row();

                     $feature_icon = get_sub_field('feature_icon');
                     $feature_title = get_sub_field('feature_title');
                     $feature_content = get_sub_field('feature_content');
                        ?>
                  <div class="col-lg-6 col-md-6 col-sm-6 equal-height">
                     <div class="item">
                        <i class="<?php echo $feature_icon; ?>"></i>
                        <h4 class="tagline"><?php echo $feature_title; ?></h4>

                           <?php echo $feature_content; ?>
                     </div>
                  </div>

                   <?php 
                     endwhile;
                  else :
                  endif;
                     ?>

            <?php endif; ?>
         <?php endwhile; ?>

               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- End About -->




   <!-- Start Features Area ============================================= -->
   <div id="features" class="features-area carousel-shadow default-padding">
      <div class="container">
         <?php while ( have_rows('sections') ) : the_row();?>
            <?php if( get_row_layout() == 'how_it_works' ) :

               $how_it_works_heading = get_sub_field('how_it_works_heading');
               $how_it_image = get_sub_field('image');
               ?>


            
         <div class="row">
            <div class="col-lg-8 col-md-8 col-lg-offset-2 col-md-offset-2">
               <div class="site-heading text-center">
                  <h2><?php echo $how_it_works_heading;?></h2>
                 <!--  <p>
                        Learning day desirous informed expenses material returned six the. She enabled invited
                        
                        exposed him another. Reasonably conviction solicitude me mr at discretion reasonable. Age
                        
                        out full gate bed day lose.
                        
                        </p> -->
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-md-12">
               <img src="<?php echo $how_it_image;?>">
            </div>
         </div>
         <?php endif; ?>
      <?php endwhile; ?>
      </div>
   </div>
   <!-- End Features Area -->

   <!-- Start Work Process Area ============================================= -->
   <div id="pricing" class="pricing-area default-padding bg-gray">
      <div class="container">

         <?php while ( have_rows('sections') ) : the_row();?>
            <?php if( get_row_layout() == 'tab_section' ) :

            $tab_section_heading = get_sub_field('tab_section_heading');
            $how_it_image = get_sub_field('image');
            ?>
         <div class="row">
            <div class="col-lg-8 col-md-8 col-lg-offset-2 col-md-offset-2">
               <div class="site-heading text-center">
                  <h2><?php echo $tab_section_heading;?></h2>
                  <!-- <p>
                          Learning day desirous informed expenses material returned six the. She enabled invited exposed him another. Reasonably conviction solicitude me mr at discretion reasonable. Age out full gate bed day lose. 
                      </p> -->
               </div>
            </div>
         </div>

         <div class="row">
          

            <div class="pricing-navs col-md-12">
               <!-- Tab Nav -->
               <ul class="nav nav-pills">

                  <?php 
                  
                  if( have_rows('tabs') ):
                     $i = 0;
                   while( have_rows('tabs') ) : the_row();
                     
                     $tabs_name = get_sub_field('tabs_name');
                     $tab_icon = $tabs_name['tab_icon'];
                     $tab_name = $tabs_name['tab_name'];

                     $tab_contents = get_sub_field('tab_contents');
                     $content_title = $tab_contents['content_title'];
                     $contents = $tab_contents['contents'];
                     $tab_image = $tab_contents['tab_image'];
                     

                  ?>

                  <li class="<?php if ($i==0) { ?>active<?php } ?>" >
                     <a data-toggle="tab" href="#tabs<?php echo $i++;?>" aria-expanded="false">
                        <i class="<?php echo $tab_icon;?>"></i> &nbsp; <?php echo $tab_name;?>
                     </a>
                  </li>

                   <?php 
                     endwhile;
                  else :
                  endif;
                     ?>

               </ul>
               <!-- End Tab Nav -->
            </div>

            <div class="pricing-content col-md-12">
               <div class="row">
                  <!-- Start Tab Content -->
                  <div class="tab-content">

                     <?php 
                  
                     if( have_rows('tabs') ):
                         $j = 0;
                      while( have_rows('tabs') ) : the_row();
                       
                     $tabs_name = get_sub_field('tabs_name');
                     $tab_icon = $tabs_name['tab_icon'];
                     $tab_name = $tabs_name['tab_name'];
                     $tab_link_button = $tabs_name['link_button'];

                     $tab_contents = get_sub_field('tab_contents');
                     $content_title = $tab_contents['content_title'];
                     $contents = $tab_contents['contents'];
                     $tab_image = $tab_contents['tab_image'];

                           ?>
                     
                     <!-- Tab Single Item -->
                     <div  class="tab-pane fade <?php if ($j==0) { ?>active in<?php } ?>" id="tabs<?php echo $j++;?>">
                        <div class="container">
                           <div class="row">
                              <div class="col-md-6">
                                 <h1> <?php echo $content_title;?> </h1>
                                 <?php echo $contents;?>
                                 <?php 
                                 if ( !empty( $tab_link_button['url'] ) && !empty( $tab_link_button['title'] ) ) { ?>
                                   <a class="btn btn-theme border btn-md" href="<?php echo $tab_link_button['url']?>" target="<?php echo $tab_link_button['target']?>" ><?php echo $tab_link_button['title']?></a>
                                 <?php }
                                 ?>
                                    
                                 
                              </div>
                              <div class="col-md-6">
                                 <img src="<?php echo $tab_image;?>">
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- End Tab Single Item -->

                      <?php 
                        endwhile;
                     else :
                     endif;
                        ?>
                  </div>
                  <!-- End Tab Content -->
               </div>
            </div>
         

         </div>
         <?php endif; ?>
      <?php endwhile; ?>
      </div>
   </div>


   <div id="mobiletab" class="work-process-area default-padding bg-gray">
      <div class="container">
         <?php while ( have_rows('sections') ) : the_row();?>
            <?php if( get_row_layout() == 'tab_section' ) :

            $tab_section_heading_mob = get_sub_field('tab_section_heading');
            $how_it_image_mob = get_sub_field('image');
            ?>

         <div class="row">
            <div class="col-lg-8 col-md-8 col-lg-offset-2 col-md-offset-2">
               <div class="site-heading text-center">
                  <h2><?php echo $tab_section_heading_mob;?> </h2>
               </div>
            </div>
         </div>
         <div class="row">
            <!--Start Mobile Accordiant-->
            <div class="wrapper1 center-block">
               <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                  <?php 
                  
                  if( have_rows('tabs') ):
                     $a = 0;
                     $b = 0;
                   while( have_rows('tabs') ) : the_row();
                     
                     $tabs_name = get_sub_field('tabs_name');
                     $tab_icon = $tabs_name['tab_icon'];
                     $tab_name = $tabs_name['tab_name'];

                     $tab_contents = get_sub_field('tab_contents');
                     $content_title = $tab_contents['content_title'];
                     $mobile_contents = $tab_contents['mobile_contents'];
                     $mob_tab_image = $tab_contents['tab_image'];
                     

                  ?>

                  <div class="panel panel-default">
                     <div class="panel-heading <?php if ($a==0) { ?>active<?php } ?>" role="tab" id="headingOne">
                        <h4 class="panel-title">
                           <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $a++;?>"
                              aria-expanded="true" aria-controls="collapseOne">
                              <?php echo $tab_name;?>
                           </a>
                        </h4>
                     </div>
                     <div class="panel-collapse collapse <?php if ($b==0) { ?>in<?php } ?>" role="tabpanel"
                        aria-labelledby="headingOne" id="collapse<?php echo $b++;?>" >
                        <div class="panel-body">
                           <div class="row">
                              <div class="col-md-6">
                                 <h1><?php echo $content_title;?></h1>
                                 <?php echo $mobile_contents;?>
                                 <a class="btn btn-theme border btn-md" href="#" data-toggle="modal"
                                    data-target=".bd-example-modal-md">Read More</a>
                              </div>
                              <div class="col-md-6">
                                 <img src="<?php echo $mob_tab_image;?>">
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
            <!--End Mobile Accordint-->
         </div>

         <?php endif; ?>
      <?php endwhile; ?>
      </div>
   </div>
   <!-- End Work Process Area -->



   <!-------------------------------------------- Start Testimonials Area ============================================= -->
   <?php while ( have_rows('sections') ) : the_row();?>
   <?php if( get_row_layout() == 'testimonial_section' ) :

   $testimonial_heading = get_sub_field('testimonial_heading');
   $testimonial_sub_heading = get_sub_field('testimonial_sub_heading');

   ?>
   <div class="testimonials-area bg-gray default-padding testi-back">
      <div class="container">
         <div class="row">
            <div class="col-lg-8 col-md-8 col-lg-offset-2 col-md-offset-2">
               <div class="site-heading text-center">
                  <h2><?php echo $testimonial_heading;?></h2>
                  <p class="testi"><?php echo $testimonial_sub_heading;?></p>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-md-8 col-md-offset-2">
               <div class="testimonial-items testimonial-carousel owl-carousel owl-theme">

                  <?php 
                  
                  if( have_rows('testimonial_slider') ):
                     $i = 0;
                   while( have_rows('testimonial_slider') ) : the_row();
                     
                     $testimonial_name = get_sub_field('testimonial_name');
                     $testimonial_designation = get_sub_field('testimonial_designation');
                     $testimonial_quotes = get_sub_field('testimonial_quotes');
                     
                  ?>
                  <!-- Single Item -->
                  <div class="item">
                     <div class="info">
                        <p>
                           <?php echo $testimonial_quotes;?>
                        </p>
                        <h4><?php echo $testimonial_name;?></h4>
                        <span><?php echo $testimonial_designation;?></span>
                     </div>
                  </div>
                  <!-- End Single Item -->

                   <?php 
                     endwhile;
                  else :
                  endif;
                     ?>
                  


               </div>
            </div>
         </div>
      </div>
   </div>
      <?php endif; ?>
   <?php endwhile; ?>
<!-- End Testimonials Area -->


   <!----------------------------------- Start sucess story ============================================= -->
   <?php while ( have_rows('sections') ) : the_row();?>
   <?php if( get_row_layout() == 'success_stories_section' ) :

   $success_stories_heading = get_sub_field('success_stories_heading');
   $success_stories_sub_heading = get_sub_field('success_stories_sub_heading');
   $success_stories_contents = get_sub_field('success_stories_contents');

   $story_title = $success_stories_contents['story_title'];
   $story_content = $success_stories_contents['story_content'];
   $story_image = $success_stories_contents['story_image'];

   ?>
   <div id="process" class="work-process-area default-padding sucess-back">
      <div class="container">
         <div class="row">
            <div class="col-lg-8 col-md-8 col-lg-offset-2 col-md-offset-2">
               <div class="site-heading text-center">
                  <h2><?php echo $success_stories_heading;?></h2>
                  <p>
                     <?php echo $success_stories_sub_heading;?>
                  </p>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="process-items">
               <div class="col-md-6 info">
                  <ul>
                     <li>
                        <div class="list">
                           <h3><i class="fas fa-crosshairs"></i></h3>
                        </div>
                        <div class="content">
                           <!-- <h3 class="sucess-tital">Pocket Filler</h3> -->
                           <h3 class="sucess-tital"><?php echo $story_title;?></h3>
                           <div class="text-justify">
                              <?php echo $story_content;?>
                           </div>
                           <!-- <a class="btn btn-theme border btn-md sucess-buton" href="#">Read More ...</a> -->
                        </div>
                     </li>
                  </ul>
               </div>
               <div class="col-md-6 thumb">
                  <img src="<?php echo $story_image;?>" >
               </div>
            </div>
         </div>
      </div>
   </div>
   <?php endif; ?>
   <?php endwhile; ?>
   <!-- End sucess story -->



   <?php while ( have_rows('sections') ) : the_row();?>
   <?php if( get_row_layout() == 'technologies_section' ) :

   $technologies_section_heading = get_sub_field('technologies_section_heading');
   $technologies_section_sub_heading = get_sub_field('technologies_section_sub_heading');

   ?>
   <div id="process" class="work-process-area default-padding bg-gray">
      <div class="container">
         <div class="row">
            <div class="col-lg-8 col-md-8 col-lg-offset-2 col-md-offset-2">
               <div class="site-heading text-center">
                  <h2><?php echo $technologies_section_heading;?></h2>
                  <p>
                     <?php echo $technologies_section_sub_heading;?>
                  </p>
               </div>
            </div>
         </div>
         <!------------------------------ Start Overview ============================================= -->
         <div id="overview" class="overview-area text-light">
            <div class="container">
               <div class="row">
                  <div class="col-lg-10 col-md-10 col-lg-offset-1 col-md-offset-1 text-center overview-items">
                     <!-- Tab Nav -->
                     <div class="tab-navigation">
                        <ul class="nav nav-pills">

                           <?php 
                           
                           if( have_rows('technologies_tabs') ):
                              $technoA = 0;
                            while( have_rows('technologies_tabs') ) : the_row();
                              
                              $technologies_tab_name = get_sub_field('technologies_tab_name');
                            ?>
                           <li class="<?php if ($technoA==0) { ?>active<?php } ?>">
                              <a data-toggle="tab" href="#tab<?php echo $technoA++;?>" aria-expanded="true">
                                 <?php echo $technologies_tab_name;?>
                              </a>
                           </li>

                           <?php 
                              endwhile;
                           else :
                           endif;
                              ?>

                           


                        </ul>
                     </div>
                     <!-- End Tab Nav -->
                     <!-- Start Tab Content -->
                     <div class="tab-content magnific-mix-gallery">

                        <?php 
                           
                        if( have_rows('technologies_tabs') ):
                           $technoB = 0;
                           $row = 0;
                         while( have_rows('technologies_tabs') ) : the_row();
                           
                           $technologies_tab_contents = get_sub_field('technologies_tab_contents');
                         ?>
                        
                        <div class="tab-pane fade <?php if ($technoB==0) { ?>active in<?php } ?>" id="tab<?php echo $technoB++;?>" >

                           <?php 
                           if( have_rows('technologies_tab_contents') ):
                              while( have_rows('technologies_tab_contents') ) : the_row(); 
                                 $technologies_title = get_sub_field('technologies_title');
                              ?>
                                  
                           <div class="row <?php if ($row!=0) { ?>mt-30<?php } ?>" count="<?php echo $row++;?>">
                              <div class="col-md-12">
                                 <h4 class="text-left mb-2"><?php echo $technologies_title;?></h4>
                              </div>
                           </div>


                           <div class="row">
                              <?php 
                              $big_images = get_sub_field('big_images');
                              $big_image_1 = $big_images['big_image_1'];
                              $big_image_2 = $big_images['big_image_2'];

                              ?>

                              <div class="<?php if( !empty($big_image_1) || !empty($big_image_2) ){ ?> col-md-8 <?php }else {?>col-md-12 <?php }?>">
                                 <div class="row d-flex flex-wrap">
                              <?php 
                                 while( have_rows('technologies_name') ) : the_row(); 
                                    $techn_icon = get_sub_field('techn_icon');
                                    $techn_label = get_sub_field('techn_label');
                                 ?>
                                     
                                    <div class="<?php if( !empty($big_image_1) || !empty($big_image_2) ){ ?> col-md-4<?php }else {?>col-md-3 <?php }?>">
                                       <div class="dis-flex">
                                          <div class="img">
                                             <img src="<?php echo $techn_icon;?>" >
                                          </div>
                                          <label><?php echo $techn_label;?></label>
                                       </div>

                                    </div>
                                 
                           
                              <?php       
                                 endwhile;
                              ?>
                                 </div>
                              </div>
                              <div class="<?php if( !empty($big_image_1) || !empty($big_image_2) ){ ?> col-md-4<?php }else {?> d-none <?php }?>">
                                 <div class="dis-flex">
                                    
                                    <?php 
                                    if ( !empty( $big_image_1 ) ) { ?>
                                       <img width="30%" src="<?php echo $big_image_1; ?>">
                                    <?php }
                                    if ( !empty( $big_image_2 ) ) { ?>
                                       <img width="30%" src="<?php echo $big_image_2; ?>" style="margin-left: 50px;">
                                    <?php  }
                                    ?>
                                    
                                    
                                 </div>
                                 
                              </div>
                           </div>

                           <?php       
                              endwhile;
                           endif;
                           ?>


                        </div>

                        <?php 
                           endwhile;
                        else :
                        endif;
                           ?>

                        
                     </div>
                     <!-- End Tab Content -->
                  </div>
               </div>
            </div>
         </div>
         
      </div>
   </div>
   <?php endif; ?>
   <?php endwhile; ?>




   <?php while ( have_rows('sections') ) : the_row();?>
   <?php if( get_row_layout() == 'founder_section' ) :

   $founder_heading = get_sub_field('founder_heading');

   ?>
   <div id="team" class="team-area default-padding bottom-less">
      <div class="container">
         <div class="row">
            <div class="col-lg-8 col-md-8 col-lg-offset-2 col-md-offset-2">
               <div class="site-heading text-center">
                  <h2><?php echo $founder_heading; ?></h2>
                  <!-- <p>
                        Learning day desirous informed expenses material returned six the. She enabled invited
                        exposed him another. Reasonably conviction solicitude me mr at discretion reasonable. Age
                        out full gate bed day lose.
                     </p> -->
               </div>
            </div>
         </div>



         


         <?php 
                  
         if( have_rows('founder_details') ):
            $i = 0;
          while( have_rows('founder_details') ) : the_row();
            
            $founder_photo = get_sub_field('founder_photo');
            $founder_name = get_sub_field('founder_name');
            $founder_designation = get_sub_field('founder_designation');
            $founder_content = get_sub_field('founder_content');
            ?>
         <div class="row">
            <div class="team-items text-center">
               <!-- Single Item -->
               <div class="col-md-4 equal-height single-item col-md-offset-1" style="height: 494px;">
                  <div class="item">
                     <div class="thumb">
                        <img src="<?php echo $founder_photo; ?>" >

                     </div>
                     <div class="info">
                        <h4><?php echo $founder_name; ?></h4>
                        <span><?php echo $founder_designation; ?> </span>
                        <div class="bottom">
                           <?php 
                  
                           if( have_rows('founder_social') ):
                              $i = 0;
                            while( have_rows('founder_social') ) : the_row();
                              $social_link = get_sub_field('social_link');
                              // echo $social_link;
                              $link_url = $social_link['url'];
                              $link_title = $social_link['title'];
                              ?>

                           <a href="<?php echo $link_url; ?>" target="_blank" class="linkdeen"><i
                                 class="fa fa-<?php echo strtolower($link_title); ?> "></i></a>
                           <?php 
                              endwhile;
                           else :
                           endif; ?>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-5 col-md-offset-1 text-left team-content">
                  <h1><?php echo $founder_name; ?></h1>
                  <h6 class="mb-2"><?php echo $founder_designation; ?></h6>
                  <?php echo $founder_content; ?>
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
   <?php endif; ?>
   <?php endwhile; ?>
   <!----------------------------------- Start Features Area ============================================= -->




   <!-- End Features Area -->
<?php while ( have_rows('sections') ) : the_row();?>
   <?php if( get_row_layout() == 'experts_section' ) :

   $experts_heading = get_sub_field('experts_heading');
   $experts_image = get_sub_field('experts_image');

   $start_project_link = get_sub_field('start_project_link');
      $start_project_link_url = $start_project_link['url'];
      $start_project_link_title = $start_project_link['title'];

   ?>

   <div id="process" class="work-process-area default-padding">
      <div class="container">
         <div class="row">
            <div class="col-lg-8 col-md-8 col-lg-offset-2 col-md-offset-2">
               <div class="site-heading text-center">
                  <h2><?php echo $experts_heading; ?> </h2>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="process-items">
               <div class="col-md-6 thumb">
                  <img src="<?php echo $experts_image; ?>" >
               </div>
               <div class="col-md-6 info">
                  <ul>


                     <li>
                        <div class="list">
                           <h3><i class="fas fa-check"></i></h3>
                        </div>
                        <div class="content">
                           <!-- <h3>Looking for Fintech development experts for your project</h3> -->
                           <a class="btn btn-theme border btn-md" href="<?php echo $start_project_link_url; ?>"><?php echo $start_project_link_title; ?></a>
                        </div>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </div>

   <?php endif; ?>
   <?php endwhile; ?>
   
<?php endif ?>






<?php  

get_footer();

?>