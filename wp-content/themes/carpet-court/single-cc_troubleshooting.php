<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Carpet_Court
 */
get_header(); ?>


<div id="parallex-banner" class="clearfix">
    <?php if (has_post_thumbnail()):the_post_thumbnail(); endif; ?>
    <div class="parallex-content">
        <header class="entry-header">
            <?php the_title('<h1 class="entry-title"><span>', '</span></h1>'); ?>
        </header>
    </div>
</div>

<div id="primary" class="content-area mt-60 mb-60 container">
    <main id="main" class="site-main" role="main">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <div class="entry-content">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>
            </article>
        <?php endwhile; ?>

        <?php
        /*Related Content*/
        $all_cats = array();
        $terms = get_the_terms(get_the_ID(), 'cc_trouble_cat');
        if (!empty($terms)) {
            foreach ($terms as $term) {
                $all_cats[] = $term->term_id;
            }
        }
        $related_args = array(
                'post_type' => 'cc_troubleshooting',
                'post__not_in' => array(get_the_ID()),
                'tax_query' => array(
                        array(
                                'taxonomy' => 'cc_trouble_cat',
                                'field' => 'term_id',
                                'terms' => $all_cats,
                        ),
                ),
        );
        $related_content = new WP_Query($related_args);
        if ($related_content->have_posts()):
            ?>
            <div class="cc-related-content clearfix">
                <h2 class="inner-section-title inner-section-title-1 alt-text">
                    <span><?php _e('Related Content', 'carpet-court'); ?></span></h2>
                <div class="cc-related-slider">
                    <ul class="cc-related-content-slide">
                        <?php while ($related_content->have_posts()):$related_content->the_post(); ?>
                            <li>
                                <a href="<?php the_permalink(); ?>">
                                    <?php $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'shop_catalog');
                                    if (!empty($thumb)):
                                        echo '<img src="' . $thumb[0] . '">';
                                    else:
                                        $image = cc_placeholder_img_src('300x300');
                                        echo '<img src="' . esc_url($image) . '">';
                                    endif;
                                    echo '<div class="default-overlay"> </div>';
                                    ?>
                                    <figure class="hover-title">
                                        <span>
                                            <?php echo get_the_title(); ?>
                                        </span>
                                    </figure>
                                </a>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

    </main>
</div>
<?php
get_footer();
?>
<script>
    jQuery(document).ready(function ($) {
        $('.cc-related-content-slide').bxSlider({
            minSlides: 2,
            maxSlides: 4,
            slideWidth: 280,
            slideMargin: 10,
            nextText: '<span class="fa fa-angle-right" aria-hidden="true"></span>',
            prevText: '<span class="fa fa-angle-left" aria-hidden="true"></span>',
        });
    });
</script>
