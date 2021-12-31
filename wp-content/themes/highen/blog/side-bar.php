<div class="col-lg-4 col-md-12 col-sm-12">
    <div class="sidebar">
        <div class="sidebar-widget sidebar-search">
            <div class="widget-title">
            <h3>Search</h3>
            </div>
            <div class="widget-content">


                <form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <div class="form-group">
                        <input type="search" placeholder="Search" name="s" id="s" required="">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <div class="sidebar-widget sidebar-post">
            <div class="widget-title">
            <h3>Latest News</h3>
            </div>
            <div class="post-inner">
            <?php  $about_us = new WP_Query( array( 'post_type' => 'post' ,'order' => 'DESC', 'posts_per_page' => 6 ) );
                while($about_us->have_posts()) : $about_us->the_post();?>

                <div class="post">
                    <figure class="image-box">
                        <a href="<?php the_permalink();?>">

                            <?php 
                            if ( has_post_thumbnail() ) { ?>
                               <img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'full' ); ?>"  style="object-fit: cover;">
                            <?php } else {?>
                                <img src="<?=site_url();?>/wp-content/uploads/2021/11/no-preview.png"  style="object-fit: cover;">
                            <?php } ?>
                        </a>
                    </figure>
                    <div class="post-date">
                        <p><?php echo get_the_date( 'M d, Y', $post->ID ); ?></p>
                        
                    </div>
                    <h5><a href="<?php the_permalink();?>">
                    <?php $title = get_the_title();
                    $trim_title = wp_trim_words( $title, 6, "" );
                    ?>
                    <?php echo $trim_title;?>
                    </a></h5>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
        <div class="sidebar-widget sidebar-tags">
            <div class="widget-title">
            <h3>Popular Tags</h3>
            <div class="widget-content">
                <ul class="clearfix">
                
                <?php
                $posttags = get_tags();
                    if ($posttags) {
                        foreach($posttags as $tag) {?>
                            <li><a href="<?php echo esc_attr( get_tag_link( $tag->term_id ) );?>"><?php echo $tag->name; ?></a></li>

                        <?php }
                    }
                ?>
                </ul>
            </div>
            </div>
        </div>
    </div>
</div>