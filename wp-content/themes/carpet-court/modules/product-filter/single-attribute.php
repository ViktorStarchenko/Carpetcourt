<?php
/**
 * The template for displaying all single attribtes CPT.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Carpet_Court
 */
?>

<?php global $cc_options; ?>

<div class="site-content">
  <div id="primary" class="content-area container">
    <main id="main" class="site-main" role="main">
      <?php
      if(isset($_POST['post_id']) && $_POST['post_id'] != '') {
        query_posts('p='.$_POST['post_id']);

      }
      while ( have_posts() ) : the_post();
      ?>
      <div class="popup-banner" style="background: url(<?php the_post_thumbnail_url('full'); ?>) repeat; padding: 20px 0px;">
        <div class="popup-banner-image" style="display: none;">
         <?php if( has_post_thumbnail( get_the_id() ) ) {
          the_post_thumbnail();

        }
        ?>
      </div>
      <div class="popup-banner-content">
        <div class="popup-center">
         <h1>
           <span class="text-white"><?php the_title()?></span>
         </h1>
       </div>
     </div>
   </div>
   <?php

   do_action('cc_filter_navigation');
   the_content();
   endwhile;


   $term = $_POST['term'];
   $taxonomy = $_POST['taxonomy'];
   $is_page = $_POST['is_page'];
   if ( $taxonomy == 'product_color') {

    $accent_class = 'cpm_product_color_filter_tax';
    if ( $is_page == 1 ) {

      $accent_class = 'product_color_filter_tax';
    }

    $parent_term = get_term( $term, $taxonomy, OBJECT);
    $termchildren = get_term_children( $term, $taxonomy );
    if ( !empty( $termchildren[0] ) ) { ?>

    <div class="model-wrapper">
      <h2 class="inner-section-title alt-text">
        <span>
          <?php _e("Accents that work with this Palette","cc_filter_product")?>
        </span>
      </h2>
    </div>
    <ul class="cpm-col-two" >
      <?php
      foreach ($termchildren as $term_child_value ) {
        $child_terms_object = get_term( $term_child_value, $taxonomy );

        $child_thumbnail_id = cc_get_term_meta( $child_terms_object->term_id, 'thumbnail_id', true );

        if( $taxonomy == "product_cat"){
          $child_thumbnail_id = get_woocommerce_term_meta( $child_terms_object->term_id, 'thumbnail_id', true );
        }

        $child_image = '';
        if ( $child_thumbnail_id ) {
          $child_image = wp_get_attachment_image_src( $child_thumbnail_id, ($taxonomy == "product_color")?'thumbnail':'filtertype_image' );
          $child_image = $child_image[0];
        }

        ?>
        <li>
          <?php if ( !empty( $child_image ) ) { ?>
          <!-- <figure class="fig-hover"> -->

          <a href="javascript:void(0);" class="<?php echo $accent_class; ?>" id="term_<?php echo $child_terms_object->term_id; ?>" data-parent="<?php echo $term; ?>" data-name="<?php echo $child_terms_object->name; ?>" data-term="<?php echo $child_terms_object->term_id; ?>">

            <img src="<?php echo esc_url($child_image) ?>" alt="<?php echo esc_attr__( 'Thumbnail', 'cc_product_filter' );?>"  class="wp-post-image"/>
          </a>

          <!-- </figure> -->
          <?php } ?>
        </li>
        <?php } ?>
      </ul>
      <?php }
    } ?>

    <div class="model-wrapper">
      <h2 class="inner-section-title alt-text">
        <span>
          <?php _e("shop the look","cc_filter_product")?>
        </span>
      </h2>
    </div>
    <div class="vertical-slider">
      <?php
                        // product list
      do_action('cc_taxonomy_product_list');
      ?>
    </div>
  </main><!-- #main -->
</div><!-- #primary -->
</div>