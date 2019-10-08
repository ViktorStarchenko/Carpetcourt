<?php

define('NUMBER_PATH', get_template_directory() . '/modules/number-counter/' );
define('NUMBER_PATH_URL', get_template_directory_uri() . '/modules/number-counter/' );

class Number_count {

	private static $instance;

	public static function get_instance() {

	 	if( null == self::$instance ) {
	 		self::$instance = new Number_count();
	 	}
	 	return self::$instance;
	}

	public function __construct(){
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts_enqueues' ) );

		add_shortcode( 'number_count', array( $this, 'number_count_up_fn' ) );

	}


	public function number_count_up_fn( $atts, $content = "" ) {
		// return 'this is test';
		$atts = shortcode_atts( array(
				'id'     => '',
				'label'  => '',
				'number' => ''
			), $atts );

		$animate  = '<div class="animate_counter" >';

		if ( $atts['number'] != '' ){
			$animate .=	'<div class="number_count" id="number_count_' . $atts['id'] . '" data-number="' . $atts['number'] . '" >0</div>';
		}

		$animate .=	'<div class="label' . ( ( $atts['number'] == '' ) ? ' label-large' : '' ) . ' ">' . $atts['label'] . '</div>';
		$animate .=	'</div>';

		return $animate;
	}

	/**
	 * Enqueue scripts
	 */
	public static function scripts_enqueues() {

		if( ! wp_script_is( 'jquery' ) ) {
			wp_enqueue_script( 'jquery' );
		}

		wp_register_script( 'animateNumber-js', NUMBER_PATH_URL .'assets/js/jquery.animateNumber.min.js',  array('jquery'), '0.0.13' );
		// wp_register_script( 'animate-custom-js', NUMBER_PATH_URL .'assets/js/animate-custom.js',  array('jquery'), '0.0.1' );

		wp_enqueue_script( 'animateNumber-js' );
		// wp_enqueue_script( 'animate-custom-js' );

	}
}
Number_count::get_instance();
// echo do_shortcode( '[number_count label="as" number="12" ]' );