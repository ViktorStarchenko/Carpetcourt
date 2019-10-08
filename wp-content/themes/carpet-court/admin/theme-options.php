<?php
	if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/ReduxCore/framework.php' ) ) {
    	require_once( dirname( __FILE__ ) . '/ReduxCore/framework.php' );
	}

	if ( !isset( $redux_demo ) && file_exists( dirname( __FILE__ ) . '/config.php' ) ) {
	    require_once( dirname( __FILE__ ) . '/config.php' );
	}

	function redux_disable_dev_mode_plugin( $redux ) {
        if ( $redux->args['opt_name'] != 'redux_demo' ) {
            $redux->args['dev_mode'] = false;
        }
    }

    add_action( 'redux/construct', 'redux_disable_dev_mode_plugin' );