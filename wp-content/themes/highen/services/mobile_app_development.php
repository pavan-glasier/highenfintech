


<?php if( have_rows('mobile_app_sections') ): ?>

<!-- MOBILE APP DEVELOPMENT Section -->
<?php while ( have_rows('mobile_app_sections') ) : the_row();?>
   <?php  if( get_row_layout() == 'startups_enterprises' ) :?>
   <?php
   $startups_enterprises_image = get_sub_field('startups_enterprises_image');
   $startups_enterprises_title = get_sub_field('startups_enterprises_title');
   $startups_enterprises_content = get_sub_field('startups_enterprises_content');
   ?>
	<div class="pricing-area default-padding">
      <div class="container">
         <section class="mobile-app-section">
            <div class="auto-container">
               <div class="row clearfix">
                  <div class="col-lg-6 col-md-6 col-sm-12 image-column">
                     <div id="image_block_01">
                        <div class="image-box">
                           <figure class="image js-tilt"><img src="<?php echo $startups_enterprises_image;?>" >
                           </figure>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mobile-app-develop">
                     <div id="annual" class="tab-pane">
                        <div class="site-heading text-center">
                           <h2><?php echo $startups_enterprises_title;?></h2>
                        </div>
                        <?php echo $startups_enterprises_content;?>
                     </div>

                  </div>
               </div>
            </div>
         </section>
      </div>
   </div>
	<?php endif; ?>
<?php endwhile; ?>


<!-- MOBILE APP DEVELOPMENT Section 2 -->
<?php while ( have_rows('mobile_app_sections') ) : the_row();?>
   <?php  if( get_row_layout() == 'tab_section' ) :?>
   <section class="bg-gray default-padding">
      <div class="container">
      <div class="row">
         <div class="pricing-navs col-md-12">
            <!-- Tab Nav -->
            <ul class="nav nav-pills">
			<?php 
                  
				if( have_rows('tabs') ):
					$a = 1;
				while( have_rows('tabs') ) : the_row();
					$tab_name = get_sub_field('tab_name');
				?>

				<li class="<?php if ($a==1) { ?>active<?php } ?>" >
					<a data-toggle="tab" href="#tabs<?php echo $a++;?>" aria-expanded="false"><?php echo $tab_name;?>
					</a>
				</li>

				<?php 
					endwhile;
				else :
				endif;
					?>
               <!-- <li class=""><a data-toggle="tab" href="#android-app" aria-expanded="true">Android App Development</a></li>
               <li class=""><a data-toggle="tab" href="#mobile-app" aria-expanded="true">Mobile Application Dashboard</a></li> -->
            </ul>
            <!-- End Tab Nav -->
         </div>

         <div class="pricing-content col-md-12">
            <div class="row">
               <!-- Start Tab Content -->
               <div class="tab-content">
			   <?php 
                  
				  if( have_rows('tabs') ):
					  $b = 1;
				  while( have_rows('tabs') ) : the_row();
					  
					  $tab_contents = get_sub_field('tab_contents');
					  $content_title = $tab_contents['title'];
					  $tab_content = $tab_contents['content'];
					  $tab_image = $tab_contents['image'];
					  
  
				  ?>

				  <!-- Tab Single Item -->
                  <div class="tab-pane fade <?php if ($b==1) { ?>active in<?php } ?> " id="tabs<?php echo $b++;?>">
                     <div class="container">
                        <div class="row">
                           <div class="col-md-6">
                              <h1><?php echo $content_title;?></h1>
                              <p> 
							  <?php echo $tab_content;?>
							  </p>
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
   </div>
   </section>
   <?php endif; ?>
<?php endwhile; ?>




<?php while ( have_rows('mobile_app_sections') ) : the_row();?>
   <?php if( get_row_layout() == 'development_process' ) :?>
	<?php
   $development_process_heading = get_sub_field('development_process_heading');
   ?>
<div class="pricing-area default-padding sucess-back">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-md-8 col-lg-offset-2 col-md-offset-2">
				<div class="site-heading text-center">
					<h3><b> <?php echo $development_process_heading;?> </b></h3>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="pricing-items">
				<?php 
                  
				if( have_rows('development_process_boxes') ):
					//$a = 1;
				while( have_rows('development_process_boxes') ) : the_row();
					$box_name = get_sub_field('name');
					
				?>

				<div class="col-lg-3 col-md-3 single-item">
					<div class="pricing-item">
						<ul>
							<li class="pricing-header">
								<h4><?php echo $box_name;?></h4>
							</li>
							<?php 
                  
								if( have_rows('features') ):
									//$a = 1;
								while( have_rows('features') ) : the_row();
									$box_text = get_sub_field('text');
									
								?>
							<li><i class="fas fa-check"></i> <?php echo $box_text;?></li>

							<?php 
								endwhile;
							else :
							endif;
								?>
						</ul>
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
</div>
<?php endif; ?>
<?php endwhile; ?>



<?php while ( have_rows('mobile_app_sections') ) : the_row();?>
   <?php if( get_row_layout() == 'faqs_section' ) :?>
	<?php
   $faq_image = get_sub_field('faq_image');
   ?>
<div  class="faq-area default-padding  border-top">
   <div class="container">
       <div class="row">
           <div class="col-md-5 thumb">
               <img src="<?php echo $faq_image;?>" >
           </div>
           <div class="col-md-7 faq-items">
               <!-- Start Accordion -->
               <div class="acd-items acd-arrow">
                   <div class="panel-group symb" id="accordion">

							   <?php 
			                  
								if( have_rows('faq') ):
									$c = 1;
									$d = 1;
								while( have_rows('faq') ) : the_row();
									$faq_title = get_sub_field('faq_title');
									$faq_content = get_sub_field('faq_content');
									
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
               <!-- End Accordion -->
           </div>
       </div>
   </div>
</div>
<?php endif; ?>
<?php endwhile; ?>

<?php endif ?>


