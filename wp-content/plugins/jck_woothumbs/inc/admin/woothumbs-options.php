<?php
if ( !class_exists( "ReduxFramework" ) ) { return; }

if ( !class_exists( "JCKWooThumbs_Config" ) ) {
	class JCKWooThumbs_Config {

		public $args = array();
		public $sections = array();
		public $theme;
		public $redux_framework;
		public $plugin_name;
		public $plugin_shortname;
		public $plugin_slug;
		public $plugin_version;
		public $plugin_url;

		public function __construct() {

			global $jck_woothumbs_class;

			// Just for demo purposes. Not needed per say.
			$this->theme = wp_get_theme();
			$this->plugin_name = $jck_woothumbs_class->name;
			$this->plugin_shortname = $jck_woothumbs_class->shortname;
			$this->plugin_slug = $jck_woothumbs_class->slug;
			$this->plugin_version = $jck_woothumbs_class->version;
			$this->plugin_url = $jck_woothumbs_class->plugin_url;

			// Set the default arguments
			$this->set_arguments();

			// Create the sections and fields
			$this->set_sections();

			if ( !isset( $this->args['opt_name'] ) )
				{ // No errors please
				return;
			}

			$this->redux_framework = new ReduxFramework($this->sections, $this->args);

		}


		public function set_sections() {

			// ACTUAL DECLARATION OF SECTIONS

			$this->sections[] = array(
				'title' => __('Display Settings', $this->plugin_slug),
				'desc' => __('', $this->plugin_slug),
				'icon' => 'el-icon-picture',
				'fields' => array(
					array(
						'id'            =>'slideMode',
						'type'          => 'select',
						'title'         => __('Mode', $this->plugin_slug),
						'subtitle'      => __('How should the main images transition?', $this->plugin_slug),
						'options'       => array( 'horizontal' => 'Horizontal', 'vertical' => 'Vertical', 'fade' => 'Fade' ),
						'default'       => 'horizontal'
					),
				    array(
						'id'            => 'slideSpeed',
						'type'          => 'text',
						'title'         => __('Transition Speed', $this->plugin_slug),
						'subtitle'      => __('The speed at which images slide or fade in milliseconds.', $this->plugin_slug),
						'validate'      => 'numeric',
						'default'       => 250
					),
					array(
				        'id'            => 'iconColour',
				        'type'          => 'color',
				        'title'         => __('Icon Colours', $this->plugin_slug),
				        'default'       => '#7C7C7C',
				        'validate'      => 'color',
				        'transparent'   => false
				    ),   
				) // fields
			); // section
			
			// ! Dimensions
			
			$this->sections[] = array(
				'title' => __('Slider Dimensions', $this->plugin_slug),
				// 'desc' => __('Choose your method of navigation.', $this->plugin_slug),
				'icon' => 'el-icon-resize-horizontal',
				'fields' => array(			
					array(
					    'id'       => 'sliderWidth',
					    'type'     => 'dimensions',
					    'units'    => array('%', 'px'),
					    'title'    => __('Default Slider Width', $this->plugin_slug),
					    'subtitle' => __('The default width of the slider.', $this->plugin_slug),
					    'height'   => false,
					    'default'  => array(
					        'width'   => '48%',
					        'units'    => '%'
					    )
					),
					array(
						'id'       => 'sliderPosition',
						'type'     => 'image_select',
						'title'    => __('Slider Position', $this->plugin_slug), 
						'subtitle' => __('Float left, right, or not at all.', $this->plugin_slug),
						'options'  => array(
							'left' => array(
								'alt' => 'Left', 
								'img' => $this->plugin_url.'assets/admin/img/sel-sliderL.png'
							),
							'right' => array(
								'alt' => 'Right', 
								'img' => $this->plugin_url.'assets/admin/img/sel-sliderR.png'
							),
							'none' => array(
								'alt' => 'None', 
								'img' => $this->plugin_url.'assets/admin/img/sel-sliderN.png'
							)
						),
						'default' => 'left'
					),
					array(
						'id'=>'enableBreakpoint',
						'type' => 'switch',
						'title' => __('Enable Breakpoint?', $this->plugin_slug),
						'subtitle'=> __('If your website is responsive, it would be useful to change the width of the slider after a certain breakpoint.', $this->plugin_slug),
						"default"   => "0",
						'on' => 'Yes',
						'off' => 'No',
					),
					array(
					    'id'       => 'breakpoint',
					    'type'     => 'dimensions',
					    'units'    => array('em', 'px'),
					    'title'    => __('Breakpoint', $this->plugin_slug),
					    'subtitle'=> __('The slider width will be affected from this breakpoint and below.', $this->plugin_slug),
					    'required' => array('enableBreakpoint', '=' , 1),
					    'height'   => false,
					    'default'  => array(
					        'width'   => '768px',
					        'units'    => 'px'
					    )
					),
					array(
					    'id'       => 'sliderWidthBreakpoint',
					    'type'     => 'dimensions',
					    'units'    => array('%', 'px'),
					    'title'    => __('Slider Width After Breakpoint', $this->plugin_slug),
					    'subtitle' => __('The width of the slider from the breakpoint down.', $this->plugin_slug),
					    'required' => array('enableBreakpoint', '=' , 1),
					    'height'   => false,
					    'default'  => array(
					        'width'   => '100%',
					        'units'    => '%'
					    )
					),
					array(
						'id'       => 'sliderPositionBreakpoint',
						'type'     => 'image_select',
						'title'    => __('Slider Position After Breakpoint', $this->plugin_slug), 
						'subtitle' => __('Float left, right, or not at all.', $this->plugin_slug),
						'required' => array('enableBreakpoint', '=' , 1),
						'options'  => array(
							'left' => array(
								'alt' => 'Left', 
								'img' => $this->plugin_url.'assets/admin/img/sel-sliderL.png'
							),
							'right' => array(
								'alt' => 'Right', 
								'img' => $this->plugin_url.'assets/admin/img/sel-sliderR.png'
							),
							'none' => array(
								'alt' => 'None', 
								'img' => $this->plugin_url.'assets/admin/img/sel-sliderN.png'
							)
						),
						'default' => 'none'
					),
				)
			);
			
			// ! Thumbnail Settings
			
			$this->sections[] = array(
				'title' => __('Navigation Settings', $this->plugin_slug),
				//'desc' => __('Choose your method of navigation.', $this->plugin_slug),
				'icon' => 'el-icon-th-large',
				'fields' => array(
					// Thumbnails/Bullets/Tabs
					array(
						'id'=>'enableArrows',
						'type' => 'switch',
						'title' => __('Enable Prev/Next Arrows?', $this->plugin_slug),
						'subtitle'=> __('This will display prev/next arrows over the main slider image.', $this->plugin_slug),
						"default"   => "1",
						'on' => 'Yes',
						'off' => 'No',
					),
					array(
						'id'=>'enableNavigation',
						'type' => 'switch',
						'title' => __('Enable Navigation?', $this->plugin_slug),
						'subtitle'=> __('Choose whether to enable the thumbnail or bullet navigation.', $this->plugin_slug),
						"default"   => "1",
						'on' => 'Yes',
						'off' => 'No',
					),
					array(
						'id'=>'navigationType',
						'type' => 'select',
						'title' => __('Navigation Type', $this->plugin_slug),
						'required' => array('enableNavigation', '=' , 1),
						'options' => array('sliding' => 'Sliding Thumbnails', 'stacked' => 'Stacked Thumbnails', 'bullets' => 'Bullets'),
						'default' => 'sliding'
					),
					array(
						'id'       => 'thumbnailLayout',
						'type'     => 'image_select',
						'title'    => __('Thumbnail Layout', $this->plugin_slug), 
						'subtitle' => __('Display the thumbnails above, below, left, or right.', $this->plugin_slug),
						'required' => array(
						                array('enableNavigation', '=' , 1),
						                array('navigationType', '=' , array('sliding','stacked')),
						              ),
						'options'  => array(
							'above' => array(
								'alt' => 'Above', 
								'img' => $this->plugin_url.'assets/admin/img/sel-thumbsA.png'
							),
							'below' => array(
								'alt' => 'Below', 
								'img' => $this->plugin_url.'assets/admin/img/sel-thumbsB.png'
							),
							'left' => array(
								'alt' => 'Left', 
								'img' => $this->plugin_url.'assets/admin/img/sel-thumbsL.png'
							),
							'right' => array(
								'alt' => 'Right', 
								'img' => $this->plugin_url.'assets/admin/img/sel-thumbsR.png'
							)
						),
						'default' => 'below'
					),
					array(
						'id'=>'thumbnailWidth',
						'type' => 'text',
						'title' => __('Thumbnails Width (%)', $this->plugin_slug),
						'required' => array(
						                array('enableNavigation', '=' , 1),
						                array('thumbnailLayout', '=' , array('left','right')),
						              ),
						'validate' => 'numeric',
						'default' => 20
					),
					array(
						'id'=>'thumbnailCount',
						'type' => 'text',
						'title' => __('Thumbnail Count', $this->plugin_slug),
						'required' => array(
						                array('enableNavigation', '=' , 1),
						                array('navigationType', '!=' , array('bullets')),
						              ),
						'subtitle' => __('The number of thumbnails to display in a row/column.', $this->plugin_slug),
						'validate' => 'numeric',
						'default' => 4
					),
					array(
						'id'=>'thumbnailSpeed',
						'type' => 'text',
						'title' => __('Transition Speed', $this->plugin_slug),
						'required' => array(
						                array('enableNavigation', '=' , 1),
						                array('navigationType', '=' , array('sliding')),
						              ),
						'subtitle' => __('The speed at which the sliding thumbnail navigation moves in milliseconds.', $this->plugin_slug),
						'validate' => 'numeric',
						'default' => 250
					),
					array(
						'id'=>'thumbnailSpacing',
						'type' => 'text',
						'title' => __('Thumbnail Spacing', $this->plugin_slug),
						'required' => array(
						                array('enableNavigation', '=' , 1),
						                array('navigationType', '!=' , array('bullets')),
						              ),
						'subtitle' => __('The space between each thumbnail.', $this->plugin_slug),
						'validate' => 'numeric',
						'default' => 0
					)
				) // fields
			); // section
			
			// ! Zoom Settings
			
			$this->sections[] = array(
				'title' => __('Zoom Settings', $this->plugin_slug),
				'desc' => __('Please note: The zoom feature uses the "Single Product" image size from the WooCommerce settings as the image in the slider, and it uses the "Large" image size, from WordPress\' Settings > Media, as the image you see when hovering.', $this->plugin_slug),
				'icon' => 'el-icon-zoom-in',
				'fields' => array(
					array(
						'id'=>'enableZoom',
						'type' => 'switch',
						'title' => __('Enable Hover Zoom?', $this->plugin_slug),
						// 'subtitle'=> __('Look, it\'s on! Also hidden child elements!', $this->plugin_slug),
						"default"   => "1",
						'on' => 'Yes',
						'off' => 'No',
					),
					array(
						'id'=>'zoomType',
						'type' => 'select',
						'title' => __('Zoom Type', $this->plugin_slug),
						'required' => array('enableZoom', '=' , 1),
						// 'subtitle' => __('Choose your slide navigation type.', $this->plugin_slug),
						'options' => array('inner' => 'Inner', 'standard' => 'Outside', 'follow' => 'Follow'),
						'default' => 'inner'
					),
					array(
						'id'=>'innerShape',
						'type' => 'select',
						'title' => __('Zoom Shape', $this->plugin_slug),
						'required' => array('zoomType', '=' , 'follow'),
						// 'subtitle' => __('Choose your slide navigation type.', $this->plugin_slug),
						'options' => array('circular' => 'Circular', 'square' => 'Square'),
						'default' => 'circular'
					),
				    array(
						'id'=>'zoomPosition',
						'type' => 'select',
						'title' => __('Zoom Position', $this->plugin_slug),
						'required' => array('zoomType', '=' , 'standard'),
						'subtitle' => __('Choose the position of your zoomed image in relation to the main image.', $this->plugin_slug),
						'options' => array('left' => 'Left', 'right' => 'Right'),
						'default' => 'right'
					),
					array(
				        'id'       => 'zoomDimensions',
				        'type'     => 'dimensions',
				        'units'    => false,
				        'required' => array('zoomType', '=' , array('standard','follow')),
				        'title'    => __('Lens Size', $this->plugin_slug),
				        'subtitle' => __('The width and height of your zoom lens.', $this->plugin_slug),
				        'default'  => array(
				            'width'   => '200', 
				            'height'  => '200'
				        ),
				    ),
				    array(
				        'id'       => 'lensColour',
				        'type'     => 'color',
				        'title'    => __('Lens Colour', $this->plugin_slug),
				        'required' => array('zoomType', '=' , 'standard'),
				        'subtitle' => __('Pick a colour for the zoom lens (default: #000).', $this->plugin_slug),
				        'default'  => '#000000',
				        'validate' => 'color',
				    ),
				    array(
						'id'=>'lensOpacity',
						'type' => 'text',
						'title' => __('Lens Opacity', $this->plugin_slug),
						'required' => array('zoomType', '=' , 'standard'),
						'subtitle' => __('Set an opacity for the lens.', $this->plugin_slug),
						'desc' => __('<strong>0</strong> is transparent. <br><strong>1</strong> is opaque. <br><strong>0.5</strong> is 50% transparency.', $this->plugin_slug),
						'validate' => 'numeric',
						'default' => 0.8
					)
				) // fields
			); // section
			
			// ! Lightbox Settings
			
			$this->sections[] = array(
				'title' => __('Fullscreen Settings', $this->plugin_slug),
				'desc' => '',
				'icon' => 'el-icon-resize-full',
				'fields' => array(
					array(
						'id'=>'enableLightbox',
						'type' => 'switch',
						'title' => __('Enable Fullsrcreen?', $this->plugin_slug),
						// 'subtitle'=> __('Look, it\'s on! Also hidden child elements!', $this->plugin_slug),
						"default"   => "1",
						'on' => 'Yes',
						'off' => 'No',
					),
					array(
						'id'=>'clickAnywhere',
						'type' => 'switch',
						'required' => array('enableLightbox', '=' , 1),
						'title' => __('Click anywhere on the main image to trigger fullsrcreen?', $this->plugin_slug),
						"default"   => "0",
						'on' => 'Yes',
						'off' => 'No',
					)
				) // fields
			); // section
			
			// ! Additional Settings
			
			$this->sections[] = array(
				'title' => __('Additional Settings', $this->plugin_slug),
				'desc' => __('', $this->plugin_slug),
				'icon' => 'el-icon-cog',
				'fields' => array(
					array(
						'id'=>'additionalCss',
						'type' => 'ace_editor',
						'title' => __('Additional CSS', $this->plugin_slug),
						'desc' => __('Add any additional CSS here.', $this->plugin_slug),
						'mode' => 'css'
					)
				) // fields
			); // section



		}
	   	
		public function set_arguments() {

			$this->args = array(

				// TYPICAL -> Change these values as you need/desire
				'opt_name'           => $this->plugin_slug, // This is where your data is stored in the database and also becomes your global variable name.
				'display_name'   => $this->plugin_name, // Name that appears at the top of your panel
				'display_version'  => $this->plugin_version, // Version that appears at the top of your panel
				'menu_type'           => 'submenu', //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
				'allow_sub_menu'      => true, // Show the sections below the admin menu item or not
				'menu_title'   => __( 'WooThumbs', $this->plugin_slug ),
				'page'       => __( 'WooThumbs', $this->plugin_slug ),
				'google_api_key'      => '', // Must be defined to add google fonts to the typography module
				'global_variable'     => '', // Set a different name for your global variable other than the opt_name
				'dev_mode'            => false, // Show the time the page took to load, etc
				'customizer'          => true, // Enable basic customizer support

				// OPTIONAL -> Give you extra features
				'page_priority'       => null, // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
				'page_parent'         => 'woocommerce', // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
				'page_permissions'    => 'manage_options', // Permissions needed to access the options panel.
				'menu_icon'           => '', // Specify a custom URL to an icon
				'last_tab'            => '', // Force your panel to always open to a specific tab (by id)
				'page_icon'           => 'icon-themes', // Icon displayed in the admin panel next to your menu_title
				'page_slug'           => $this->plugin_slug.'_options', // Page slug used to denote the panel
				'save_defaults'       => true, // On load save the defaults to DB before user clicks save or not
				'default_show'        => false, // If true, shows the default value next to each field that is not the default value.
				'default_mark'        => '', // What to print by the field's title if the value shown is default. Suggested: *


				// CAREFUL -> These options are for advanced use only
				'transient_time'    => 60 * MINUTE_IN_SECONDS,
				'output'             => true, // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
				'output_tag'             => true, // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
				//'domain'              => 'redux-framework', // Translation domain key. Don't change this unless you want to retranslate all of Redux.
				'footer_credit'       => ' ', // Disable the footer credit of Redux. Please leave if you can help it.


				// FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
				'database'            => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!


				'show_import_export'  => true, // REMOVE
				'system_info'         => false, // REMOVE

				'help_tabs'           => array(),
				'help_sidebar'        => '', // __( '', $this->args['domain'] );
			);

		}
	}
	
	new JCKWooThumbs_Config();
}