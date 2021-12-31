
<?php if( have_rows('web_development_sections') ): ?>

<div class="default-padding">
	<?php while ( have_rows('web_development_sections') ) : the_row();?>
   <?php  if( get_row_layout() == 'custom_web_section' ) :?>
   <?php
   $custom_web_image = get_sub_field('custom_web_image');
   $custom_web_title = get_sub_field('custom_web_title');
   $custom_web_content = get_sub_field('custom_web_content');
   ?>

  <div id="process" class="work-process-area ">
      <div class="container">
          <div class="row pb-70">
              <div class="col-md-6">
                  <img src="<?php echo $custom_web_image;?>" />
              </div>
              <div class="col-md-6 info">
                  <ul>
                      <li>
                          <div class="content">
                              <p class="text-justify">
                              <h4><strong><?php echo $custom_web_title;?></strong></h4>
                              <?php echo $custom_web_content;?>
                          </div>
                      </li>
                  </ul>
              </div>
          </div>
      </div>
  </div>

  	<?php endif; ?>
<?php endwhile; ?>


  <?php while ( have_rows('web_development_sections') ) : the_row();?>
   <?php  if( get_row_layout() == 'section_image_content' ) :?>
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
                  
                        if( have_rows('image_content_section') ):
                            //$a = 1;
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

<?php endif ?>


