<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage highen
 * @since Highen 1.0
 */
?>

<?php  $footer = new WP_Query( array( 'post_type' => 'footer' , 'order' => 'DESC', 'posts_per_page' => 1 ) );
while($footer->have_posts()) : $footer->the_post();?>
<!-- END -->


<!-- Start Footer 
         ============================================= -->
   <footer class="default-padding bg-gray">
      <div class="container">
         <div class="row">
            <div class="f-items">
               <div class="col-md-4 col-sm-6 equal-height item">
                  <div class="f-item">
                     <?php 
                        $columns = get_field('columns');
                        $column_1 = $columns['column_1'];
                        $logo = $column_1['logo'];

                     if( $logo ):
                        ?>
                         <img src="<?php echo $logo; ?>" alt="Logo" style="width: 250px;" />
                     <?php endif; ?>
                     <!-- <img src="<?php //echo get_template_directory_uri();?>/img/fhlogo.png" alt="Logo" style="width: 250px;"> -->
                     <p>
                        <!-- Our research and development wing keeps a close watch on new tech stacks, trends etc that are
                        changing the fintech landscape worldwide. -->
                        
                        <?php 
                        $about_us = $column_1['about_us'];
                           echo $about_us;
                        ?>
                     </p>
                     <div class="newsletter">
                        <h6>Newsletter</h6>
                        <?php 
                        $newsletter = $column_1['newsletter']; ?>
                        <?php echo do_shortcode( ' '. $newsletter .' ' ); ?>

                     </div>
                  </div>
               </div>
               <div class="col-md-4 col-sm-6 equal-height item">
                  <div class="f-item link">
                     <h4>Solutions</h4>


<?php 
$columns = get_field('columns');
$column_2 = $columns['column_2'];
$menu = $column_2['menu'];


//$menu = get_field( 'menu' );

function side_menu_fun($menu){
   return wp_nav_menu( array(
           'theme_location'    => $menu,
           'depth'             => 2,
           'container'         => 'ul',
           'menu_class'        => 'link' 
        ) );
}
side_menu_fun($menu);
?>

                  </div>
               </div>
               <div class="col-md-4 col-sm-6 equal-height item">
                  <div class="f-item twitter-widget">
                     


                     <?php 

                     $columns = get_field('columns');
                     $column_3 = $columns['column_3'];
                     $rows = $column_3['addresses'];

                     if( $rows ) {
                         foreach( $rows as $row ) {
                             echo '<h5 class="title12">';
                              echo $row['name'];
                             echo '</h5>';
                             echo '<p>';
                              echo $row['address'];
                             echo '</p>';
                         }
                     } ?>
                     <div class="address">
                        <ul>
                           <?php 
                           $columns = get_field('columns');
                           $column_3 = $columns['column_3'];
                           $email = $column_3['email'];
                           $phone = $column_3['phone'];
                           $website = $column_3['website'];
                           

                           if( $email ):
                           ?>
                           <li>
                              <div class="icon">
                                 <i class="fas fa-envelope"></i>
                              </div>
                              <div class="info">
                                 <h5>Email:</h5>
                                 <span><?php echo $email;?></span>
                              </div>
                           </li>
                           <?php endif; ?>
                           
                           <?php
                           if( $phone ):
                           ?>
                           <li>
                              <div class="icon">
                                 <i class="fas fa-phone"></i>
                              </div>
                              <div class="info">
                                 <h5>Phone:</h5>
                                 <span><?php echo $phone;?></span>
                              </div>
                           </li>
                           <?php endif; ?>

                           <?php
                           if( $website ):
                           ?>
                           <li>
                              <div class="icon">
                                 <i class="fas fa-desktop"></i>
                              </div>
                              <div class="info">
                                 <h5>Website:</h5>
                                 <span><?php echo $website;?></span>
                              </div>
                           </li>
                           <?php endif; ?>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- Start Footer Bottom -->
         <div class="footer-bottom">
            <div class="row">
               <div class="col-lg-12 col-md-12">
                                    

                  <?php 
                  $footer_bottom = get_field('footer_bottom');
                  $copy_right = $footer_bottom['copy_right'];

                  $social_icons = $footer_bottom['social_icons'];
                  $s_name = $social_icons['name'];
                  $s_link = $social_icons['link'];

                  if( $copy_right ):
                  ?>
                  <div class="col-lg-6 col-md-6 col-sm-7">
                     <p> <?php echo $copy_right; ?></p>
                  </div>
                  <?php endif; ?>
                  
                  <div class="col-lg-6 col-md-6 col-sm-5 text-right social">
                     <ul>

                     <?php 
                       if( have_rows('footer_bottom') ): 
                        while( have_rows('footer_bottom') ): the_row(); 
                        if( have_rows('social_icons') ):

                         // Loop through rows.
                         while( have_rows('social_icons') ) : the_row();

                           $name = get_sub_field('name');
                           $icon = get_sub_field('link');
                           $link_target = $icon['target'] ? $icon['target'] : '_self';
                           echo '<li> <a href="'.$icon['url'].'" target="'.$link_target.'"><i class="fa fa-'.strtolower($name).'"></i></a></li>';
                               
                         endwhile;
                        else :

                        endif;
                        endwhile;
                     endif;

                        ?>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
         <!-- End Footer Bottom -->
      </div>
   </footer>


   <!------------------------------------------
         ===========================================-->
   <div class="modal fade bd-example-modal-md contact-popup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">

      <div class="modal-dialog modal-md">

         <section>
            <div class="container">
               <div class="contactInfo">
                  <div class="box">
                     <div class="content-box">
                        <?php 
                        $popup_form = get_field('popup_form');
                           $popup_heading = $popup_form['heading'];
                           $pop_link_button = $popup_form['link_button'];

                           

                        ?>
                        <h2><?php echo $popup_heading;?></h2>
                        <div class="text-center">
                           <?php 
                           if( $pop_link_button ): 
                               $link_url = $pop_link_button['url'];
                               $link_title = $pop_link_button['title'];
                               $link_target = $pop_link_button['target'] ? $pop_link_button['target'] : '_self';
                               ?>
                               <a class="btn btn-theme border btn-md sucess-buton" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><span><?php echo esc_html( $link_title ); ?></span></a>
                           <?php endif; ?>
                        </div>
                     </div>

                  </div>
               </div>
               <div class="contactForm">
                  <div class="form">
                     <?php 
                        $pop_form = $popup_form['form'];
                           $form_title = $pop_form['title'];
                           $form_content = $pop_form['content'];
                           $form_shortcode = $pop_form['shortcode'];
                     ?>
                     <h2><?php echo $form_title; ?></h2>
                     <p> <?php echo $form_content; ?></p>
                     
                     <?php //echo do_shortcode('[contact-form-7 id="732" title="Popup Form"]');?>
                     <?php echo do_shortcode( ' '. $form_shortcode .' ' ); ?>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
               </div>
            </div>
         </section>

      </div>
   </div>
   <!------------------------------------------
         ===========================================-->

<?php endwhile; ?>


   </div>
   <!-- End Footer -->
   <!--Start Model-->
   <!-- Modal -->
   <div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalCenterTitle">Consultation</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <p> Planning a product journey is the key when it comes to fintech software development. Our seasoned
                  project managers help you explore new avenues. These sessions have often helped founders discover new
                  perspectives to their visions. </p>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
         </div>
      </div>
   </div>
   <!------------------------------------------
         ===========================================-->
   <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalCenterTitle">Consumer centric websites</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <p> Our specialized design cell is known for fintech web development that guarantees brand recall. We
                  work closely with you and your team to create seamless designs that guarantees higher engagement. </p>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
         </div>
      </div>
   </div>
   <!------------------------------------------
         ===========================================-->
   <!------------------------------------------
         ===========================================-->
   <div class="modal fade" id="exampleModalCenter3" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalCenterTitle">Mobility</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <p> Our fintech app designs are built keeping your consumers at the core. The highen design experience
                  guarantees keeps you involved throughout the journey. </p>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
         </div>
      </div>
   </div>
   <!------------------------------------------
         ===========================================-->
   
   <!--End Model-->

<!------------------------------------------
         ===========================================-->
   <div class="modal contact-popup fade in" id="subscribePopup">

      <div class="modal-dialog modal-md">

         <section class="subscribe-form">
            <div class="container">
               <!-- <div class="contactInfo">
               </div> -->
               <div class="contactForm">
                  <div class="form">
                     <h2>Hey, let's Subscribe.</h2>
                     <!-- <p> Hey, let's talk.</p> -->
                     
                     <!-- <form method="post" action="https://www.highenfintech.com/?na=s"> 
                        <input type="hidden" name="nlang" value="">
                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label for="exampleInputEmail1">Your name*</label>
                                 <input type="text" class="form-control" name="nn" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="Enter your name">
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label for="exampleInputPassword1">Your Email id*</label>
                                 <input type="email" class="form-control" name="ne" id="exampleInputPassword1"
                                    placeholder="Enter your email id">
                              </div>
                           </div>

                           <div class="col-md-12 text-center">
                              <button type="submit" class="btn btn-theme border btn-md sucess-buton" >Send</button>
                           </div>
                        </div>


                     </form> -->
                     <?php echo do_shortcode('[contact-form-7 id="1025" title="Subscribe Form"]');?>
                     <button type="button" class="close" id="popup-close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
               </div>
            </div>
         </section>

      </div>
   </div>
   <!------------------------------------------
         ===========================================-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    if(localStorage.getItem('popState') != 'shown'){
        $("#subscribePopup").delay(12000).fadeIn();
        localStorage.setItem('popState','shown')
    }

    $('#popup-close').click(function(e) {
      $('#subscribePopup').fadeOut();
    });

});

</script>
<script>
$(document).ready(function() {
   $('.iti__country').click(function(event) {
      var code = $(this).find('.iti__dial-code').html();

      $('#phone').val(code);
      if (event.keyCode === 13) {
         $('#phone').val(code);
       }
   });

});
</script>



<style type="text/css">
ul.ks-cboxtags .checkedbox {
    border: 1px solid #146092;
    background-color: #146091;
    color: #fff;
    transition: all .2s;
}

</style>


<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WCRMW3Q"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php wp_footer(); ?>

</body>
</html>
<script>
   $("input[type='text'], input[type='email'], textarea").attr({"required": "required"});
   $("ul.children .commen-item").addClass("reply");
   $("ul.children .commen-item, ul.children ul.children").addClass("reply-child");
   
   
</script>
<script>
      $('.panel-collapse').on('show.bs.collapse', function () {
         $(this).siblings('.panel-heading').addClass('active');
      });

      $('.panel-collapse').on('hide.bs.collapse', function () {
         $(this).siblings('.panel-heading').removeClass('active');
      });
   </script>
   <script>
      var fileInput = document.querySelector('input[type=file]');
      var filenameContainer = document.querySelector('#filename');

      fileInput.addEventListener('change', function () {
         filenameContainer.innerText = fileInput.value.split('\\').pop();
      });
   </script>



<script type="text/javascript">

$(document).ready(function() {
     
    $("[data-labelfor]").click(function() {
      var attri = $(this).attr("data-labelfor");

        $('#'+attri+' input[name="project_type[]"]' ).prop('checked', 
       function(i, oldVal) {         
         
         if (oldVal == false) {
            $("[data-labelfor='"+attri+"']").addClass("checkedbox");
         }else{
            $("[data-labelfor='"+attri+"']").removeClass("checkedbox");
         }
         return !oldVal;
         
      });
    });
   
});


</script>

<script type="text/javascript">

$(document).ready(function() {
     
    $("[data-labelfor]").click(function() {
      var attri = $(this).attr("data-labelfor");

        $('#'+attri+' input[name="project_stage[]"]' ).prop('checked', 
       function(i, oldVal) {         
         
         if (oldVal == false) {
            $("[data-labelfor='"+attri+"']").addClass("checkedbox");
         }else{
            $("[data-labelfor='"+attri+"']").removeClass("checkedbox");
         }
         return !oldVal;
         
      });
    });
   
});


</script>

<script>
$("label.btn-style .wpcf7-radio .wpcf7-list-item-label").addClass("checkmark");
$(".check-btn .wpcf7-list-item-label").addClass("checkmark");

function singleSocialPop(id){
   $("#Social_"+id).css({"opacity": "1", "visibility" : "visible", "transform" : "translateX(20px)", "z-index" : "9"});
   $("#Social_"+id).parent().attr("onclick","SingleSocialPopClose("+id+")");
}
function SingleSocialPopClose(id){
   $("#Social_"+id).css({"opacity": "0", "visibility" : "hiddeb", "transform" : "translateX(0px)", "z-index" : "-9"});
   $("#Social_"+id).parent().attr("onclick","singleSocialPop("+id+")");
}


function socialPop(id){
   $("#Social_"+id).css({"opacity": "1", "visibility" : "visible", "transform" : "translateX(-20px)", "z-index" : "9"});
   $("#Social_"+id).parent().attr("onclick","socialPopClose("+id+")");
}
function socialPopClose(id){
   $("#Social_"+id).css({"opacity": "0", "visibility" : "hiddeb", "transform" : "translateX(0px)", "z-index" : "-9"});
   $("#Social_"+id).parent().attr("onclick","socialPop("+id+")");
}

</script>

<script>
$(document).ready(function() {
     
    $(".dropdown-toggle").click(function() {
      $(".dropdown-toggle ~ ul").addClass("dropdown-menu animated #");
    });
   
});
</script>


