

<?php if( have_rows('mvp_development_sections') ): ?>
<!-- Fintech Solution All Sections -->

<div class="pricing-area default-padding">
<?php while ( have_rows('mvp_development_sections') ) : the_row();?>
   <?php  if( get_row_layout() == 'explore_mvp_section' ) :?>
   <?php
   $explore_mvp_image = get_sub_field('image');
   $explore_mvp_title = get_sub_field('title');
   $explore_mvp_content = get_sub_field('content');
   ?>

    <div id="process" class="work-process-area ">
        <div class="container">
            <div class="row pb-70">
                <div class="col-md-6">
                    <img src="<?php echo $explore_mvp_image; ?>" >
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 mobile-app-develop">
                     <div id="annual" class="tab-pane">
                        <div class="site-heading text-center">
                           <h2><?php echo $explore_mvp_title; ?></h2>
                        </div>
                        <?php echo $explore_mvp_content; ?>
                     </div>
                  </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
<?php endwhile; ?>



<?php while ( have_rows('mvp_development_sections') ) : the_row();?>
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



<?php while ( have_rows('mvp_development_sections') ) : the_row();?>
   <?php  if( get_row_layout() == 'cta_section' ) :?>

        <?php 
                  
            if( have_rows('cta_image_content') ):
                //$a = 1;
            while( have_rows('cta_image_content') ) : the_row();
            $cta_image = get_sub_field('image');
            $cta_title = get_sub_field('title');
            $cta_content = get_sub_field('content');
            $cta_link_button = get_sub_field('link_button');
        
            ?>

    <section class="container">
        <div class="cta-box">
             <div class="row">
                <div class="col-md-6">
                   <img src="<?php echo $cta_image; ?>" >
                </div>
                <div class="col-md-6">
                   <h1><?php echo $cta_title; ?></h1>

                    <?php
                        if( (!empty($cta_link_button)) )   {
                     ?>
                     <a class="btn btn-theme border btn-md mt-30 mb-10 text-center" href="<?php echo $cta_link_button['url'];?>"><?php echo $cta_link_button['title'];?></a>
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