<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product, $woocommerce;

$enable_slider = get_option('yith_wcmg_enableslider') == 'yes' ? true : false;

$attachment_ids = $product->get_gallery_attachment_ids();

if ( ! empty( $attachment_ids ) ) array_unshift( $attachment_ids, get_post_thumbnail_id() );

//  make sure attachments ids are unique
$attachment_ids = array_unique($attachment_ids);

if ( $attachment_ids ) {
    ?>
    <div id="pz-thumbnails" class="thumbnails">
        <ul class="">
        <?php
        $loop = 0;
        $columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );

        if( !isset( $columns ) || $columns == null ) $columns = 3;

        foreach ( $attachment_ids as $attachment_id ) {
           $classes = array( 'pz-thumb' );

            if ( $loop == 0 || $loop % $columns == 0 ) {
                $classes[] = 'first';
            }

            if ( ( $loop + 1 ) % $columns == 0 ) {
                $classes[] = 'last';
            }

            $image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
            $image_class = esc_attr( implode( ' ', $classes ) );
            $image_title = esc_attr( get_the_title( $attachment_id ) );

            list( $thumbnail_url, $thumbnail_width, $thumbnail_height ) = wp_get_attachment_image_src( $attachment_id, "shop_single" );
            list( $magnifier_url, $magnifier_width, $magnifier_height ) = wp_get_attachment_image_src( $attachment_id, "shop_magnifier" );

            echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<li class="%s"><a href="%s" class="%s" title="%s" data-zoom-image="%s" data-image="%s">%s</a></li>', $image_class, $magnifier_url, $image_class, $image_title, $magnifier_url, $thumbnail_url, $image ), $attachment_id, $post->ID, $image_class );

            $loop++;
        }
        ?>
        </ul>
    </div>
<?php
}
?>