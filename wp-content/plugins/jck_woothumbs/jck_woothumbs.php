<?php
/*
Plugin Name: WooThumbs - Awesome Product Imagery (shared on wplocker.com)
Plugin URI: http://www.jckemp.com
Description: Advanced product imagery
Version: 4.2.5
Author: James Kemp
Author Email: support@jckemp.com  
*/

require_once dirname( __FILE__ ) . '/inc/admin/class-tgm-plugin-activation.php';

class JCKWooThumbs {

/*  =============================
    // !Constants 
    ============================= */	
	
    public $name = 'WooThumbs - Multiple Images per Variation';
    public $shortname = 'WooThumbs';
    public $slug = 'jck-wt';
    public $settings_framework;
    public $plugin_path;
    public $plugin_url;
    public $bulk_edit_slug;
    public $ajax_nonce_string;
    public $version = "4.2.5";
	
/* =============================
    // !Constructor 
    ============================= */
   	
    function __construct() {
    
        $this->plugin_path = plugin_dir_path( __FILE__ );
        $this->plugin_url = plugin_dir_url( __FILE__ );
        $this->bulk_edit_slug = $this->slug.'-bulk-edit';
        $this->ajax_nonce_string = $this->slug.'_ajax';
        
        // Hook up to the init action
        add_action( 'plugins_loaded', array( $this, 'init_woocommerce_variation_transitions' ) );
        
        // If Redux is running as a plugin, this will remove the demo notice and links
        add_action( 'redux/loaded', array( $this, 'remove_redux_demo' ) );
        
    }
	
	// Remove Redux demo link and the notice of integrated demo from the redux-framework plugin
	function remove_redux_demo() {

        // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
        if (class_exists('ReduxFrameworkPlugin')) {
            remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);
            remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
        }
    }
  
/* 	=============================
	// !Runs when the plugin is initialized 
	============================= */
   	
	function init_woocommerce_variation_transitions()
	{
		// Setup localization
		load_plugin_textdomain( $this->slug, false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
		
		if ( !isset( $jck_wt ) && file_exists( dirname( __FILE__ ) . '/inc/admin/woothumbs-options.php' ) ) {
			require_once( dirname( __FILE__ ) . '/inc/admin/woothumbs-options.php' );
		}

	/* 	=============================
        // !Actions and Filters 
        ============================= */
        
        if( is_admin() ) {
            
            add_action( 'tgmpa_register', array( $this,'register_required_plugins' ) );
            
            add_action( 'admin_enqueue_scripts',                                array( $this, 'admin_scripts' ));  
            add_action( 'wp_ajax_admin_load_thumbnails',                        array( $this, 'admin_load_thumbnails' ));
            add_action( 'woocommerce_process_product_meta',                     array( $this, 'save_images' ));
            add_action( 'admin_menu',                                           array( $this, 'bulk_edit_page' ) ); 
            add_action( 'admin_init',                                           array( $this, 'media_columns' ) );
            	
            add_action( 'wp_ajax_'.$this->slug.'_bulk_save',                    array( $this, 'bulk_save' ) );
            add_action( 'wp_ajax_nopriv_'.$this->slug.'_bulk_save',             array( $this, 'bulk_save' ) );
            
            add_action( 'woocommerce_product_options_general_product_data',     array( $this, 'add_product_fields' ) );
            add_action( 'woocommerce_process_product_meta',                     array( $this, 'save_product_fields' ) );
	    
	    } else {
    	    
    		add_action( 'woocommerce_before_single_product',                    array( $this, 'remove_hooks' ) );
    		add_action( 'woocommerce_before_single_product_summary',            array( $this, 'show_product_images' ), 20); 
    		add_action( 'wp_enqueue_scripts',                                   array( $this, 'register_scripts_and_styles' ));
    		
    		add_filter( 'woocommerce_available_variation',                      array( $this, 'alter_variation_json' ), 10, 3 );
    		add_filter( 'body_class',                                           array( $this, 'add_theme_class' ) );
    		
		}
	}


/**	=============================
    *
    * Alter Variation JSON
    *
    * This hooks into the data attribute on the variations form for each variation
    * we can get the additional image data here!
    *
    * @param mixed $anything Description of the parameter
    * @return bool
    *
    ============================= */
    
    public function alter_variation_json( $variation_data, $wc_product_variable, $variation_obj ) {
        
        $img_ids = $this->get_all_image_ids( $variation_data['variation_id'] );
        $images = $this->get_all_image_sizes( $img_ids );
        
        $variation_data['additional_images'] = $images;
        
        return $variation_data;
        
    }

/**	=============================
    *
    * Add Theme Class to Body
    *
    * @param arr $classes exisiting classes
    * @return arr
    *
    ============================= */
    
    public function add_theme_class( $classes ) {
        
        $theme_name = sanitize_title_with_dashes( wp_get_theme() );
        
        $classes[] = $this->slug.'-'.$theme_name;
        return $classes;
        
    }

/**	=============================
    *
    * Is Enabled
    *
    * Check whether WooThumbs is enabled for this product
    *
    ============================= */
    
    public function is_enabled() {
        
        global $post;
        
        $pid = $post->ID;
        
        if( $pid ) {
        
            $disable_woothumbs = get_post_meta( $pid, 'disable_woothumbs', true );
            
            return ( $disable_woothumbs && $disable_woothumbs == "yes" ) ? false : true;
        
        }
        
        return false;
        
    }
    
/**	=============================
    *
    * Get Product ID from Slug
    *
    ============================= */
    
    public function get_post_id_from_slug() {
        
        global $wpdb;
        
        $slug = str_replace( array( "/product/", "/" ), "", $_SERVER['REQUEST_URI'] );
        
        $sql = "
            SELECT
                ID
            FROM
                $wpdb->posts
            WHERE
                post_type = \"product\"
            AND
                post_name = \"%s\"
        ";
       
        return $wpdb->get_var( $wpdb->prepare( $sql, $slug ) );
        
    }

/* 	=============================
    // !Bulk Edit Page 
    ============================= */
    
    public function bulk_edit_page()
    {   		
        $deliveriesPage = add_submenu_page( 'woocommerce', __('Bulk Edit Variation Images', $this->slug), __('WooThumbs Bulk', $this->slug), 'manage_woocommerce', $this->bulk_edit_slug, array( $this, 'bulk_edit_page_display' ) );
	}
	
	public function bulk_edit_page_display() {
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.', $this->slug ) );
		}
		
		require_once('inc/admin/bulk-edit.php');
	}

/**	=============================
    *
    * Add custom product fields
    *
    ============================= */
    
    public function add_product_fields() {
        
        global $woocommerce, $post;
        
        echo '<div class="options_group">';
  
            // Disable WooThumbs
            woocommerce_wp_checkbox( 
                array( 
            	    'id'            => 'disable_woothumbs', 
            	    'label'         => __('Disable WooThumbs?', $this->slug )
            	)
            );
        
        echo '</div>';
        
    }

/**	=============================
    *
    * Save custom product fields
    *
    ============================= */
    
    public function save_product_fields( $post_id ) {
        
        // Disable WooThumbs
        $disable_woothumbs = isset( $_POST['disable_woothumbs'] ) ? 'yes' : 'no';
	    update_post_meta( $post_id, 'disable_woothumbs', $disable_woothumbs );
        
    }
	
/* 	=============================
    // !Bulk Edit AJAX 
    ============================= */
   	
    function bulk_save()
    {
        check_ajax_referer($this->ajax_nonce_string, 'nonce');
        
        header('Content-Type: application/json');
        
        $return = array('result' => 'success', 'content' => '', 'message' => '');
        
        $images = trim($_POST['images']);
        
        // Validate input
        
        $re = '/^\d+(?:,\d+)*$/'; // numbers or commas
        
        if(preg_match($re, $images) || $images == "") // if input contains only numbers or commas OR nothing was entered
        {
            
            $prevImages = get_post_meta($_POST['varid'], 'variation_image_gallery', true);		
            $updatedImages = update_post_meta($_POST['varid'], 'variation_image_gallery', $images, $prevImages);
            
            if($prevImages == $images) {
                $return['result'] = 'no-change';
            }
            elseif($updateImages === false) {
                $return['result'] = 'failed';
            }  
        
        // if any other character is found 
        } else {
            
            $return['result'] = 'invalid-format';	
            
        }
   		
        switch ($return['result']) {
            case 'no-change':
                $return['message'] = __('There was no change.', $this->slug);
                break;
            case 'invalid-format':
                $return['message'] = __('Please use only numbers and commas.', $this->slug);
                break;
            case 'failed':
                $return['message'] = __('Sorry, an error occurred. Please try again.', $this->slug);
                break;
            case 'empty':
                $return['message'] = __('Nothing was entered.', $this->slug);
                break;
        }
   		   		
    	$return['postdata'] = $_POST;
    	
    	echo json_encode($return);
    	
    	die();
    }

/* 	=============================
   	// !Add new column to media screen for Image IDs 
   	============================= */
   	
   	function media_columns() {
	    add_filter( 'manage_media_columns', array( $this, 'media_id_col' ) );
	    add_action( 'manage_media_custom_column', array( $this, 'media_id_col_val' ), 10, 2 );
	}
	
	function media_id_col( $cols ) {
        $cols["mediaid"] = "Image ID";
        return $cols;
	}
	
	function media_id_col_val( $column_name, $id ) {
	    if($column_name == 'mediaid') echo $id;
	}
	
/* 	=============================
   	// !Plugin Requirements 
   	============================= */
	
	function register_required_plugins()
	{
	    /**
	     * Array of plugin arrays. Required keys are name and slug.
	     * If the source is NOT from the .org repo, then source is also required.
	     */
	    $plugins = array(	
	
	        // This is an example of how to include a plugin from the WordPress Plugin Repository.
	        array(
	            'name'      => 'Redux Framework',
	            'slug'      => 'redux-framework',
	            'required'  => true,
	        ),
	
	    );
	
	    /**
	     * Array of configuration settings. Amend each line as needed.
	     * If you want the default strings to be available under your own theme domain,
	     * leave the strings uncommented.
	     * Some of the strings are added into a sprintf, so see the comments at the
	     * end of each line for what each argument will be.
	     */
	    $config = array(
	        'id'           => $this->slug.'-tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
	        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
	        'menu'         => $this->slug.'-tgmpa-install-plugins', // Menu slug.
	        'has_notices'  => true,                    // Show admin notices or not.
	        'dismissable'  => false,                    // If false, a user cannot dismiss the nag message.
	        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
	        'is_automatic' => true,                   // Automatically activate plugins after installation or not.
	        'message'      => '',                      // Message to output right before the plugins table.
	        'strings'      => array(
	            'page_title'                      => __( 'Install Required Plugins', $this->slug ),
	            'menu_title'                      => __( 'Install Plugins', $this->slug ),
	            'installing'                      => __( 'Installing Plugin: %s', $this->slug ), // %s = plugin name.
	            'oops'                            => __( 'Something went wrong with the plugin API.', $this->slug ),
	            'notice_can_install_required'     => _n_noop( $this->name.' requires the following plugin: %1$s.', $this->name.' requires the following plugins: %1$s.', $this->slug ), // %1$s = plugin name(s).
	            'notice_can_install_recommended'  => _n_noop( $this->name.' recommends the following plugin: %1$s.', $this->name.' recommends the following plugins: %1$s.', $this->slug ), // %1$s = plugin name(s).
	            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', $this->slug ), // %1$s = plugin name(s).
	            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', $this->slug ), // %1$s = plugin name(s).
	            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', $this->slug ), // %1$s = plugin name(s).
	            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', $this->slug ), // %1$s = plugin name(s).
	            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with '.$this->name.': %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with '.$this->name.': %1$s.', $this->slug ), // %1$s = plugin name(s).
	            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', $this->slug ), // %1$s = plugin name(s).
	            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', $this->slug ),
	            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', $this->slug ),
	            'return'                          => __( 'Return to Required Plugins Installer', $this->slug ),
	            'plugin_activated'                => __( 'Plugin activated successfully.', $this->slug ),
	            'complete'                        => __( 'All plugins installed and activated successfully. %s', $this->slug ), // %s = dashboard link.
	            'nag_type'                        => 'error' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
	        )
	    );
	
	    tgmpa( $plugins, $config );
	}

/* 	=============================
   	// !Action and Filter Functions
   	============================= */
   	
   	// Edit Screen Functions
   	
   	public function admin_scripts() {
		global $post, $pagenow;

		if(
			($post && (get_post_type( $post->ID ) == "product" && ($pagenow == "post.php" || $pagenow == "post-new.php"))) ||
			($pagenow == 'admin.php' && isset($_GET['page']) && $_GET['page'] == $this->bulk_edit_slug)
		){
			wp_enqueue_script($this->slug, plugins_url('assets/admin/js/admin-scripts.js', __FILE__), array('jquery'), '2.0.1', true);
			wp_enqueue_style( 'jck_wt_admin_css', plugins_url('assets/admin/css/admin-styles.css', __FILE__), false, '2.0.1' );
			
			$vars = array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'nonce' => wp_create_nonce( $this->ajax_nonce_string ),
				'slug' => $this->slug
			);
			wp_localize_script( $this->slug, 'vars', $vars );
		}
	}
	
	function save_images($post_id){
	
		if(isset($_POST['variation_image_gallery'])) {
			foreach($_POST['variation_image_gallery'] as $varID => $variation_image_gallery) {
				update_post_meta($varID, 'variation_image_gallery', $variation_image_gallery);	
			}
		}
		
	}
	
	function admin_load_thumbnails() {
		
		if ( ! isset( $_REQUEST['nonce'] ) || ! wp_verify_nonce( $_REQUEST['nonce'], $this->ajax_nonce_string ) ) { die ( 'Invalid Nonce' ); }
			
			$attachments = get_post_meta($_GET['varID'], 'variation_image_gallery', true);
			$attachmentsExp = array_filter(explode(',', $attachments));
			$imgIDs = array(); ?>
			
			<ul class="wooThumbs">
			
				<?php if(!empty($attachmentsExp)) { ?>
				
					<?php foreach($attachmentsExp as $id) { $imgIDs[] = $id; ?>
						<li class="image" data-attachment_id="<?php echo $id; ?>">
							<a href="#" class="delete" title="Delete image"><?php echo wp_get_attachment_image( $id, 'thumbnail' ); ?></a>
						</li>
					<?php } ?>
				
				<?php } ?>
			
			</ul>
			<input type="hidden" class="variation_image_gallery" name="variation_image_gallery[<?php echo $_GET['varID']; ?>]" value="<?php echo $attachments; ?>">
		
		<?php exit;
	}
	
	// !Remove the default images from WooCommerce Product Pages
	
	public function remove_hooks() { 
    	
    	if( $this->is_enabled() ) {
        	
    		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
    		
    		// Mr. Tailor
    		remove_action( 'woocommerce_before_single_product_summary_product_images', 'woocommerce_show_product_images', 20 );
    		remove_action( 'woocommerce_product_summary_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
    		
    		// Remove images from Bazar theme
    		if( class_exists( 'YITH_WCMG' ) ) {
    			$this->remove_filters_for_anonymous_class( 'woocommerce_before_single_product_summary', 'YITH_WCMG_Frontend', 'show_product_images', 20 );
    			$this->remove_filters_for_anonymous_class( 'woocommerce_product_thumbnails', 'YITH_WCMG_Frontend', 'show_product_thumbnails', 20 );
    		}
		
		}
		
	}
	
	// !Display Images on Frontend
	
	public function show_product_images() {
    	
    	if( $this->is_enabled() ) {
        	
        	if ( !in_array( 'redux-framework/redux-framework.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
            	
                echo '<p>'.sprintf( __('You need to install and enable the <a href="%s" target="_blank">Redux Framework</a> plugin before your images are shown.', $this->slug), 'https://wordpress.org/plugins/redux-framework/' ).'</p>';
                
        	} else {
            	
                require_once('inc/images.php');
                
        	}
		    
		}
		
	}
  
/* 	=============================
    // !Frontend Scripts and Styles 
    ============================= */
   	
	public function register_scripts_and_styles() {
    	
		global $jck_wt;
		
		if( ( function_exists('is_product') && is_product() ) && $this->is_enabled() ){	
    		
    		// CSS
    		
    		$this->load_file( $this->slug . '-css', '/assets/frontend/css/main.css' );
    		
    		// Scripts
    		
			$this->load_file( $this->slug . '-script', '/assets/frontend/js/main.js', true );
			
			$vars = array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'nonce' => wp_create_nonce( $this->ajax_nonce_string ),
				'loading_icon' => plugins_url('assets/frontend/img/loading.gif', __FILE__),
				'slug' => $this->slug,
				'options' => $jck_wt
			);
			
			wp_localize_script( $this->slug . '-script', 'jck_wt_vars', $vars );
			
			add_action( 'wp_head', array( $this, 'dynamic_css' ) );
			
		}
		
	} // end register_scripts_and_styles

/**	=============================
    *
    * Dynamic CSS
    *
    ============================= */
    
    public function dynamic_css() {
        
        include($this->plugin_path.'/assets/frontend/css/dynamic-styles.css.php');
        
    }
	
/* 	=============================
   	// !Helpers 
   	============================= */
	
	/* 	=============================
	   	Helper function for registering and enqueueing scripts and styles.
	   	@name: 			The ID to register with WordPress
	   	@file_path: 	The path to the actual file
	   	@is_script:		Optional argument for if the incoming file_path is a JavaScript source file.
	   	============================= */
		
		private function load_file( $name, $file_path, $is_script = false ) {
	
			$url = plugins_url($file_path, __FILE__);
			$file = plugin_dir_path(__FILE__) . $file_path;
	
			if( file_exists( $file ) ) {
				if( $is_script ) {
					wp_register_script( $name, $url, array('jquery'), false, true ); //depends on jquery
					wp_enqueue_script( $name );
				} else {
					wp_register_style( $name, $url );
					wp_enqueue_style( $name );
				} // end if
			} // end if
	
		} // end load_file
	
	/* 	=============================
	   	Allow to remove method for a hook when it's a class method used
	   	and the class doesn't have a variable assigned, but the class name is known
	   	@hook_name: 	Name of the wordpress hook
	   	@class_name: 	Name of the class where the add_action resides
	   	@method_name:	Name of the method to unhook
	   	@priority:		The priority of which the above method has in the add_action
	   	============================= */
	   	
		public function remove_filters_for_anonymous_class( $hook_name = '', $class_name ='', $method_name = '', $priority = 0 ) {
		        global $wp_filter;
		        
		        // Take only filters on right hook name and priority
		        if ( !isset($wp_filter[$hook_name][$priority]) || !is_array($wp_filter[$hook_name][$priority]) )
		                return false;
		        
		        // Loop on filters registered
		        foreach( (array) $wp_filter[$hook_name][$priority] as $unique_id => $filter_array ) {
		                // Test if filter is an array ! (always for class/method)
		                if ( isset($filter_array['function']) && is_array($filter_array['function']) ) {
		                        // Test if object is a class, class and method is equal to param !
		                        if ( is_object($filter_array['function'][0]) && get_class($filter_array['function'][0]) && get_class($filter_array['function'][0]) == $class_name && $filter_array['function'][1] == $method_name ) {
		                                unset($wp_filter[$hook_name][$priority][$unique_id]);
		                        }
		                }
		                
		        }
		        
		        return false;
		}
		
	/* 	=============================
	   	Grabs the default variation ID, depending on the 
	   	settings for that particular product
	   	============================= */
	   	
	   	public function get_default_variation_id(){
	   		global $post, $woocommerce, $product;
	   		
	   		$defaultVarId = $product->id;
	   		
	   		if($product->product_type == 'variable'){
	   		
		   		$defaults = $product->get_variation_default_attributes();
				$variations = array_reverse($product->get_available_variations());
				
				if(!empty($defaults)){
					foreach($variations as $variation){
						
						$varCount = count($variation["attributes"]);
						
						$attMatch = 0; $partMatch = 0; foreach($defaults as $dAttName => $dAttVal){
							// $defaultVarId = false;
							if(isset($variation["attributes"]['attribute_'.$dAttName])) {
								$theAtt = $variation["attributes"]['attribute_'.$dAttName];
								if($theAtt == $dAttVal) {
									$attMatch++;
									$partMatch++;
								}
								if($theAtt == ""){
									$partMatch++;
								}
							}
						}
						
						if($varCount == $partMatch) {
							$defaultVarId = $variation['variation_id'];
						}
						
						if($varCount == $attMatch) {
							$defaultVarId = $variation['variation_id'];
						}
					}
				}
			
			}
			
			return $defaultVarId;
	   	}

	/* 	=============================
	   	If the URL contains variation data, get the related variation ID, if it exists, and overwrite the current selected ID
	   	============================= */
	   	
	   	public function get_selected_varaiton($currId){
	   		global $post, $woocommerce, $product;
	   		
	   		if($product->product_type == 'variable'){
	   		
		   		$variations = $product->get_available_variations();

				foreach($variations as $variation)
				{
					$attCount = count($variation['attributes']);
					$attMatches = 0;
					
					foreach($variation['attributes'] as $attKey => $attVal)
					{
						if(isset($_GET[$attKey]) && $_GET[$attKey] == $attVal) $attMatches++;
					}
					
					if($attCount == $attMatches) $currId = $variation['variation_id'];
				}
			
			}
			
			return $currId;
	   	}
	   	
	/* 	=============================
	   	Get all attached Image IDs
	   	@id = the product or variation ID
	   	============================= */
	   	
	   	public function get_all_image_ids($id){

		   	$allImages = array();
		   	$show_gallery = false;   	
		   	
		   	// Main Image
			if(has_post_thumbnail($id)){
    			
				$allImages[] = get_post_thumbnail_id($id);
				
			} else {
    			
				$prod = get_post($id);
				$prodParentId = $prod->post_parent;
				if($prodParentId && has_post_thumbnail($prodParentId)){
					$allImages[] = get_post_thumbnail_id($prodParentId);
				} else {
					$allImages[] = 'placeholder';
				}
				
				$show_gallery = true;
			}
			
			// WooThumb Attachments
			if(get_post_type($id) == 'product_variation'){
			   	$wtAttachments = array_filter(explode(',', get_post_meta($id, 'variation_image_gallery', true)));
			   	$allImages = array_merge($allImages, $wtAttachments);
		   	}
			
			// Gallery Attachments
			
			if(get_post_type($id) == 'product' || $show_gallery){
				$product = get_product($id);
				$attachIds = $product->get_gallery_attachment_ids();
				
				if(!empty($attachIds)){
					$allImages = array_merge($allImages, $attachIds);
				}
			}
			
			return $allImages;
	   	}
	
	/* 	=============================
	   	Get required image sizes based 
	   	on array of image IDs
	   	============================= */
	   	
	   	public function get_all_image_sizes($imgIds){
	   		$images = array();
		   	if(!empty($imgIds)){
			   	foreach($imgIds as $imgId):
			   		if($imgId == 'placeholder'){
			   			$images[] = array(
			   				'large' => array( wc_placeholder_img_src('large') ),
			   				'single' => array( wc_placeholder_img_src('shop_single') ),
			   				'thumb' => array( wc_placeholder_img_src('thumbnail') ),
			   				'alt' => '',
			   				'title' => ''
			   			);
			   		} else {
				   		if(!array_key_exists($imgId, $images)){
                            if(!empty($imgId)):
                                $attachment = $this->wp_get_attachment($imgId);
                                $images[] = array(
                                    'large' => wp_get_attachment_image_src($imgId, 'large'),
                                    'single' => wp_get_attachment_image_src($imgId, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' )),
                                    'thumb' => wp_get_attachment_image_src($imgId, 'thumbnail'),
                                    'alt' => $attachment['alt'],
                                    'title' => $attachment['title']
                                );
                            endif;
				   		}
			   		}
			   	endforeach;
		   	}
		   	return $images;
	   	}
	   	
	   	public function wp_get_attachment( $attachment_id ) {
			$attachment = get_post( $attachment_id );
            if(!empty($attachment)):
                return array(
                    'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
                    'caption' => $attachment->post_excerpt,
                    'description' => $attachment->post_content,
                    'href' => get_permalink( $attachment->ID ),
                    'src' => $attachment->guid,
                    'title' => $attachment->post_title
                );
            endif;
		}
  
} // end class

$jck_woothumbs_class = new JCKWooThumbs();