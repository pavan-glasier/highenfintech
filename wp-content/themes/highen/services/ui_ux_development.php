
<?php if( have_rows('ui_ux_sections') ): ?>

<div class="">
   
  <?php while ( have_rows('ui_ux_sections') ) : the_row();?>
   <?php  if( get_row_layout() == 'section_image_content' ) :?>
   <?php
   $section_heading = get_sub_field('section_heading');
   $section_sub_heading = get_sub_field('section_sub_heading');
   ?>

    <section>
        <div id="" class="work-step-area pt-100 ui-ux">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-lg-offset-2 col-md-offset-2">
                        <div class="site-heading text-center">
                            <h2><?php echo $section_heading;?></h2>
                            <p>
                              <?php echo $section_sub_heading;?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="work-step-items">
                        <!-- Single Item -->
                        <?php 
                  
                        if( have_rows('image_content_section') ):
                            $x = 1;
                        while( have_rows('image_content_section') ) : the_row();
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
                                                <strong>0<?php echo $x++;?></strong> <h2><?php echo $section_2_title;?></h2>
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



<?php while ( have_rows('ui_ux_sections') ) : the_row();?>
   <?php  if( get_row_layout() == 'testimonial_sections' ) :?>
   <?php
   $background_image = get_sub_field('background_image');
   
   ?>
<?php if( have_rows('testimonial') ):?>
    <section class="testimonial-style-two text-center">
        <div class="pattern-layer" style="background-image: url(<?php echo $background_image; ?>);"></div>
 
          <div class="auto-container">
              <div class="row clearfix">
                  <div class="col-md-10 col-md-offset-1 inner-column">
                      <div class="testimonial-carousel-2 owl-carousel owl-theme owl-nav-none">
                        <?php 
                              
                        // if( have_rows('testimonial') ):
                        while( have_rows('testimonial') ) : the_row();
                            $testimonial_title = get_sub_field('title');
                            $testimonial_content = get_sub_field('content');
                            ?>

                          <div class="testimonial-content">
                              <div class="inner-box">
                                 <h3><b><?php echo $testimonial_title; ?></b></h3>
                                  <?php echo $testimonial_content; ?>
                              </div>
                          </div>
                            <?php 
                                endwhile;
                                
                            ?>

                      </div>
                  </div>
              </div>
          </div>
    </section>
    <?php 
    else :
    endif;?>

    <?php endif; ?>
<?php endwhile; ?>


</div>

<?php endif ?>


