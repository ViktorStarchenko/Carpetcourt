<?php
/**
* 
*/
class CC_Cpt  {
	
	private static $instance;

	public static function get_instance() {

	 	if( null == self::$instance ) {
	 		self::$instance = new CC_Cpt();
	 	} 
	 	return self::$instance;
	} 


	public function __construct() {
		
		add_action( 'init', array($this,'cc_register_post_type_attributes' ) );

		add_filter( 'post_row_actions', array( $this, 'remove_row_actions'), 10, 1 );
		
		add_action('admin_head', array( $this, 'posttype_admin_css') ); 

		add_filter( 'single_template',  array($this,'get_attribute_single_template') );
		
	}

	/**
	* Registers a new post type
	* @uses $wp_post_types Inserts new post type object into the list
	*
	* @param string  Post type key, must not exceed 20 characters
	* @param array|string  See optional args description above.
	* @return object|WP_Error the registered post type object, or an error object
	*/


	public function cc_register_post_type_attributes() {

		$labels = array(
			'name'                => __( 'Attributes', 'cc_product_filter' ),
			'singular_name'       => __( 'Attribute', 'cc_product_filter' ),
			'add_new'             => _x( 'Add New Attribute', 'cc_product_filter', 'cc_product_filter' ),
			'add_new_item'        => __( 'Add New Attribute', 'cc_product_filter' ),
			'edit_item'           => __( 'Edit Attribute', 'cc_product_filter' ),
			'new_item'            => __( 'New Attribute', 'cc_product_filter' ),
			'view_item'           => __( 'View Attribute', 'cc_product_filter' ),
			'search_items'        => __( 'Search Attributes', 'cc_product_filter' ),
			'not_found'           => __( 'No Attributes found', 'cc_product_filter' ),
			'not_found_in_trash'  => __( 'No Attributes found in Trash', 'cc_product_filter' ),
			'parent_item_colon'   => __( 'Parent Attribute:', 'cc_product_filter' ),
			'menu_name'           => __( 'Attributes', 'cc_product_filter' ),
		);

		$args = array(
			'labels'                   => $labels,
			'hierarchical'        => false,
			'description'         => 'description',
			'taxonomies'          => array(),
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => null,
			'menu_icon'           => null,
			'show_in_nav_menus'   => false,
			'publicly_queryable'  => true,
			'exclude_from_search' => false,
			'has_archive'         => false,
			'query_var'           => true,
			'can_export'          => true,
			'rewrite'             => true,
			'capability_type'     => 'post',
			'supports'            => array(
				'title', 'editor', 'author', 'thumbnail',
				'excerpt','custom-fields', 'trackbacks', 'comments',
				'revisions', 'page-attributes', 'post-formats'
				)
		);

		register_post_type( 'attribute', $args );
	}


	public function get_attribute_single_template($single_template) {
	     global $post;
	     if ($post->post_type == 'attribute') {
	          $single_template = PATH . '/single-attribute.php';
	     }
	     return $single_template;
	}

	public function remove_row_actions( $actions ) {
		if( get_post_type() === 'attribute' )
		        unset( $actions['view'] );
		    return $actions;
	}

	function posttype_admin_css() {
		global $post_type;
		if( $post_type == 'attribute' ) {
			echo '<style type="text/css">#edit-slug-box,#view-post-btn,#post-preview,.updated p a{display: none;}</style>';
		}
	}
}

