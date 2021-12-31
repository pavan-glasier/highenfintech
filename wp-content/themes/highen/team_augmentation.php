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
<!-- MOBILE APP DEVELOPMENT Section -->

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
                    <img src="<?php echo $section_1_image; ?>" alt="Thumb">
                </div>
                <div class="col-md-6 info">
                    <ul>
                        <li>
                            <div class="content">
                                <p class="text-justify">
                                <h4><strong><?php echo $section_1_title; ?></strong></h4>
                                <?php echo $section_1_content; ?>
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
                                            <img src="<?php echo $section_2_image;?>" alt="Thumb">
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



<?php while ( have_rows('sections') ) : the_row();?>
   <?php  if( get_row_layout() == 'section_3' ) :?>

    
    <section class="work-process-area default-padding border-top sucess-back">
        <div class="container">
        <?php 
                  
            if( have_rows('image_content_section_3') ):
                //$a = 1;
            while( have_rows('image_content_section_3') ) : the_row();
            $section_3_image = get_sub_field('image');
            $section_3_title = get_sub_field('title');
            $section_3_content = get_sub_field('content');
			$section_3_link_button = get_sub_field('link_button');
        
            ?>
            <div class="row clearfix">
                <div class="col-lg-6 col-md-6 col-sm-12 content-column">
                    <div id="content_block_01">
                        <div class="content-box">
                            <div class="sec-title">
                                <h2><?php echo $section_3_title; ?></h2>
                            </div>
                            <?php echo $section_3_content; ?>
							
							<?php
								if( (!empty($section_3_link_button)) )   {
							?>
							<a class="btn btn-theme border btn-md mt-30 mb-10" href="<?php echo $section_3_link_button['url'];?>"><?php echo $section_3_link_button['title'];?></a>
							<?php }?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 image-column">
                    <img class="w-70 ml-auto" src="<?php echo $section_3_image; ?>" alt="Thumb">
                </div>
            </div>
            <?php 
        endwhile;
    else :
    endif;
        ?>
        </div>
    </section>

    
    <?php endif; ?>
<?php endwhile; ?>



</div>


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
                 
               

                  <?php endwhile; ?>
               <?php endif; ?>
               <div class="row clearfix">
                  <div class="col-lg-6 col-md-6 col-sm-12 ">
                     <div id="annual" class="tab-pane">
                        <div class="acd-items acd-arrow mt-30">
                           <div class="panel-group symb" id="accordion">
                              <div class="panel panel-default">
                                 <div class="panel-heading">
                                    <h4 class="panel-title">
                                       <a data-toggle="collapse" data-parent="#accordion" href="#ac1">
                                          Sidechain Customization
                                       </a>
                                    </h4>
                                 </div>
                                 <div id="ac1" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                       <p>
                                          Expand the possibilities of blockchains already in use by allowing them to expand, grow and collaborate. Consider incentivized crypto mining and asset mobility at fixed exchange rates, using tools like the two-way peg with symmetry.
                                       </p>
                                    </div>
                                 </div>
                              </div>
                              <div class="panel panel-default">
                                 <div class="panel-heading">
                                    <h4 class="panel-title">
                                       <a data-toggle="collapse" data-parent="#accordion" href="#ac2">
                                          The Best AI-Powered Solutions For Fintech Business 
                                       </a>
                                    </h4>
                                 </div>
                                 <div id="ac2" class="panel-collapse collapse">
                                    <div class="panel-body">
                                       <p>
                                          To meet specific business requirements such as collaboration in learning and analyzing data, detection of intrusions into the application layer, and intelligent use of open data. Enhance the performance of operational systems by using our AI integration services.
                                       </p>
                                    </div>
                                 </div>
                              </div>
                              <div class="panel panel-default">
                                 <div class="panel-heading">
                                    <h4 class="panel-title">
                                       <a data-toggle="collapse" data-parent="#accordion" href="#ac3">
                                          Zero-knowledge Application for proof
                                       </a>
                                    </h4>
                                 </div>
                                 <div id="ac3" class="panel-collapse collapse">
                                    <div class="panel-body">
                                       <p>
                                          Achieving business goals of paramount importance, like confidentiality, security, integrity, and verifying computing. Make it possible to enable anonymity in voting and on-chain scaling and secure B2B information exchanges to support real-time logistics and supply chain collaborations
                                       </p>
                                    </div>
                                 </div>
                              </div>
                              <div class="panel panel-default">
                                 <div class="panel-heading">
                                    <h4 class="panel-title">
                                       <a data-toggle="collapse" data-parent="#accordion" href="#ac4">
                                          Blockchain Performance Engineering
                                       </a>
                                    </h4>
                                 </div>
                                 <div id="ac4" class="panel-collapse collapse">
                                    <div class="panel-body">
                                       <p>
                                          Improve the tools used throughout the development process and increase non-functional requirements like performance and speed. Be sure to adhere to the conditions at all levels of service and improve the performance of applications.
                                       </p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 image-column">
                     <div id="image_block_01">
                        <div class="image-box">
                           <figure class="image js-tilt">
                              <img src="img/img-2-blockchain.png">
                           </figure>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

         </section>

      <?php endif; ?>
<?php endwhile; ?> 

         <section class="faq-section faq-page-section sec-pad default-padding">
            <div class="auto-container">
               <div class="row clearfix">
                  <div class="col-lg-6 col-md-12 col-sm-12 ">
                    <img src="img/img-3-blockchain.png">
                  </div>
                  <div class="col-lg-6 col-md-12 col-sm-12 content-column">
                     <div id="content_block_06">
                        <div class="content-box">
                           <div class="sec-title">
                              <h2>Blockchain-Based FinTech Solutions</h2>
                           </div>
                           <div class="text">
                              <p>Cryptocurrency is the new oil. We at hyghen are pioneers in building simple and effective
                                 platforms, solutions and applications. Our tech products seamlessly integrate with the
                                 global financial systems using simple APIs.</p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>

         <section class="work-process-area default-padding border-top sucess-back">
            <div class="container">
                <div class="row clearfix">
                    <div class="col-lg-6 col-md-6 col-sm-12 content-column">
                        <div id="content_block_01">
                            <div class="content-box">
                                <div class="sec-title">
                                    <h2>Our Blockchain Product Development Methodology</h2>
                                </div>
                                <ul class="list-item clearfix">
                                    <li>Our blockchain team follows the best practices for development to ensure the timely delivery and deployment of blockchain-related solutions.</li>
                                    <li>Gathering requirements as well as application roadmaps, analysis of use cases</li>
                                    <li>Definition of the technical architecture, intelligent contracts agreements, and ensuring compliance with regulatory requirements</li>
                                    <li>Designing modules and components and incorporating the intelligent contract terms</li>
                                    <li>Testing on testnet servers Testing, deployment on mainnet, and then going live</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 image-column">
                     <img src="img/img-4-blockchain.png">
                  </div>
                </div>
            </div>
        </section>

    


</div>

<?php endif; ?>
<?php get_footer(); ?>
