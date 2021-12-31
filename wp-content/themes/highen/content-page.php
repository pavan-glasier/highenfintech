<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package WordPress
 * @subpackage highen
 * @since Highen 1.0
 */
?>
<style>
#process .content{
    background: #fcfcfc;
    padding: 35px;
    border-radius: 8px;
}
.float-right {
    float: right;
}
</style>

<section class="inner-wrap" id="post-<?php the_ID(); ?>">
    <div class="container">
        <div class="row">
            <div class="col-md-12 inner-header">
                <h1><?php the_title();?></h1>
            </div>
        </div>
    </div>
</section>

<div class="default-padding">
    <div id="process" class="work-process-area ">
        <div class="container">
            <div class="row pb-70">

                <div class="col-md-12 info">
                    <div class="content">
                        <?php the_content(); ?>
                    </div>

                </div>
            </div>

            <?php edit_post_link( __( 'Edit', 'highen' ), '<span class="edit-link float-right">', '</span>' ); ?>
        </div>

    </div>
</div>







