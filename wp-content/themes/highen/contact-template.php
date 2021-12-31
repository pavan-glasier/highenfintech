<?php 

/**
* Template Name: Contact Us
*
*/

get_header();
?>
<?php if( have_rows('sections') ): ?>
   <?php while ( have_rows('sections') ) : the_row();?>
   <?php  if( get_row_layout() == 'main_heading' ) :?>
   <?php
   $heading = get_sub_field('heading'); ?>

   <section class="inner-wrap">
      <div class="container">
         <div class="row">
            <div class="col-md-12 inner-header">
               <h1><?php echo $heading;?></h1>
            </div>
         </div>
      </div>
   </section>
   <?php endif ?>
<?php endwhile; ?>
   
   <div class="default-padding">
      <div class="container">

       <?php while ( have_rows('sections') ) : the_row();?>
         <?php if( get_row_layout() == 'form_section' ) :?>
         <?php
         $main_title = get_sub_field('main_title'); 
         ?>

         <div class="row">
            <div class="col-lg-8 col-md-8 col-lg-offset-2 col-md-offset-2">
               <div class="site-heading text-center">
                  <h2><?php echo $main_title;?></h2>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="contact-items">
               <!-- Contact Form -->

               <div class="col-md-8 login-box">
                  <?php
                  $form_contact = get_sub_field('form_contact');
                  $form_shortcode = $form_contact['form'];
                  ?>
                  <?php echo do_shortcode( $form_shortcode );?>
                  

               </div>



               <div class="col-md-3 col-md-offset-1 contact-side">
                  <?php if( have_rows('form_contact') ): ?>
							<?php while ( have_rows('form_contact') ) : the_row(); ?>

                     <?php if( have_rows('contacts') ): ?>
							<?php while ( have_rows('contacts') ) : the_row(); ?>
                     
                     <?php 
                     $email_heading = get_sub_field('email_heading');
                     $email_phone = get_sub_field('email_phone');
                     ?>

                     <div class="item-bottom" style="">
                        <div class="item">
                           <i class="fas fa-envelope-open"></i>
                           <h4><?php echo $email_heading;?></h4>
                        </div>
                        <h2> <?php echo $email_phone;?></h2>
                     </div>
                      <?php endwhile; ?>
                     <?php endif ?>
                     <?php endwhile; ?>
                  <?php endif ?>

               </div>
            </div>
         </div>
         

         <!-- Address List -->
         <div class="address">
        

            <div class="row">
               <div class="col-lg-8 col-md-8 col-lg-offset-2 col-md-offset-2">
                  <div class="site-heading text-center">
                  <?php
                  $locations = get_sub_field('locations');
                  $locations_heading = $locations['locations_heading'];
                  ?>
                     <h2><?php echo $locations_heading;?></h2>
                  </div>
               </div>
            </div>
            <div class="address-list text-center col-md-12">
               <div class="item-box">


               <?php if( have_rows('locations') ): ?>
							<?php while ( have_rows('locations') ) : the_row(); ?>

                     <?php if( have_rows('addresses') ):
                        ?>
                        
							<?php while ( have_rows('addresses') ) : the_row(); ?>
                     
                     <?php 
                     $flag_icon = get_sub_field('flag_icon');
                     $office_name = get_sub_field('office_name');
                     $office_address = get_sub_field('office_address');
                     ?>

                     
                  <div class="col-md-6 equal-height single-item">
                     <div class="item">
                        <img src="<?php echo $flag_icon;?>">
                        <h4><?php echo $office_name;?></h4>
                        <p>
                        <?php echo $office_address;?>
                        </p>
                     </div>
                  </div>
                     
                  <!-- Single Item -->
                  
                  <!-- End Single Item -->
                  <?php endwhile; ?>
                     <?php endif ?>
                     <?php endwhile; ?>
                  <?php endif ?>

               </div>
            </div>
            

         </div>
         <!-- End Address List -->
         <?php endif ?>
         <?php endwhile; ?>

      </div>
   </div>
<?php endif ?>


<?php  

get_footer();

?>