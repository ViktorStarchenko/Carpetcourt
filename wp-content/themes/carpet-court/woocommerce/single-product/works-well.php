  <?php
  /**
   * single works well with product
   */
  // Exit if accessed directly
  if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $product;

$product_id = $product->id;
$terms = get_terms( 'product_cat', array(
  'hide_empty' => false,
  ) );

$works_terms_array = array();

foreach ($terms as $term_value) {
  if ( !in_array( $term_value->slug, $works_terms_array ) ) {
      array_push( $works_terms_array, $term_value->slug );
  }
}

$product_term = wp_get_post_terms( $product_id, 'product_cat' );

if ( !empty( $works_terms_array ) ) {

  foreach ($product_term as $product_term_value) {
      if( ( $key = array_search( $product_term_value->slug, $works_terms_array ) ) !== false ) {
        unset( $works_terms_array[$key] );

    }
}
}


$prod_count = get_theme_mod( 'cpm_cc_works_n_other_product_count' );
$count_prod = ( !empty( $prod_count ) && isset( $prod_count ) ) ? $prod_count : 5;

$works_args = array();
$works_args['post_type'] = 'product';
$works_args['posts_per_page'] = $count_prod;
$works_args['post__not_in'] = array( $product_id );
$works_args['orderby'] = 'rand';
if ( !empty( $works_terms_array ) ) {
    $works_args['tax_query'] = array(
        array(
            'taxonomy'  => 'product_cat',
            'field'     => 'slug',
            'terms'     => $works_terms_array
            )
        );
}
$works_prod_query = new WP_Query( $works_args );

if ( $works_prod_query->have_posts() ) { ?>
<div class="cc-works-well clearfix">
    <h2 class="inner-section-title inner-section-title-1 alt-text"><span><?php _e('Works well with','carpet-court');?></span></h2>
    <div id="slider-works-welll" class="cc-product-slide">
        <?php
        while ( $works_prod_query->have_posts() ) {
            $works_prod_query->the_post();

                $colors_terms = get_the_terms( get_the_ID(), 'pa_color');
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
                <a href="<?php the_permalink();?>">
                    <?php
                    $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'shop_catalog' );
                    $featured_image = get_field('featured_image');
                    $imported_images = get_field('gallery_images');

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
                            <?php echo get_the_title();?>
                        </span>
                    </figure>
                </a>
            </div>

            <?php
        }
        wp_reset_postdata();
        ?>
    </div>
</div>
<?php
} ?><div id="projects-works-copy" class="hide"></div>