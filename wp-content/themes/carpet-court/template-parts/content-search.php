<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Carpet_Court
 */

?>

sdfssfsdsdfsdfsdfsdf

<li class="result clearfix" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php
    global $post;
    if(has_post_thumbnail()):
        ?>
    <div class="result-picture">
        <a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
            <?php
            the_post_thumbnail('shop_catalog');
            ?>
        </a>
    </div>
    <?php
    else:
        $image_feature_url = get_field('featured_image');
    if ( !empty( $image_feature_url ) ) {
        ?>
        <div class="result-picture">
            <a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
                <img src="<?php echo $image_feature_url; ?>" />
            </a>
        </div>
        <?php
    }
    endif;
    ?>
    <div class="result-title">
        <a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php echo get_the_title(); ?></a>
    </div>
    <div class="result-snippet">
        <?php echo cc_strip_excerpt( $post->post_excerpt, get_the_ID(), 20, true); ?>
    </div>
</li>
