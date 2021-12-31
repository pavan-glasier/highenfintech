<?php
/**
 * The template for displaying posts in the Status post format
 *
 * @package WordPress
 * @subpackage highen
 * @since Highen 1.0
 */

/* translators: %s: Post title. */



$wplogoutURL = urlencode(get_the_permalink());
$wplogoutTitle = urlencode(get_the_title());
$wplogoutImage= urlencode(get_the_post_thumbnail_url(get_the_ID(), 'full'));
?>

	<section class="inner-wrap">
      <div class="container">
         <div class="row">
            <div class="col-md-12 inner-header">
               <h1><?php echo single_tag_title( '', false );?></h1>
            </div>
         </div>
      </div>
   </section>
   <div class="default-padding">

      <div class="container">
         <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12">
               <div id="blog" class="blog-area single mt-30">
                  <div class="blog-items">
                     <div class="item">
                        <div class="thumb">
                        	<?php 
                        	if ( has_post_thumbnail() ) { ?>
									   <img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'full' ); ?>" alt="Thumb">

									<?php }
									else { ?>
									    <img src="<?=site_url();?>/wp-content/uploads/2021/11/no-preview.png" alt="Thumb">
									<?php }
                        	?>
                           
                        </div>
                        <div class="info">
                           <div class="meta">
                              <ul>
                                 <li>
								 	<?php
										$get_author_id = get_the_author_meta('ID');
										$get_author_gravatar = get_avatar_url($get_author_id, array('size' => 450));
									?>
									<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
										<img src="<?php print get_avatar_url($get_author_id); ?>" alt="Author">
										<span><?php the_author();?></span>
										
									</a>
                                 </li>
                                 <li>
                                    <a href="#comments">
                                       <i class="fas fa-comments"></i>
                                       <span><?php echo get_comments_number( $post->ID )?></span>
                                    </a>
                                 </li>
                                 <li style="position: relative;" onclick="singleSocialPop(<?php echo get_the_ID();?>)">
						                    <?php $slug = get_post_field( 'post_name', get_the_ID() ); ?>
						                    <a href="#SocialShare" >
						                        <i class="fas fa-share-alt"></i>
						                        <span>37</span>
						                    </a>
						                    <div class="social-share-icons" id="Social_<?php echo get_the_ID();?>">
						                        <ul>
						                            <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $wplogoutURL; ?>" target="_blank" rel="nofollow"><i class="fa fa-facebook"></i></a></li>
						                            <li><a href="https://twitter.com/intent/tweet?text=<?php echo $wplogoutTitle;?>&amp;url=<?php echo $wplogoutURL;?>&amp;via=wplogout" target="_blank" rel="nofollow"><i class="fa fa-twitter"></i></a></li>
						                            <li><a href="https://www.linkedin.com/shareArticle?url=<?php echo $wplogoutURL; ?>&amp;title=<?php echo $wplogoutTitle; ?>&amp;mini=true" target="_blank" rel="nofollow"><i class="fa fa-linkedin"></i></a></li>
						                            <li><a href="https://pinterest.com/pin/create/button/?url=<?php echo $wplogoutURL; ?>&amp;media=<?php echo $wplogoutImage;   ?>&amp;description=<?php echo $wplogoutTitle; ?>" target="_blank" rel="nofollow"><i class="fa fa-pinterest"></i></a></li>
						                            <li><a href="https://api.whatsapp.com/send?text=<?php echo $wplogoutTitle; echo " "; echo $wplogoutURL;?>" target="_blank" rel="nofollow"><i class="fa fa-whatsapp"></i></a></li>
						                        </ul>
						                    </div>

						                </li>
                              </ul>
                           </div>
                           <h3><?php the_title();?></h3>
                           <?php echo get_the_content();?>

                           <div class="post-tags">
                              <span>Tags: </span>
                              <!-- <a href="#">Consulting</a> -->
                              <?php
								$posttags = get_the_tags();
									if ($posttags) {
										foreach($posttags as $tag) {?>
										<a href="<?php echo esc_attr( get_tag_link( $tag->term_id ) );?>"><?php echo $tag->name; ?></a>
										<?php }
									}
								?>
                           </div>
                           
						   <?php
								$next_post_url = get_permalink( get_adjacent_post(false,'',false)->ID );
								$previous_post_url = get_permalink( get_adjacent_post(false,'',true)->ID );    
								
							?>
							<div class="post-pagi-area">
                              <a href="<?php echo $previous_post_url;?>"><i class="fas fa-arrow-left"></i> Previus Post</a>
                              <a href="<?php echo $next_post_url;?>">Next Post <i class="fas fa-arrow-right"></i></a>
                           </div>
							
                           <div class="comments-area">
                              <div class="comments-title">
                                 <h4><?php echo get_comments_number();?> comments</h4>
                                <div class="comments-list">
								 <?php $comments_number = get_comments_number();
									if($comments_number != 0){  ?>
									
									
										<?php 
										// $args1 = array(
										// 	'callback'          => 'better_comments',
										// ); 
										?>
										<?php $args1 = array(
											'add_below' 		=> true,
											'depth'     		=> 4,
											'max_depth' 		=> 20,
											'callback'          => 'better_comments',
											'reverse_top_level' => false,
											'reverse_children'  => true,
										); ?>
										<?php
										$comments = get_comments(array(
											'post_id' => $post->ID,
											'status' => 'approve'
											));
											wp_list_comments($args1, $comments);
										}
										?>
										<?php
										
										?>



                                 </div>
                              </div>
                           </div>
                           <div class="comments-form">
                              <!-- <div class="title">
                                 <h4>Leave a comments</h4>
                              </div> -->
                              <div class="login-box">
                                

								 <?php  $fields =  array(

									'author' => '<div class="row"><div class="col-lg-6 col-md-6 col-sm-12"><div class="user-box"><input id="author" id="name" name="author" type="text" placeholder="Name *"/></div></div>',
									'email' => '<div class="col-lg-6 col-md-6 col-sm-12"><div class="user-box"><input id="email" name="email" type="text" placeholder="Email *"/></div></div></div>',
									);
									$args = array(

									'title_reply'       => '<div class="title"><h4>Leave a comments</h4></div>',
									'fields' => $fields,
									'comment_field' => '<div class="row"><div class="col-lg-12 col-md-12 col-sm-12"><div class="user-box comments"><textarea id="comment" name="comment" cols="30" rows="10" placeholder="Comment" aria-required="true">' .
									'</textarea></div></div></div>',
									'id_form'           => 'commentform',
									'class_form'      => 'contact-formm',
									'comment_notes_before' => '<p class="comment-notes">Your Email Address Will Not Be Published</p>',
									'label_submit'      => 'Submit',
									'id_submit'         => 'submitt',
									'class_submit'      => 'comment-btn',
									'name_submit'       => 'submit',

									);

									

									?>
									<?php comment_form($args);?>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

			<?php include('blog/side-bar.php');?>

         </div>
      </div>

   </div>