<?php
$wplogoutURL = urlencode(get_the_permalink());
$wplogoutTitle = urlencode(get_the_title());
$wplogoutImage= urlencode(get_the_post_thumbnail_url(get_the_ID(), 'full'));
?>

<div class="col-md-6 mt-30">
    <div class="item">
        <div class="thumb blog-grid-thumb">
            <a href="<?php the_permalink();?>">
                <?php 
                if ( has_post_thumbnail() ) { ?>
                   <img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'full' ); ?>" >
                <?php }
                else { ?>
                    <img src="<?=site_url();?>/wp-content/uploads/2021/11/no-preview.png" >
                <?php }
                ?>
            </a>
        </div>
        <div class="info">
            <div class="content">
            <div class="date">
            <?php echo get_the_date( 'd M, Y', $post->ID ); ?>
            </div>
            <h4>
                <a href="<?php the_permalink();?>">

                    <?php 
                    $title = get_the_title();
                    $trim_title = wp_trim_words($title, 5, "");
                    echo $trim_title;?>
                </a>
            </h4>
            <p>
                
            <?php $content = get_the_content();
            $trim_content = wp_trim_words($content, 20, ".");
            echo $trim_content;
            ?>
            </p>
            <a href="<?php the_permalink();?>">Read More <i class="fas fa-angle-right"></i></a>
            </div>
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
                <li style="position: relative;" onclick="socialPop(<?php echo get_the_ID();?>)">
                    <?php $slug = get_post_field( 'post_name', get_the_ID() ); ?>
                    <a href="#SocialShare" >
                        <i class="fas fa-share-alt"></i>
                        <span></span>
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
        </div>
    </div>
</div>