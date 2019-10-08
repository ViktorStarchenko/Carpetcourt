<?php
/**
* Single Product Other products
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
global $product;

$other_products = array();
$product_terms = array();
$term_lists = get_the_terms( $product->id, 'product_cat' );
$prod_count = get_theme_mod( 'cpm_cc_works_n_other_product_count' );
$count_prod = ( !empty( $prod_count ) && isset( $prod_count ) ) ? $prod_count : 5;
if($term_lists)
{
    foreach ($term_lists as $term_list) {
        array_push($product_terms, $term_list->term_id);
    }

    $args = array(
        'post_type'     =>  'product',
        'post__not_in' => array($product->id),
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'term_id',
                'terms'    => $product_terms,
                ),
            ),
        'posts_per_page' => $count_prod,
        'orderby'   => 'rand',
        );
    $related_products = new WP_Query($args);
    if($related_products->have_posts())
        { ?>

    <div class="cc-other-products clearfix">
        <h2 class="inner-section-title inner-section-title-1 alt-text"><span><?php _e('Other products you might like','carpet-court');?></span></h2>
        <div id="slider-other-productt" class="cc-product-slide">
            <?php
            while($related_products->have_posts()): $related_products->the_post();
                // array_push($other_products, get_the_ID());
            $colors_terms = get_the_terms(get_the_ID(), 'pa_color');
            $col_prod_terms = array();
            if ( !empty( $colors_terms ) ) {
                foreach ($colors_terms as $colors_terms_value) {
                    if ( !in_array( $colors_terms_value->term_id, $col_prod_terms ) ) {
                        $col_prod_terms[] = $colors_terms_value->term_id;
                    }
                }
            }
            ?>
            <div class="project <?php echo ( !empty( $col_prod_terms ) ) ? implode(" ", $col_prod_terms ) : ''; ?>">
                <a href="<?php the_permalink(get_the_ID());?>">
                    <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'shop_catalog' );
                    $featured_image = get_field('featured_image');
                    $imported_images = get_field('gallery_images', get_the_ID());

                    if ( !empty( $imported_images[0]['gallery_images_url'] ) ):
                        // if(!empty($featured_image)):
                        echo '<img src="'.$imported_images[0]['gallery_images_url'].'">';
                    elseif(!empty($thumb)):
                        echo '<img src="'.$thumb[0].'">';
                    else:
                        $image = cc_placeholder_img_src('300x300');
                    echo '<img src="'.esc_url($image).'">';
                    endif;
                    echo '<div class="default-overlay"> </div>';
                    ?>
                    <figure class="hover-title">
                        <span>
                            <?php echo get_the_title(get_the_ID());?>
                        </span>
                    </figure>
                </a>
            </div>
            <?php
            endwhile;
            wp_reset_postdata();
        } ?>
    </div>
</div>
<div id="projects-other-copy" class="hide"></div>
<?php
}