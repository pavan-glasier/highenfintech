
<?php if( have_rows('customer_software_sections') ): ?>


   <?php while ( have_rows('customer_software_sections') ) : the_row();?>
   <?php  if( get_row_layout() == 'faqs_section' ) :?>
   <?php
   $custom_heading = get_sub_field('heading');
   $custom_sub_heading = get_sub_field('sub_heading');
   ?>
   <div id="process" class="work-step-area default-padding customer-sofware">
      <div class="container">

          <?php if ( !empty( $custom_heading ) || !empty( $custom_sub_heading ) ) { ?>
          <div class="row">
              <div class="col-lg-8 col-md-8 col-lg-offset-2 col-md-offset-2">
                    <div class="site-heading text-center">
                        <?php 
                        if ( !empty( $custom_heading ) ) { ?>
                            <h2><?php echo $custom_heading;?></h2>
                        <?php } ?>
                        <?php echo $custom_sub_heading;?>
                    </div>
              </div>
          </div>
          <?php } ?>
          <div class="row">
              <div class="work-step-items">
                  <!-- Single Item -->

                  <?php 
                              
                    if( have_rows('faq_box') ):
                        $ab = 1;
                        $cd = 1;
                    while( have_rows('faq_box') ) : the_row();
                        $faq_image = get_sub_field('faq_image');
                        $faq++;

                        $accordion = preg_replace('/[^A-Za-z0-9\-]/','',$faq_image);
                        
                    ?>

                  <div class="single-item <?php if ($faq%2==0) { ?>reverse<?php } ?>">
                      <div class="col-md-12">
                          <div class="item">
                              <div class="row">
                                  <div class="col-md-6 thumb">
                                      <img src="<?php echo $faq_image;?>" >
                                  </div>
                                  <div class="col-md-6 info">
                                    <div class="acd-items acd-arrow">

                                       <div class="panel-group symb" id="<?php echo $accordion;?>">

                                           <?php 
                                          
                                            if( have_rows('faq') ):
                                                $c = 1;
                                                $d = 1;
                                            while( have_rows('faq') ) : the_row();
                                                $faq_title = get_sub_field('faq_title');
                                                $faq_content = get_sub_field('faq_content');


                                                $whatonearth = preg_replace('/[^A-Za-z0-9\-]/','',$faq_title);
                                                
                                            ?>

                                           <div class="panel panel-default">
                                               <div class="panel-heading">
                                                   <h4 class="panel-title">
                                                       <a class="<?php if ($c!=1) { ?>collapsed<?php } ?>" data-toggle="collapse" data-parent="#<?php echo $accordion;?>" href="#<?php echo $whatonearth;?>" >
                                                        <?php echo $faq_title;?>
                                                       </a>
                                                   </h4>
                                               </div>
                                               <div class="panel-collapse collapse <?php if ($d==1) { ?>in<?php } ?>" id="<?php echo $whatonearth;?>" >
                                                   <div class="panel-body mobile-app-develop">
                                                   <?php echo $faq_content;?>
                                                   </div>
                                               </div>
                                           </div>
                                               <?php 
                                                    $c++;
                                                    $d++;
                                                    endwhile;
                                                    else :
                                                    endif;
                                                ?>
                                        </div>
                                   </div>
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
                  <!-- End Single Item -->
                  
              </div>
          </div>
      </div>
  </div>

    <?php endif; ?>
<?php endwhile; ?>


<?php endif ?>


