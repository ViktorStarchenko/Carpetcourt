<?php
/*
 * Module: Product Zoom With Slider
 */

define('PZ_DIR',__DIR__);

add_action('wp_enqueue_scripts','load_product_zoom_scripts');
function load_product_zoom_scripts(){
	wp_register_script( 'cloud-zoom',get_template_directory_uri().'/modules/product-zoom/js/cloudzoom.js', array('jquery'),null, true );

	/*if ( !wp_script_is( 'bxslider', 'enqueued' ) ) {
       wp_register_script( 'bxslider',get_template_directory_uri().'/modules/product-zoom/js/jquery.bxslider.min.js', array('jquery'),null, true );
    } */
	
	wp_enqueue_script( 'product-zoom-init',get_template_directory_uri().'/modules/product-zoom/js/script.js', array('cloud-zoom'),null, true );

	//wp_enqueue_style( 'cufon-yui',get_template_directory_uri().'/modules/product-zoom/css/style.css', array(),null );
	
	/*if ( !wp_style_is( 'bxslider', 'enqueued' ) ) {
		wp_enqueue_style( 'bxslider',get_template_directory_uri().'/modules/product-zoom/css/jquery.bxslider.css', array(),null );
	}*/
}


remove_action ( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
remove_action ( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
add_action ( 'woocommerce_before_single_product_summary', 'pz_show_product_images', 20 );
add_action ( 'woocommerce_product_thumbnails', 'pz_show_product_thumbnails', 20 );

function pz_show_product_images () {
    $wc_get_template = function_exists ( 'wc_get_template' ) ? 'wc_get_template' : 'woocommerce_get_template';

    $wc_get_template( 'single-product/product-image.php', array (), '', PZ_DIR . '/templates/' );
}

function pz_show_product_thumbnails () {
	$wc_get_template = function_exists ( 'wc_get_template' ) ? 'wc_get_template' : 'woocommerce_get_template';
	$wc_get_template( 'single-product/product-thumbnails.php', array (), '', PZ_DIR . '/templates/' );
}


