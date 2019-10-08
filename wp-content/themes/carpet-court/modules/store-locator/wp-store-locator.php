<?php
if ( !class_exists( 'WP_Store_locator' ) ) {

	class WP_Store_locator {
        
        /**
         * Class constructor
         */          
        function __construct() {
                                    
            $this->define_constants();
            $this->includes();
            $this->plugin_settings();
            
            $this->post_types = new WPSL_Post_Types();
            $this->i18n       = new WPSL_i18n();
                        
            // register_activation_hook( __FILE__, array( $this, 'install' ) );

            add_action("after_switch_theme", array( $this, 'install' ), 10 ,  2); 
        }
        
        /**
         * Setup plugin constants.
         *
         * @since 1.0.0
         * @return void
         */
        public function define_constants() {

            if ( !defined( 'WPSL_VERSION_NUM' ) )
                define( 'WPSL_VERSION_NUM', '2.1.2' );

            if ( !defined( 'WPSL_URL' ) )
                // define( 'WPSL_URL', plugin_dir_url( __FILE__ ) );
                define( 'WPSL_URL', get_stylesheet_directory_uri().'/modules/store-locator/' );

            if ( !defined( 'WPSL_BASENAME' ) )
                // define( 'WPSL_BASENAME', plugin_basename( __FILE__ ) );
                define( 'WPSL_BASENAME', get_stylesheet_directory_uri().'/modules/store-locator/' );

            if ( !defined( 'WPSL_PLUGIN_DIR' ) )
                // define( 'WPSL_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
                define( 'WPSL_PLUGIN_DIR', get_stylesheet_directory().'/modules/store-locator/' );
                
        }
        
        /**
         * Include the required files.
         *
         * @since 2.0.0
         * @return void
         */
        public function includes() {
            
            require_once( WPSL_PLUGIN_DIR . 'inc/wpsl-functions.php' );
            require_once( WPSL_PLUGIN_DIR . 'inc/class-post-types.php' );
            require_once( WPSL_PLUGIN_DIR . 'inc/class-i18n.php' );
            require_once( WPSL_PLUGIN_DIR . 'frontend/class-frontend.php' );
            
            if ( is_admin() ) {
                require_once( WPSL_PLUGIN_DIR . 'admin/roles.php' );
                require_once( WPSL_PLUGIN_DIR . 'admin/class-admin.php' );
            }
        }
        
        /**
         * Setup the plugin settings.
         *
         * @since 2.0.0
         * @return void
         */
        public function plugin_settings() {
            
            global $wpsl_settings, $wpsl_default_settings;
            
            $wpsl_settings         = wpsl_get_settings();
            $wpsl_default_settings = wpsl_get_default_settings();
        }
        
        /**
         * Install the plugin data.
         *
         * @since 2.0.0
         * @return void
         */
        public function install( $network_wide ) {
            require_once( WPSL_PLUGIN_DIR . 'inc/install.php' );
            wpsl_install( $network_wide );
        }
	}
	
	$GLOBALS['wpsl'] = new WP_Store_locator();
}