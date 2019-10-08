<?php

/**
* CC_Product_Filter_Enqueue
*/
class CC_Product_Filter_Enqueue {


	private static $instance;

	public static function get_instance() {

	 	if( null == self::$instance ) {
	 		self::$instance = new CC_Product_Filter_Enqueue();
	 	}
	 	return self::$instance;
	}


	private function __construct() {
		add_action( 'wp_enqueue_scripts', array($this,'cc_product_filter_enqueue_scripts') );
	}

	public function cc_product_filter_enqueue_scripts(){
		$filter_modal = array('ajax_url'=> admin_url( 'admin-ajax.php' ),'url'=> get_template_directory_uri() );


		wp_register_style('cc_product_filter_css',PATH_URL.'assets/css/progressbar.css');
		wp_enqueue_style('cc_product_filter_css');

		if(!wp_script_is('jquery')) {
		     // do nothing
		     wp_enqueue_script( 'jquery' );
		 }
		wp_register_script('jquery-easing',PATH_URL.'assets/js/jquery.easing.min.js',array('jquery'));
		wp_enqueue_script('jquery-easing');


		wp_register_script( 'cc_product_filter_js', PATH_URL.'assets/js/progressbar.js',array('jquery','jquery-easing','isotope','isotope-init','bxslider'), '1.0.03', false );
		wp_enqueue_script('cc_product_filter_js');

		wp_localize_script( 'cc_product_filter_js', 'progressbar', $filter_modal );


		wp_register_script('cc_product_filter_modal',PATH_URL.'assets/js/cc_product_filter.js',array('jquery','carpet-court-plugins-js','isotope','isotope-init'),'',true );
		wp_enqueue_script('cc_product_filter_modal');


		wp_localize_script( 'cc_product_filter_modal', 'filter_modal', $filter_modal );

	}
}

// new CC_Product_Filter_Enqueue();