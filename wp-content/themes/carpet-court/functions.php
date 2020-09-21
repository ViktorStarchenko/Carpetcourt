<?php

show_admin_bar(false);
define('FS_METHOD', 'direct');
define('ALLOW_UNFILTERED_UPLOADS', true);
define('CATEGORY_FLOORING_ID', 27928);
define('CATEGORY_ALL_ID', 27927);
define('CATEGORY_CARPET_ID', 7);

include "include/findStore.php";
include "include/acfAdminPanel.php";
include "include/product_imposrt.php";
include "include/import_blog.php";

add_filter( 'woocommerce_breadcrumb_home_url', 'carpet_woo_custom_breadrumb_home_url' );
function carpet_woo_custom_breadrumb_home_url() {
    return get_option( 'home' );
}

if ( ! function_exists( 'carpet_court_setup' ) ) :
  function carpet_court_setup() {
    add_image_size( 'category_image', 340, 260, true );
    add_image_size( 'filter_image', 110, 80, true );
    // add_image_size( 'filtertype_image', 115, 75, true );
    add_image_size( 'filtertype_image', 260, 170, true );
    add_image_size( 'colour_palettes', 620, 470, true ); //added by sujan
    add_image_size( 'product-wide', 664, 360, true );
    add_image_size( 'cc_gal_image', 600, 600, true );
    add_image_size( 'masonry_large', 951, 630, true );
    add_image_size( 'masonry_small', 476, 315, true );
    add_image_size( 'masonry_horizontal', 951, 315, true );
    add_image_size( 'masonry_change_small', 500, 500, true );
    add_image_size( 'masonry_change_horizontal', 1000, 500, true );
    add_image_size( 'masonry_change_large', 1000, 1000, true );
    add_image_size( 'idea_small', 300, 300, true );
    add_image_size( 'idea_vertical', 300, 600, true );
    add_image_size( 'idea_horizontal', 600, 300, true );
    add_image_size( 'idea_large', 600, 600, true );
    add_image_size( 'cc_gallery_212', 212, 212, true );
    add_image_size( 'cc_gallery_93', 93, 93, true );
    load_theme_textdomain( 'carpet-court', get_template_directory() . '/languages' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    register_nav_menus( array(
      'primary' => esc_html__( 'Primary', 'carpet-court' ),
      'notification' => esc_html__( 'Notification Menu', 'carpet-court' ),
      'top_navv' => esc_html__( 'Top Menu By the side of Notification menu', 'carpet-court' ),
      ) );
    add_theme_support( 'html5', array(
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
      ) );
    add_theme_support( 'post-formats', array(
      'aside',
      'image',
      'video',
      'quote',
      'link',
      ) );
  }
  endif;
  add_action( 'after_setup_theme', 'carpet_court_setup' );

  function carpet_court_content_width() {
   $GLOBALS['content_width'] = apply_filters( 'carpet_court_content_width', 640 );
 }
 add_action( 'after_setup_theme', 'carpet_court_content_width', 0 );

 function carpet_court_widgets_init() {
   register_sidebar( array(
    'name'          => esc_html__( 'Sidebar', 'carpet-court' ),
    'id'            => 'sidebar-1',
    'description'   => '',
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
    ) );
 }
 add_action( 'widgets_init', 'carpet_court_widgets_init' );

 function carpet_court_scripts() {
     wp_enqueue_style( 'cc-plugin-style', get_template_directory_uri().'/assets/css/cpm-plugins.css' );
     wp_enqueue_style( 'theme-custom-css-style', get_template_directory_uri().'/style.css' );
     wp_enqueue_style('hm_custom_css', get_site_url(null, '/index.php').'?hm_custom_css_draft=1', array(), time());
     if(!newDesign()){
         /*bootstrap.min.css included in vertical.min.css*/
         // wp_enqueue_style( 'carpet-court-vertical-css', get_template_directory_uri().'/assets/css/vertical.min.css' );
         wp_enqueue_style( 'carpet-court-style', get_stylesheet_uri() );
         wp_enqueue_style( 'carpet-court-fonts', '//fonts.googleapis.com/css?family=Montserrat:400,700|Poppins:400,300,500,600,700' );
         wp_enqueue_style( 'carpet-court-vc-css', get_template_directory_uri().'/inc/vc-elements/assets/cc-vc-style.css' );
         // wp_enqueue_style( 'carpet-court-pretty', get_template_directory_uri().'/assets/css/prettyPhoto.css' );
         // wp_enqueue_style( 'cc-custom-style', get_template_directory_uri().'/assets/css/custom-style.css' );

         wp_enqueue_script('jquery');
         wp_enqueue_script( 'carpet-court-plugins-js', get_template_directory_uri() . '/assets/js/cc-plugins.js', array('jquery'), '', true );
         wp_enqueue_script( 'cc-easyzoom-resene', get_template_directory_uri().'/assets/js/easyzoom.js', '', '', true );
         wp_enqueue_script( 'carpet-court-script-js', get_template_directory_uri() . '/assets/js/script.js', '', '1.0.07', true );

         wp_enqueue_script("jquery-cpm-ui", get_template_directory_uri() . '/assets/js/jquery-ui.min.js', array('jquery'), '', true );
         wp_enqueue_style( 'mytheme-style', get_stylesheet_uri(), 'dashicons' );

         wp_enqueue_style('j-ui-css', get_template_directory_uri() . '/assets/css/jquery-ui.min.css');


         wp_enqueue_script( 'isotope-init', get_template_directory_uri().'/inc/vc-elements/assets/cc-isotope.js', array('isotope'), '', false );

         if( is_product() ){

             wp_enqueue_style( 'owl-css', get_template_directory_uri().'/owl-carousel/owl.carousel.css' );
             // wp_enqueue_style( 'owl-themes-css', get_template_directory_uri().'/owl-carousel/owl.theme.css' );
             wp_enqueue_script( 'cc-owl-carousel-js', get_template_directory_uri() . '/owl-carousel/owl.carousel.js', array('jquery'), '', true );
             wp_enqueue_script( 'pin-it-js', '//assets.pinterest.com/js/pinit.js', array('jquery'), '', true );
             // wp_enqueue_script( 'cpm-product-script', get_template_directory_uri().'/assets/js/cpm-product.js', '', '', true);
             // wp_enqueue_script( 'cc-color-sswatches', get_template_directory_uri().'/assets/js/product-slider-swatches.js', '', '', true );
         }

         if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
             wp_enqueue_script( 'comment-reply' );
         }

         if ( is_singular('wpsl_stores') ) {
             wp_enqueue_script( 'store-profile-js', get_template_directory_uri().'/assets/js/cpm-store-profile.js');
         }

         if(is_search()){
             wp_enqueue_style('masonry');
             wp_enqueue_script( 'mason-imagesloaded', get_template_directory_uri().'/assets/js/imagesloaded.pkgd.min.js', '', '', true );
             wp_enqueue_script('masonry');
             wp_enqueue_script( 'mason-script', get_template_directory_uri().'/assets/js/mason-script.js', '', '', true );
         }

         $script_modal = array(
             'ajax_url'   => admin_url( 'admin-ajax.php' ),
             'base_url'   => home_url( '/' ),
             'ajax_nonce' => wp_create_nonce('woo_user_remove')
         );

         wp_localize_script( 'carpet-court-script-js', 'script_modal', $script_modal );

         if(!is_admin()) {
             // new design
             enqueue_versioned_style('theme-styles', '/static/public/css/app.min.css');
             enqueue_versioned_script( 'slick-slider-js',  '/static/public/js/libs/slick.min.js', array('jquery'), true);
             enqueue_versioned_script( 'sticky-slider-js',  '/static/public/js/libs/sticky.min.js', array('jquery'), true);
             enqueue_versioned_script( 'theme-js',  '/assets/js/app.min.js', array('jquery'), true);
			 enqueue_versioned_script( 'new-js',  '/assets/js/app-new.js', array('jquery'), true);
			 enqueue_versioned_script( 'ajax-search',  '/assets/js/ajax-search.js', array('jquery'), true);

         }
     } else {
         if(!is_admin()) {
            // new design
            enqueue_versioned_style('theme-styles', '/static/public/css/app.min.css');
            //wp_deregister_script( 'jquery' );
            //enqueue_versioned_script( 'jquery',  '/static/public/js/libs/jquery-3.2.1.min.js', false, false);
            //wp_enqueue_script( 'jquery' );
            enqueue_versioned_script( 'slick-slider-js',  '/static/public/js/libs/slick.min.js', array('jquery'), true);
            enqueue_versioned_script( 'sticky-slider-js',  '/static/public/js/libs/sticky.min.js', array('jquery'), true);
            enqueue_versioned_script( 'bootstrap-js',  '/static/public/js/bootstrap.min.js', array('jquery'), true);
            enqueue_versioned_script( 'theme-js',  '/static/public/js/app.min.js', array('jquery'), true);
			 enqueue_versioned_script( 'new-js',  '/assets/js/app-new.js', array('jquery'), true);
			enqueue_versioned_script( 'ajax-search',  '/assets/js/ajax-search.js', array('jquery'), true);

         }
     }
	 wp_localize_script( 'ajax-search', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
     enqueue_versioned_style('theme-store-locator', '/assets/css/store-locator-custom.css');

     //addRelatedProducts();
}
add_action( 'wp_enqueue_scripts', 'carpet_court_scripts' );

require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/extras.php';
require get_template_directory() . '/modules/loader.php';
require get_template_directory() . '/admin/theme-options.php';
require get_template_directory() . '/inc/wp_bootstrap_navwalker.php';
//post types
require get_template_directory() . '/inc/cc-post-types.php';
// vc elements
require get_template_directory() . '/inc/vc-elements/vc-elements.php';
//woocommerce changes
require get_template_directory() . '/inc/woo-changes.php';
require get_template_directory() . '/inc/woo-register-fields.php';
// woocommerce brand
require get_template_directory() . '/inc/woo-brand.php';
// woocommerce key feature
require get_template_directory() . '/inc/woo-key_feature.php';
// woocommerce Delivery Type
require get_template_directory() . '/inc/woo-delivery.php';
/*yith wishlist*/
require get_template_directory() . '/wishlist/wishlist.php';

/*woo changes*/
require get_template_directory() . '/inc/woo-colors.php';

// add_filter('show_admin_bar', '__return_false');


// Apply filter
add_filter('body_class', 'cc_check_slider');
function cc_check_slider($classes) {
  $slider = get_field('slider_shortcode');
  if(empty($slider)){
    if(!is_page_template('product-search-progressbar.php') && !is_singular('cc_troubleshooting')){
      $classes[] = 'no-overlap';
    }
  }
  return $classes;
}

add_action('yith_wcwl_before_wishlist_create','cc_wishlist_create_before');
add_action('yith_wcwl_before_wishlist_manage','cc_wishlist_create_before');
add_action('yith_wcwl_before_wishlist_title','cc_wishlist_create_before');
function cc_wishlist_create_before() {
  echo '<div class="mb-20">';
}

add_action('yith_wcwl_after_wishlist_create','cc_wishlist_create_after');
add_action('yith_wcwl_after_wishlist_manage','cc_wishlist_create_after');
add_action('yith_wcwl_after_wishlist_title','cc_wishlist_create_after');

function cc_wishlist_create_after() {
  echo '</div>';
}


function cpm_move_comment_field_to_bottom( $fields ) {
  if ( is_product() ) {

    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    $fields['comment'] = $comment_field;
  }
  return $fields;
}

add_filter( 'comment_form_fields', 'cpm_move_comment_field_to_bottom' );



add_action( 'init', 'cpm_stain_posttype' );
function cpm_stain_posttype() {
  $labels = array(
    'name'               => _x( 'Stain Removal', 'post type general name', 'your-plugin-textdomain' ),
    'singular_name'      => _x( 'Stain Removal', 'post type singular name', 'your-plugin-textdomain' ),
    'menu_name'          => _x( 'Stain Removal', 'admin menu', 'your-plugin-textdomain' ),
    'name_admin_bar'     => _x( 'Stain Removal', 'add new on admin bar', 'your-plugin-textdomain' ),
    'add_new'            => _x( 'Add New', 'Stain Removal', 'your-plugin-textdomain' ),
    'add_new_item'       => __( 'Add New Stain Removal', 'your-plugin-textdomain' ),
    'new_item'           => __( 'New Stain Removal', 'your-plugin-textdomain' ),
    'edit_item'          => __( 'Edit Stain Removal', 'your-plugin-textdomain' ),
    'view_item'          => __( 'View Stain Removal', 'your-plugin-textdomain' ),
    'all_items'          => __( 'All Stain Removal', 'your-plugin-textdomain' ),
    'search_items'       => __( 'Search Stain Removal', 'your-plugin-textdomain' ),
    'parent_item_colon'  => __( 'Parent Stain Removal:', 'your-plugin-textdomain' ),
    'not_found'          => __( 'No stain removals found.', 'your-plugin-textdomain' ),
    'not_found_in_trash' => __( 'No stain removals found in Trash.', 'your-plugin-textdomain' )
    );

  $args = array(
    'labels'             => $labels,
    'description'        => __( 'Description.', 'your-plugin-textdomain' ),
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'rewrite'            => array( 'slug' => 'removal' ),
    // 'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => null,
    'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
    );

  register_post_type( 'stain_removal', $args );

  $floor_labels = array(
    'name'              => _x( 'Floor Types', 'taxonomy general name' ),
    'singular_name'     => _x( 'Floor Type', 'taxonomy singular name' ),
    'search_items'      => __( 'Search Floor Types' ),
    'all_items'         => __( 'All Floor Types' ),
    'parent_item'       => __( 'Parent Floor Type' ),
    'parent_item_colon' => __( 'Parent Floor Type:' ),
    'edit_item'         => __( 'Edit Floor Type' ),
    'update_item'       => __( 'Update Floor Type' ),
    'add_new_item'      => __( 'Add New Floor Type' ),
    'new_item_name'     => __( 'New Floor Type Name' ),
    'menu_name'         => __( 'Floor Types' ),
    );

  $floor_args = array(
    'hierarchical'      => true,
    'labels'            => $floor_labels,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'rewrite'           => array( 'slug' => 'floor' ),
    );

  register_taxonomy( 'floor_taxonomy', array( 'stain_removal' ), $floor_args );

  $fibre_labels = array(
    'name'              => _x( 'Fibre Types', 'taxonomy general name' ),
    'singular_name'     => _x( 'Fibre Type', 'taxonomy singular name' ),
    'search_items'      => __( 'Search Fibre Types' ),
    'all_items'         => __( 'All Fibre Types' ),
    'parent_item'       => __( 'Parent Fibre Type' ),
    'parent_item_colon' => __( 'Parent Fibre Type:' ),
    'edit_item'         => __( 'Edit Fibre Type' ),
    'update_item'       => __( 'Update Fibre Type' ),
    'add_new_item'      => __( 'Add New Fibre Type' ),
    'new_item_name'     => __( 'New Fibre Type Name' ),
    'menu_name'         => __( 'Fibre Types' ),
    );

  $fibre_args = array(
    'hierarchical'      => true,
    'labels'            => $fibre_labels,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'rewrite'           => array( 'slug' => 'fibre' ),
    );

  register_taxonomy( 'fibre_taxonomy', array( 'stain_removal' ), $fibre_args );

  $top_five_labels = array(
    'name'              => _x( 'Stain Type', 'taxonomy general name' ),
    'singular_name'     => _x( 'Stain Type', 'taxonomy singular name' ),
    'search_items'      => __( 'Search Stain Type' ),
    'all_items'         => __( 'All Stain Types' ),
    'parent_item'       => __( 'Parent Stain Type' ),
    'parent_item_colon' => __( 'Parent Stain Type:' ),
    'edit_item'         => __( 'Edit Stain Type' ),
    'update_item'       => __( 'Update Stain Type' ),
    'add_new_item'      => __( 'Add New Stain Type' ),
    'new_item_name'     => __( 'New Stain Type Name' ),
    'menu_name'         => __( 'Stain Type' ),
    );

  $top_five_args = array(
    'hierarchical'      => true,
    'labels'            => $top_five_labels,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'rewrite'           => array( 'slug' => 'top' ),
    );

  register_taxonomy( 'top_five_taxonomy', array( 'stain_removal' ), $top_five_args );



  $product_labels = array(
    'name'                       => 'Additional Options',
    'singular_name'              => 'Additional Option',
    'menu_name'                  => 'Additional Option',
    'all_items'                  => 'All Additional Options',
    'parent_item'                => 'Parent Additional Option',
    'parent_item_colon'          => 'Parent Additional Option:',
    'new_item_name'              => 'New Additional Option Name',
    'add_new_item'               => 'Add New Additional Option',
    'edit_item'                  => 'Edit Additional Option',
    'update_item'                => 'Update Additional Option',
    'separate_items_with_commas' => 'Separate Additional Option with commas',
    'search_items'               => 'Search Additional Options',
    'add_or_remove_items'        => 'Add or remove Additional Options',
    'choose_from_most_used'      => 'Choose from the most used Additional Options',
    );
  $product_args = array(
    'labels'                     => $product_labels,
    'hierarchical'               => true,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => false,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
    );
  register_taxonomy( 'additional_option', 'product', $product_args );
}


add_action( 'wp_ajax_filter_stan_removal', 'cpm_filter_stan_removal');
add_action( 'wp_ajax_nopriv_filter_stan_removal', 'cpm_filter_stan_removal');
function cpm_filter_stan_removal() {

  $stain_removal_args = array(
    'post_type' => 'stain_removal',
    'posts_per_page' => 1,
    'tax_query' => array(
      'relation' => 'AND',
      array(
        'taxonomy' => 'floor_taxonomy',
        'field'    => 'term_id',
        'terms'    => $_POST['floor_id'],
        ),
      array(
        'taxonomy' => 'fibre_taxonomy',
        'field'    => 'term_id',
        'terms'    => $_POST['fibre_id'],
        ),
      ),
    );
  $stain_removal_query = new WP_Query( $stain_removal_args );
  if ( $stain_removal_query->have_posts() ) {
    while ( $stain_removal_query->have_posts() ) {
      $stain_removal_query->the_post(); ?>
      <div class="col-md-6 feat-img-col">

        <?php the_post_thumbnail( 'cc_gal_image', true ); ?>
      </div>

      <div class="col-md-6 steps-col">
        <?php the_content(); ?>

      </div>
      <?php
    } wp_reset_postdata();
  }
  die();
}


add_action( 'yith_wcwl_after_wishlist_form', 'cpm_cc_yith_wcfbt_shortcode', 10, 1 );
function cpm_cc_yith_wcfbt_shortcode( $meta ) {
  echo '<div itemprop="description">Now you’ve got your eye on a few products, book a measure and quote with us - it’s easy - either we can come to your place at a time that suits, or you can visit us. </div><div class="cc-btn-wrap clearfix"><a href="#book-modal" data-toggle="modal" data-target="#book-modal" class="btn-cc btn btn-cc-red ">';
  _e('<span class="fa fa-angle-right"></span>BOOK MEASURE AND QUOTE', 'carpet-court');
  echo '</a></div>';

  ?>
  <div class="modal cc-model fade" id="book-modal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"
            id="book-modal"><?php _e('Book A Free Measure and Quote', 'carpet-court'); ?></h4>
          </div>
          <div class="modal-body clearfix">
            <div class="col-sm-12">
              <?php echo do_shortcode('[gravityform id=1 title=false description=false ajax=true]'); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
  }


  function cpm_cc_customize_register( $wp_customize ) {

    $wp_customize->add_panel('cpm_cc_option_panel', array(
      'capability' => 'edit_theme_options',
      'theme_supports' => '',
      'title' => __('CC Options'),
            'description' => __('Panel to update theme options'), // Include html tags such as <p>.
            'priority' => 10 // Mixed with top-level-section hierarchy.
            )
    );
    $wp_customize->add_section( 'cpm_cc_product_section',   array(
      'title'       => __( 'Product Order' ),
      'description' => __('Section for Product Order Setting' ),
      'panel'       => 'cpm_cc_option_panel',
      'priority'    => 32,
      )

    );

    $wp_customize->add_setting( 'cpm_cc_product_count', array(
      'default'           => '5',
      'capability'        => 'edit_theme_options',
      )
    );

    $wp_customize->add_control( 'cpm_cc_product_count', array(
      'label'    => __( 'No. of products' ),
      'section'  => 'cpm_cc_product_section',
      'description' => __('Enter the no. of products to display'),
      'type'     => 'text',
      'priority' => 1,
      )
    );

    $wp_customize->add_setting( 'cpm_cc_product_orderby', array(
      'default'           => 'date',
      )
    );

    $wp_customize->add_control(
      'cpm_cc_product_orderby',
      array(
        'type' => 'select',
        'label' => 'Order By',
        'priority' => 2,
        'section' => 'cpm_cc_product_section',
        'choices' => array(
          'ID' => 'ID',
          'title' => 'Title',
          'name' => 'Name',
          'date' => 'Date',
          ),
        )
      );

    $wp_customize->add_setting( 'cpm_cc_product_order', array(
      'default'           => 'DESC',
      )
    );

    $wp_customize->add_control(
      'cpm_cc_product_order',
      array(
        'type' => 'select',
        'label' => 'Order',
        'priority' => 3,
        'section' => 'cpm_cc_product_section',
        'choices' => array(
          'ASC' => 'ASC',
          'DESC' => 'DESC',
          ),
        )
      );

    $wp_customize->add_section( 'cpm_cc_w_n_o_section',   array(
      'title'       => __( 'Works Well & Other Product Settings' ),
      'description' => __('Product Order Setting in Works well with and Other products section.' ),
      'panel'       => 'cpm_cc_option_panel',
      'priority'    => 32,
      )
    );


    $wp_customize->add_setting( 'cpm_cc_works_n_other_product_count', array(
      'default'           => '6',
      'capability'        => 'edit_theme_options',
      )
    );

    $wp_customize->add_control( 'cpm_cc_works_n_other_product_count', array(
      'label'    => __( 'No. of products' ),
      'section'  => 'cpm_cc_w_n_o_section',
      'description' => __('Enter the no. of products to display in Works Well With and Other Product You Mignt Like'),
      'type'     => 'text',
      'priority' => 1,
      )
    );


    $wp_customize->add_section( 'cpm_cc_product_guide_steps',   array(
      'title'       => __( 'Product Guide' ),
      'description' => __('Set the contents for Product Guide Steps.' ),
      'panel'       => 'cpm_cc_option_panel',
      'priority'    => 33,
      )
    );

    $wp_customize->add_setting( 'cpm_cc_rent_image', array(
      'capability'        => 'edit_theme_options',
      ) );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'cpm_cc_rent_image', array(
      'label'    => __( 'Rent Image' ),
      'section'  => 'cpm_cc_product_guide_steps',
      )
    )
    );

    $wp_customize->add_setting( 'cpm_cc_rent_textarea', array(
      'capability'        => 'edit_theme_options',
      ) );

    $wp_customize->add_control( 'cpm_cc_rent_textarea', array(
      'label' => __( 'Rent Description' ),
      'type' => 'textarea',
      'section' => 'cpm_cc_product_guide_steps',
      ) );

    $wp_customize->add_setting( 'cpm_cc_sell_image', array(
      'capability'        => 'edit_theme_options',
      ) );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'cpm_cc_sell_image', array(
      'label'    => __( 'Sell Image' ),
      'section'  => 'cpm_cc_product_guide_steps',
      )
    )
    );

    $wp_customize->add_setting( 'cpm_cc_sell_textarea', array(
      'capability'        => 'edit_theme_options',
      ) );

    $wp_customize->add_control( 'cpm_cc_sell_textarea', array(
      'label' => __( 'Sell Description' ),
      'type' => 'textarea',
      'section' => 'cpm_cc_product_guide_steps',
      ) );


    $wp_customize->add_setting( 'cpm_cc_keep_image', array(
      'capability'        => 'edit_theme_options',
      ) );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'cpm_cc_keep_image', array(
      'label'    => __( 'Keep Image' ),
      'section'  => 'cpm_cc_product_guide_steps',
      )
    )
    );

    $wp_customize->add_setting( 'cpm_cc_keep_textarea', array(
      'capability'        => 'edit_theme_options',
      ) );

    $wp_customize->add_control( 'cpm_cc_keep_textarea', array(
      'label' => __( 'Keep Description' ),
      'type' => 'textarea',
      'section' => 'cpm_cc_product_guide_steps',
      ) );


    /*Mailchimp subscribe credentials*/
    $wp_customize->add_panel('cpm_mailchimp_panel', array(
      'capability' => 'edit_theme_options',
      'theme_supports' => '',
      'title' => __('Mailchimp Options'),
            'description' => __('Panel to add mailchimp API key, list id'), // Include html tags such as <p>.
            'priority' => 10 // Mixed with top-level-section hierarchy.
            )
    );
    $wp_customize->add_section( 'cpm_mailchimp_section',   array(
      'title'       => __( 'Mailchimp Option' ),
      'description' => __('Add Mailchimp Details' ),
      'panel'       => 'cpm_mailchimp_panel',
      'priority'    => 32,
      )

    );

    //Mailchimp Api Key
    $wp_customize->add_setting( 'cpm_mailchimp_api_key', array(
      'default'           => '',
      'capability'        => 'edit_theme_options',
      )
    );

    $wp_customize->add_control( 'cpm_mailchimp_api_key', array(
      'label'    => __( 'Mailchimp Api Key' ),
      'section'  => 'cpm_mailchimp_section',
      'description' => __('Enter the mailchimp api key generated'),
      'type'     => 'text',
      'priority' => 1,
      )
    );


    //Mailchimp List Id
    $wp_customize->add_setting( 'cpm_mailchimp_list_id', array(
      'default'           => '',
      'capability'        => 'edit_theme_options',
      )
    );

    $wp_customize->add_control( 'cpm_mailchimp_list_id', array(
      'label'    => __( 'Mailchimp List Id' ),
      'section'  => 'cpm_mailchimp_section',
      'description' => __('Enter the mailchimp list id'),
      'type'     => 'text',
      'priority' => 2,
      )
    );
  }
  add_action( 'customize_register', 'cpm_cc_customize_register' );


add_action( 'wp_ajax_cpm_send_message_to_stores', 'cpm_send_message_to_stores');
  add_action( 'wp_ajax_nopriv_cpm_send_message_to_stores', 'cpm_send_message_to_stores');
  function cpm_send_message_to_stores() {

    $subject = "Website Enquiry"; // Give the email a subject

    // Our message above including the link
    $headers = "From: ".$_POST['your_name']." <".$_POST['your_email'].">\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $headers .= "Content-Transfer-Encoding: 7BIT";
    $message = 'Hi there, <br><br>';
    $message .= 'You have received an enquiry from the Carpet Court website: <br><br>';
    $message .= "<strong>Name:</strong> ".$_POST['your_name']."<br>";
    $message .= "<strong>Email:</strong> ".$_POST['your_email']."<br>";
    $message .= "<strong>Message:</strong> ".$_POST['your_message']."<br><br><br>";
    $message .= "Warm Regards,<br>Carpet Court";
    $response = wp_mail($_POST['to_email'], $subject, $message, $headers);
    echo json_encode(array('status'=>$response) );
    die();
  }



function sv_wc_product_reviews_pro_remove_review_attachments( $fields ){

    $fields['comment']['placeholder'] = "What do you think of this product?";
    unset( $fields['attachment_type'] );
    unset( $fields['attachment_url'] );
    unset( $fields['attachment_file'] );
    return $fields;
  }
  add_filter( 'wc_product_reviews_pro_default_fields' , 'sv_wc_product_reviews_pro_remove_review_attachments' );



add_action( 'wp_ajax_send_all_wishlists', 'cpm_send_all_wishlists');
function cpm_send_all_wishlists() {

    global $wpdb;
  // $session_variable = $_SESSION['diagnostic_tour_product_filter'];
    $list_table_name = $wpdb->prefix . 'yith_wcwl_lists';
    $wlist_prod = $wpdb->prefix.'yith_wcwl';
    $wishlist = get_option('yith_wcwl_wishlist_title');
    $current_user = wp_get_current_user();
    $wish_lists_db = $wpdb->get_results( 'SELECT wishlist_name, ID from '.$list_table_name.' where user_id = '.$current_user->ID, ARRAY_A );
    $blog_url = get_option('home');
    $mail_to = $_POST['send_to'];
    $to_name = $_POST['store_name'];
    $explode_blog = explode( 'https://', $blog_url );
    $exploded = str_replace("/", "", $explode_blog[1]);
    $headers = "MIME-Version: 1.0"."\r\n";
    $headers .= "Content-Transfer-Encoding: 8bit"."\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8"."\r\n";
    $headers .= "From: ".get_option('blogname')." <wordpress@".$exploded.">" . "\r\n";
    $subject = 'Your Carpet Court Wishlist';
    $message = '<html><body style="color: #777788; font-family: "Poppins",sans-serif; font-size: 15px; line-height: 1.5; ">';
    $message .= "Hi ".$to_name.", <br/><br/>".$current_user->display_name." have requested wishlist items be emailed to you from Carpet Court. Not a problem at all, please see the wishlist below:<br/><br/>";
    $count = 1;
    $w_product_array = array();

    $color_id = $_SESSION['add_color_id'];
    if ( isset( $color_id ) && !empty( $color_id ) ) {
  # code...
      if ( !empty( $color_id ) ) {
        $term = $color_id;
        $term_val = get_term( $term, 'pa_color', OBJECT );
        $message .= "<strong>Product Color:</strong> ". $term_val->name."<br/>";;
      }
    }
    $message .= "<h3>Wishlist</h3>";

    $message .= $wishlist.'<br/><br/>';

    $prod_wish_db = $wpdb->get_results( 'SELECT prod_id, wishlist_id from '.$wlist_prod.' where user_id = '.$current_user->ID, ARRAY_A );
    $prod_count = 1;
    if ( !empty( $prod_wish_db ) ) {

      $message .= '<table style="border: 1px solid rgba(0, 0, 0, 0.1); border-collapse: separate; border-radius: 5px; margin: 0 -1px 24px 0; text-align: left; width: 100%;">
      <thead>
        <tr>
          <th style="font-weight: 700; text-align:left; padding: 10px 10px; background: #eee;">
            <span class="nobr">Product Name</span>
          </th>
          <th style="font-weight: 700; text-align:left; padding: 10px 10px; background: #eee;">
            <span class="nobr">Stock Status</span>
          </th>
        </tr>
      </thead><tbody>';
      foreach ($prod_wish_db as $prod_wish_db_value) {
        if ( !empty( $prod_wish_db_value['prod_id'] ) ) {
          $stock_meta = get_post_meta( $prod_wish_db_value['prod_id'], '_stock_status', true);
          $stock_status = '';
          if ( $stock_meta == 'instock') {
            $stock_status = 'In Stock';
          } else {
            $stock_status = 'Out Of Stock';
          }
          $image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $prod_wish_db_value['prod_id'] ), 'shop_thumbnail' );

          $message .= '<tr style="border: 1px solid rgba(0,0,0,.1); border-radius: 5px;">
          <td style="border: 0px solid rgba(0,0,0,.1); padding: 10px;" >
            <a href="'.get_permalink($prod_wish_db_value['prod_id']).'">'.get_the_title($prod_wish_db_value['prod_id']).'</a>
          </td>
          <td style="border: 0px solid rgba(0,0,0,.1); padding: 10px;" >
            <span class="wishlist-in-stock">'.$stock_status.'</span>
          </td>
        </tr>';

        $prod_count++;
      }
    }
    $message .= '</tbody></table>';
  }

  $message .= "</body></html>";

  $mail_sent = wp_mail($mail_to, $subject, $message, $headers);

  echo json_encode($mail_sent);
  die();
}


require get_template_directory().'/book-forms.php';

add_action( 'wp_ajax_cpm_book_measures_quotes', 'cpm_book_measures_quotes');
add_action( 'wp_ajax_nopriv_cpm_book_measures_quotes', 'cpm_book_measures_quotes');
function cpm_book_measures_quotes() {

  if ( !empty( $_POST['ajax'] ) && $_POST['ajax'] == 1 ) {

    // $session_variable = $_SESSION['diagnostic_tour_product_filter'];

    $from_name = $_POST['your_name'];
    $from_email = $_POST['your_email'];
    $street_address = $_POST['street_address'];
    $cities_towns = $_POST['cities_towns'];
    $day_phone_number = $_POST['day_phone_number'];
    $interests = $_POST['interests'];
    $preferred_date = $_POST['preferred_date'];
    $your_message = $_POST['your_message'];
    $promo_code = $_POST['promo_code'];
    $mail_to = $_POST['nearest_store'];
    $product_name = $_POST['product_name'];
    $floor_life = $_POST['pa_floor'];
    $style_life = $_POST['pa_style'];
    $color_life = $_POST['selected_color'];
    $rent_life = $_POST['pa_rent'];
    $sell_life = $_POST['pa_sell'];
    $product_brand = $_POST['product_brand'];
    $product_cat = $_POST['product_cat'];
    $pa_rooms = $_POST['pa_rooms'];


    $blog_url = get_option('home');
    $explode_blog = explode( 'https://', $blog_url );
    $exploded = str_replace("/", "", $explode_blog[1]);

    $headers = "From: ".$from_email." <wordpress@".$exploded.">" . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $headers .= "Content-Transfer-Encoding: 7BIT";
    $subject = 'Book A Free Measure and Quote';
    $message = "<strong>From: ".$from_name."<br/>";
    $message .= "<strong>Email: ".$from_email."<br/>";
    if ( !empty( $product_name ) ) {
      $message .= "<strong>Product Name:</strong> ".$product_name."<br/>";
    }
    if ( !empty( $street_address ) ) {
      $message .= "<strong>Street Address:</strong> ".$street_address."<br/>";
    }
    if ( !empty( $cities_towns ) ) {
      $message .= "<strong>City/Town:</strong> ".$cities_towns."<br/>";
    }
    if ( !empty( $day_phone_number ) ) {
      $message .= "<strong>Day phone number:</strong> ".$day_phone_number."<br/>";
    }

    if ( !empty( $interests ) ) {
      $message .= "<strong>Interested in:</strong> <br/>";

      $message .= "<div style='padding-left:20px'>";
      foreach ($interests as $key => $interests_value) {
        $message .= ++$key.". ".$interests_value."<br/>";
      }
      $message .= "</div><br/>";
    }

    if ( !empty( $preferred_date ) ) {
      $message .= "<strong>Preferred date:</strong> ".$preferred_date."<br/>";
    }

    if ( !empty( $your_message ) ) {
      $message .= "<strong>Message Body:</strong> ".$your_message."<br/><br/>";
    }
    if ( !empty( $promo_code ) ) {
      $message .= "<strong>Promo code (if any):</strong> ".$promo_code."<br/><br/>";
    }

    if ( !empty( $floor_life ) || !empty( $style_life ) || !empty( $color_life ) || !empty( $rent_life ) || !empty( $sell_life ) ) {
     $message .= "<br/><strong>Filter Options</strong><br/><div style='padding-left:20px;'>";
     if ( !empty( $floor_life ) ) {
      $taxonomy_features = get_taxonomy('pa_floor');
      $message .= "<strong>".$taxonomy_features->label."</strong><br/><div style='padding-left:20px;'>";
      foreach ( $floor_life as $terms_key => $floor_life_value ) {
        $terms = get_term( $floor_life_value, 'pa_floor');
        $message .= ++$terms_key.". ". $terms->name."<br/>";
      }

      $message .= "</div>";
    }
    if ( !empty( $style_life ) ) {
      $taxonomy_features = get_taxonomy('pa_style');
      $message .= "<strong>".$taxonomy_features->label."</strong><br/><div style='padding-left:20px;'>";
      foreach ( $style_life as $terms_keys => $style_life_value ) {
        $terms = get_term( $style_life_value, 'pa_style');
        $message .= ++$terms_keys.". ". $terms->name."<br/>";
      }

      $message .= "</div>";
    }
    if ( !empty( $color_life ) ) {
      $taxonomy_features = get_taxonomy('product_color');
      $message .= "<strong>".$taxonomy_features->label."</strong><br/><div style='padding-left:20px;'>";
      foreach ( $color_life as $terms_keyss => $color_life_value ) {
        $terms = get_term( $color_life_value, 'product_color');
        $message .= ++$terms_keyss.". ". $terms->name."<br/>";
      }

      $message .= "</div>";
    }
    if ( !empty( $rent_life ) ) {
      $taxonomy_features = get_taxonomy('pa_rent');
      $message .= "<strong>Renting</strong><br/><div style='padding-left:20px;'>";
      foreach ( $rent_life as $terms_keysss => $rent_life_value ) {
        $terms = get_term( $rent_life_value, 'pa_rent');
        $message .= ++$terms_keysss.". ". $terms->name."<br/>";
      }

      $message .= "</div>";
    }
    if ( !empty( $sell_life ) ) {
      $taxonomy_features = get_taxonomy('pa_sell');
      $message .= "<strong>Selling</strong><br/><div style='padding-left:20px;'>";
      foreach ( $sell_life as $terms_keysss => $sell_life_value ) {
        $terms = get_term( $sell_life_value, 'pa_sell');
        $message .= ++$terms_keysss.". ". $terms->name."<br/>";
      }

      $message .= "</div>";
    }
    if ( !empty( $product_brand ) ) {
      $taxonomy_features = get_taxonomy('product_brand');
      $message .= "<strong>".$taxonomy_features->label."</strong><br/><div style='padding-left:20px;'>";
      foreach ( $product_brand as $tterms_keysss => $product_brand_value ) {
        $terms = get_term( $product_brand_value, 'product_brand');
        $message .= ++$tterms_keysss.". ". $terms->name."<br/>";
      }

      $message .= "</div>";
    }
    if ( !empty( $product_cat ) ) {
      $taxonomy_features = get_taxonomy('product_cat');
      $message .= "<strong>".$taxonomy_features->label."</strong><br/><div style='padding-left:20px;'>";
      foreach ( $product_cat as $tterms_keysss => $product_cat_value ) {
        $terms = get_term( $product_cat_value, 'product_cat');
        $message .= ++$tterms_keysss.". ". $terms->name."<br/>";
      }

      $message .= "</div>";
    }
    if ( !empty( $pa_rooms ) ) {
      $taxonomy_features = get_taxonomy('pa_rooms');
      $message .= "<strong>".$taxonomy_features->label."</strong><br/><div style='padding-left:20px;'>";
      foreach ( $pa_rooms as $key_term => $pa_rooms_value ) {
        $terms = get_term( $pa_rooms_value, 'pa_rooms');
        $message .= ++$key_term.". ". $terms->name."<br/>";
      }

      $message .= "</div>";
    }
    $message .= "</div>";
  }


  $mail_sent =  wp_mail( $mail_to, $subject, $message, $headers);

  echo json_encode($mail_sent);
}
die();
}

add_action( 'wp_ajax_cpm_add_color', 'cpm_add_color');
add_action( 'wp_ajax_nopriv_cpm_add_color', 'cpm_add_color');
function cpm_add_color() {

  $_SESSION['add_color_id'] = $_POST['color_id'];
  die();
}

add_action( 'wp_ajax_cpm_filter_troubleshoot', 'cpm_filter_troubleshoot');
add_action( 'wp_ajax_nopriv_cpm_filter_troubleshoot', 'cpm_filter_troubleshoot');
function cpm_filter_troubleshoot() {

  $args = array(
    'name'        => $_POST['postname'],
    'post_type'   => 'cc_troubleshooting',
    );


  $my_query = new WP_Query ( $args );

  if ( $my_query->have_posts() ) {
    while ( $my_query->have_posts() ) {
      $my_query->the_post();  ?>

      <main id="main" class="site-main" role="main">
        <h3><?php echo get_the_title(); ?></h3>

        <div class="popup-banner-image">
          <?php the_post_thumbnail(); ?>
        </div>

        <div class="cpm-content">
         <?php
         $post_date = get_the_date( 'F j, Y', get_the_ID() );
         echo $post_date;
         the_content(); ?>
       </div>
     </main>
     <?php
   }
   wp_reset_postdata();
 }
 ?>

 <?php

 die;
}


function cpm_comment_disable_comment_url($fields) {
  global $post;
  if ( $post->post_type == 'wpsl_stores') {

    unset($fields['url']);
  }
  return $fields;
}
add_filter('comment_form_default_fields','cpm_comment_disable_comment_url');

function wpb_move_comment_field_to_bottom( $fields ) {
  $comment_field = $fields['comment'];
  unset( $fields['comment'] );
  $fields['comment'] = $comment_field;
  return $fields;
}

add_filter( 'comment_form_fields', 'wpb_move_comment_field_to_bottom' );



add_filter( 'comment_form_defaults', 'cpm_comment_form_defaults');
function cpm_comment_form_defaults( $fields ) {

  $fields['fields']['author'] = '<p class="comment-form-author"><input id="author" name="author" type="text" value="" placeholder = "What is your name?" size="30" maxlength="245" aria-required="true" required="required"></p>';
  $fields['fields']['email'] = '<p class="comment-form-email"> <input id="email" name="email" type="email" value="" placeholder="What is your email? (not displayed)" size="30" maxlength="100" aria-describedby="email-notes" aria-required="true" required="required"></p>';
  return $fields;
}


function my_plugin_comment_template( $comment_template ) {
 global $post;
 global $wpdb;
 if ( ! is_singular() ) {
  return;
}
     if($post->post_type == 'wpsl_stores'){ // assuming there is a post type called business
      $comments_count = wp_count_comments($post->ID);


      $ratings = $wpdb->get_var( $wpdb->prepare("
        SELECT SUM(meta_value) FROM $wpdb->commentmeta
        LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
        WHERE meta_key = 'pixrating'
        AND comment_post_ID = %d
        AND comment_approved = '1'
        AND meta_value > 0
        ", $post->ID ) );
      $average = 0;

      if ( !empty( $ratings ) ) {

        $get_average = number_format( $ratings / $comments_count->all, 2, '.', '' );

        update_post_meta( $post->ID, 'pixrating_average', $get_average );

        $average = (string) floatval( $get_average );
      }

      ?>
      <div class="woocommerce-product-rating" itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating">
        <div class="star-rating" title="<?php printf( __( 'Rated %s out of 5', 'woocommerce' ), $average ); ?>">
          <span style="width:<?php echo ( ( $average / 5 ) * 100 ); ?>%">
            <strong itemprop="ratingValue" class="rating"><?php echo esc_html( $average ); ?></strong> <?php printf( __( 'out of %s5%s', 'woocommerce' ), '<span itemprop="bestRating">', '</span>' ); ?>
            <?php printf( _n( 'based on %s customer rating', 'based on %s customer ratings', $comments_count->all, 'woocommerce' ), '<span itemprop="ratingCount" class="rating">' . $comments_count->all . '</span>' ); ?>
          </span>
        </div>
        <?php if ( comments_open() ) : ?><a href="#reviews" class="woocommerce-review-link" rel="nofollow">(<?php printf( _n( '%s customer review', '%s customer reviews', $comments_count->all, 'woocommerce' ), '<span itemprop="reviewCount" class="count">' . $comments_count->all . '</span>' ); ?>)</a><?php endif ?>
      </div>
      <?php

    }
  }

  // add_filter( "comments_template", "my_plugin_comment_template" );

  function cpm_filter_plugin_updates( $value ) {
    unset( $value->response['comments-ratings/comments-ratings.php'] );
    return $value;
  }
  add_filter( 'site_transient_update_plugins', 'cpm_filter_plugin_updates' );

  function mytheme_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;

    if ( 'div' == $args['style'] ) {
      $tag = 'div';
      $add_below = 'comment';
    } else {
      $tag = 'li';
      $add_below = 'div-comment';
    }
    ?>
    <<?php echo $tag; ?> <?php comment_class( $comment->has_children ? 'parent' : '', $comment ); ?> id="comment-<?php comment_ID(); ?>">
    <?php if ( 'div' != $args['style'] ) : ?>
      <div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
      <?php endif; ?>
      <div class="comment-author vcard">
        <?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
        <?php printf( __( '<span class="cpm-fn">%s</span>' ), get_comment_author_link( $comment ) ); ?>
      </div>
      <?php if ( '0' == $comment->comment_approved ) : ?>
        <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ) ?></em>
        <br />
      <?php endif; ?>

      <div class="comment-meta commentmetadata">
        <div class="cpm-metabox">
          <a class="cpm-likes" href="#" id="cpm-like-<?php comment_ID(); ?>"><i class="fa fa-thumbs-up fa-2" aria-hidden="true"><?php
            $likes_meta = get_comment_meta( get_comment_ID(), 'likes_key', true );
            if ( !empty( $likes_meta ) ) {
              echo "(".$likes_meta.")";
            }
            ?></i>

          </a>
          <a class="cpm-likes" href="#" id="cpm-dislike-<?php comment_ID(); ?>"><i class="fa fa-thumbs-down fa-2" aria-hidden="true"><?php
            $dislikes_meta = get_comment_meta( get_comment_ID(), 'dislikes_key', true );
            if ( !empty( $dislikes_meta ) ) {
              echo "(".$dislikes_meta.")";
            }
            ?></i></a>

          </div>
          <a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
            <?php

            printf( __( '%1$s' ), get_comment_date( '', $comment ) ); ?></a><?php edit_comment_link( __( '(Edit)' ), '&nbsp;&nbsp;', '' );
            ?>
          </div>

          <?php comment_text( get_comment_id(), array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>

          <?php
          comment_reply_link( array_merge( $args, array(
            'add_below' => $add_below,
            'depth'     => $depth,
            'max_depth' => $args['max_depth'],
            'before'    => '<div class="reply">',
            'after'     => '</div>'
            ) ) );
            ?>

            <?php if ( 'div' != $args['style'] ) : ?>
            </div>
          <?php endif; ?>
          <?php

        }


        add_action( 'wp_ajax_cpm_comment_likes', 'cpm_comment_likes');
        add_action( 'wp_ajax_nopriv_cpm_comment_likes', 'cpm_comment_likes');
        function cpm_comment_likes() {

          $saved_meta_val = '';
          if ( $_POST['cmt_action'] == 'cpm-like' ) {
            $likes_meta_values = get_comment_meta( $_POST['comment_ID'], 'likes_key', true );
            if ( !empty( $likes_meta_values ) ) {
              $saved_meta_val = $likes_meta_values + 1;
            } else {
              $saved_meta_val = 1;
            }
            update_comment_meta( $_POST['comment_ID'], 'likes_key', $saved_meta_val );

          } elseif ( $_POST['cmt_action'] == 'cpm-dislike' ) {
            $dislikes_meta_values = get_comment_meta( $_POST['comment_ID'], 'dislikes_key', true );
            if ( !empty( $dislikes_meta_values ) ) {
              $saved_meta_val = $dislikes_meta_values + 1;
            } else {
              $saved_meta_val = 1;
            }
            update_comment_meta( $_POST['comment_ID'], 'dislikes_key', $saved_meta_val );
          }
          echo json_encode(array( 'key'=> $_POST['cmt_action'], 'value' => $saved_meta_val ) );
          die();
        }

        require('inc/customizer.php');
        require('functions-vis.php');


        add_action( 'wp_ajax_cpm_add_to_wishlist', 'cpm_add_to_wishlist');
        add_action( 'wp_ajax_nopriv_cpm_add_to_wishlist', 'cpm_add_to_wishlist');
        function cpm_add_to_wishlist() {

          $user_id = get_current_user_id();
          $new_wishlist = new YITH_WCWL();
          $new_wishlist->details['add_to_wishlist'] = $_POST['add_to_wishlist'];
          $new_wishlist->details['wishlist_id'] = $_POST['wishlist_id'];
          $new_wishlist->details['user_id'] = $user_id;

          $return = $new_wishlist->add();
          $wishlists = $new_wishlist->get_wishlists( array( 'user_id' => $user_id ) );
          if( $return == 'true' ){
            $message = apply_filters( 'yith_wcwl_product_added_to_wishlist_message', get_option( 'yith_wcwl_product_added_text' ) );
          }
          elseif( $return == 'exists' ){
            $message = apply_filters( 'yith_wcwl_product_already_in_wishlist_message', get_option( 'yith_wcwl_already_in_wishlist_text' ) );
          }
          elseif( count( $new_wishlist->errors ) > 0 ){
            $message = apply_filters( 'yith_wcwl_error_adding_to_wishlist_message', $new_wishlist->get_errors() );
          }

          wp_send_json(
            array(
              'result' => $return,
              'message' => $message,
              'user_wishlists' => $wishlists,
              'wishlist_url' => $new_wishlist->get_wishlist_url( 'view' . ( isset( $new_wishlist->last_operation_token ) ? ( '/' . $new_wishlist->last_operation_token ) : false ) ),
              )
            );
          die();
        }

        add_action( 'woocommerce_save_account_details', 'my_woocommerce_save_account_details' );
        function my_woocommerce_save_account_details( $user_id ) {


          update_user_meta( $user_id, 'billing_address_1', $_POST['account_address_1'] );
          update_user_meta( $user_id, 'billing_address_2', $_POST['account_address_2'] );
          update_user_meta( $user_id, 'billing_city', $_POST['account_city'] );
          update_user_meta( $user_id, 'billing_postcode', $_POST['account_billing_postcode'] );
          update_user_meta( $user_id, 'billing_phone', $_POST['account_tel'] );
          update_user_meta( $user_id, 'billing_country', $_POST['account_country'] );

        }

        add_action( 'admin_head', 'add_cpm_field_width');
        function add_cpm_field_width() {
          ?>
          <style type="text/css">
            td.field_type-text {
              width: 100%;
            }
          </style>

          <?php
        }


        function cpm_get_product_ratings( $prod_id ) {

          $average_rating      = get_post_meta( $prod_id, '_wc_average_rating', true );
          $review_count = get_post_meta( $prod_id, '_wc_review_count', true );
          $rating_count = get_post_meta( $prod_id, '_wc_rating_count', true );

          $average = 0;
          if ( !empty( $average_rating ) ) {
            $average = $average_rating;

          }

          $reviews = 0;
          if ( !empty( $review_count ) ) {
            $reviews = $review_count;
          }

          $args = array(
           'rating' => $average,
           'type' => 'rating',
           'number' => $reviews,
           'echo' => false
           );
          // require_once( ABSPATH . 'wp-admin/includes/template.php' );
          echo cpm_wp_star_rating( $args );

        }

        function cpm_wp_star_rating( $args = array() ) {
          $defaults = array(
            'rating' => 0,
            'type'   => 'rating',
            'number' => 0,
            'echo'   => true,
            );
          $r = wp_parse_args( $args, $defaults );

  // Non-english decimal places when the $rating is coming from a string
          $rating = str_replace( ',', '.', $r['rating'] );

  // Convert Percentage to star rating, 0..5 in .5 increments
          if ( 'percent' == $r['type'] ) {
            $rating = round( $rating / 10, 0 ) / 2;
          }

  // Calculate the number of each type of star needed
          $full_stars = floor( $rating );
          $half_stars = ceil( $rating - $full_stars );
          $empty_stars = 5 - $full_stars - $half_stars;

          if ( $r['number'] ) {
            /* translators: 1: The rating, 2: The number of ratings */
            $format = _n( '%1$s rating based on %2$s rating', '%1$s rating based on %2$s ratings', $r['number'] );
            $title = sprintf( $format, number_format_i18n( $rating, 1 ), number_format_i18n( $r['number'] ) );
          } else {
            /* translators: 1: The rating */
            $title = sprintf( __( '%s rating' ), number_format_i18n( $rating, 1 ) );
          }

          $output = '<div class="star-rating">';
          $output .= '<span class="screen-reader-text">' . $title . '</span>';
          $output .= str_repeat( '<div class="fa fa-star"></div>', $full_stars );
          $output .= str_repeat( '<div class="fa fa-star-half-o"></div>', $half_stars );
          $output .= str_repeat( '<div class="fa fa-star-o"></div>', $empty_stars );
          $output .= '</div>';

          if ( $r['echo'] ) {
            echo $output;
          }

          return $output;
        }


        add_filter('woocommerce_login_redirect', 'cpm_login_redirect');
        function cpm_login_redirect( $redirect_to ) {
         $redirect_to = home_url('/wishlist/view/');
         return $redirect_to;
       }


       add_action( 'wp_ajax_top_term_stains', 'top_term_stains');
       add_action( 'wp_ajax_nopriv_top_term_stains', 'top_term_stains');
       function top_term_stains() {


        $query_args = array();
        $tax_query = array();

        $query_args['post_type'] = 'stain_removal';
        $query_args['post_status'] = 'publish';
        $query_args['posts_per_page'] = 1;

        if( isset( $_POST['stain_id'] ) && $_POST['stain_id'] !='' ){
        // $cat_query = arr
          $value =  $_POST['stain_id'];
          $tax_query[]  = array(
            'taxonomy' => 'top_five_taxonomy',
            'field'    => 'term_id',
            'terms'    =>  $value ,
            );
        }
        if( isset( $_POST['fibre_id'] ) && $_POST['fibre_id'] !='' ){
          $fibre_value =  $_POST['fibre_id'];
          $tax_query[]  = array(
            'taxonomy' => 'fibre_taxonomy',
            'field'    => 'term_id',
            'terms'    =>  $fibre_value ,
            );
        }

        if( !empty( $tax_query ) ) {

          if ( count( $tax_query ) > 0 ) {
            $tax_query['relation']  = 'AND';
          }
          $query_args['tax_query'] = $tax_query;
        }

        $stain_removal_query = new WP_Query( $query_args );
        if ( $stain_removal_query->have_posts() ) {
          while ( $stain_removal_query->have_posts() ) {
            $stain_removal_query->the_post(); ?>
            <div class="col-md-6 feat-img-col">

              <?php the_post_thumbnail(); ?>
            </div>

            <div class="col-md-6 steps-col">
              <div class="cpm-st-rm">
              <?php the_content(); ?>

              </div>

            </div>
            <?php
          } wp_reset_postdata();
        } else {
          echo "Nothing Found";
        }
        die();
      }

// function to find the store status as closed or open
      function cpm_get_store_status( $store_id ){
        $current_day = strtolower( date( 'l',current_time('timestamp') ) );
        $cur_time_str = date ( 'g:i A' , current_time( 'timestamp' ) );
        $cur_time = strtotime( $cur_time_str );
        $store_time = get_post_meta( $store_id, 'wpsl_hours' );

        if( !empty($store_time) )
          $store_day = $store_time[0][$current_day];
        if( !empty($store_day) ){
         $exploded_time = explode(',', $store_day[0]);
         $start_time = strtotime($exploded_time[0]);
         $end_time = strtotime($exploded_time[1]);
$current_status = "Closed";

         if( ($cur_time >= $start_time) && ( $cur_time <= $end_time ) ){
           $current_status = "Open Now";
         }
       } else {
$current_status = "Closed";

       }
       return $current_status;
     }


     if ( ! function_exists( 'woocommerce_breadcrumb' ) ) {

  /**
   * Output the WooCommerce Breadcrumb
   */
  function woocommerce_breadcrumb( $args = array() ) {
    $args = wp_parse_args( $args, apply_filters( 'woocommerce_breadcrumb_defaults', array(
      'delimiter'   => '<li class="separator">/</li>',
      'wrap_before' => '<nav class="woocommerce-breadcrumb" ' . ( is_single() ? 'itemprop="breadcrumb"' : '' ) . '><ul class="cpm-breadcrumb">',
      'wrap_after'  => '</ul></nav>',
      'before'      => '<li>',
      'after'       => '</li>',
      'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' )
      ) ) );

    $breadcrumbs = new WC_Breadcrumb();

    if ( $args['home'] ) {
      $breadcrumbs->add_crumb( $args['home'], apply_filters( 'woocommerce_breadcrumb_home_url', home_url() ) );
    }

    $args['breadcrumb'] = $breadcrumbs->generate();

    wc_get_template( 'global/breadcrumb.php', $args );
  }
}


add_filter( 'register_taxonomy_args', 'cc_register_taxonomy_args', 10, 3);
function cc_register_taxonomy_args( $args, $taxonomy, $object_type ) {

  if ( $taxonomy == 'product_color' ) {
    $args['labels']['name'] = 'Colour Palettes';
  }
  if ( $taxonomy == 'product_feature' ) {
    $args['labels']['name'] = 'Features';
  }
  return $args;
}

function cc_cpm_image_lists( $step ) {

  $step_image = get_theme_mod( 'cpm_cc_'.$step.'_image');

  $step_description = get_theme_mod( 'cpm_cc_'.$step.'_textarea' );

  if ( !empty( $step_image ) ) {
    $image = $step_image;
  } else {
    $image = wc_placeholder_img_src();
  }

  $title = '';
  if ( $step == 'rent' ) {
    $title = 'For my rental property';
  } elseif ( $step == 'sell' ) {
    $title = 'I’m selling and want to add value';
  } elseif ( $step == 'keep' ) {
    $title = 'I’m doing up/ building my place';
  }
  ?>

  <li class="col-md-4 col-sm-4 col-xs-6 wow fadeInUp">
    <div class="grid-item-content">
      <div class="fig-wrap">
        <a href="<?php echo get_permalink( get_page_by_path( 'flooring-finder/'.$step ) ); ?>" class="diagnostic_filter_tax" id="term_<?php echo $step; ?>">

          <figure class="fig-hover">
            <img src="<?php echo esc_url($image) ?>" alt="<?php echo esc_attr__( 'Thumbnail', 'cc_product_filter' )?>" width="340" height="260" class="wp-post-image" >
            <div class="cpm-block-title">
              <div class="c-table">
                <span class="t-cell">
                  <h3 class="title"><?php echo $title; ?></h3>
                </span>

              </div>
            </div>
          </figure>

          <figcaption class="hover-title fig-hover-one">
            <div class="fig-title" >
              <div class="vert-middle">
                <div class="div">
                  <!-- <h3 class="title"><?php //echo $title; ?></h3> -->
                  <p><?php echo ( !empty( $step_description ) ) ? $step_description : ''; ?></p>
                  <div class="select"><span class="glyphicon glyphicon-ok invisible"></span> CHOOSE THIS</div>
                </div>
              </div>
            </div>
          </figcaption>
        </a>
      </div>
    </div>
  </li>

  <?php
}


add_shortcode( 'cc_rhino_button', 'cc_rhino_to_filter' );
function cc_rhino_to_filter( $atts ) {
  ob_start();
  ?>

    <?php
    ?>
  <form id="cc-cat-form-rhino" style="text-align: center;" action="<?php echo esc_url( home_url() ); ?>/product-filter/" method="POST" >

    <!-- <input name="product_cat[]" value="21" type="hidden"> -->
    <input name="product_material" value="rhino_carpet" type="hidden">
  </form>
    <a href="javascript:void(0)" onclick="document.getElementById('cc-cat-form-rhino').submit(); return false;" class="vc_general vc_btn3 vc_btn3-size-lg vc_btn3-shape-square vc_btn3-style-custom" style="background-color:#ef404f; color:#ffffff;">
      View our Rhino Carpet
    </a>
  <?php

  $return_content = ob_get_clean();
  // ob_flush();
  return $return_content;
}


/*Create table for image wishlists likes*/
add_action( 'init', 'create_image_likes_table' );
function create_image_likes_table() {

  global $wpdb;
  $sql_slider_params = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "wishlists_image`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(50) ,
  `media_id` int(150) ,
  `media_url_small` varchar(200) CHARACTER SET utf8 NOT NULL,
  `media_url_large` varchar(200) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`) ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=89 ";
  $wpdb->query($sql_slider_params);
}

add_action( 'wp_ajax_add_img_wishlists', 'cpm_add_img_wishlists' );
function cpm_add_img_wishlists() {

  global $wpdb;
  $user_id = $_POST['user_id'];
  $media_id = $_POST['media_id'];
  $large_img = $_POST['large_img'];
  $small_img = $_POST['small_img'];
  $table_name = $wpdb->prefix . "wishlists_image";

  $insert = 0;
  if ( $user_id != 0 ) {
    $insert = $wpdb->insert(
      $table_name,
      array(
        'user_id' => $user_id,
        'media_id' => $media_id,
        'media_url_small' => $small_img,
        'media_url_large' => $large_img,
        ),
      array(
        '%d',
        '%d',
        '%s',
        '%s',
        )
      );
  }
  echo $insert;
  die();
}

add_action( 'wp_ajax_remove_img_wishlists', 'cpm_remove_img_wishlists' );
function cpm_remove_img_wishlists() {

  global $wpdb;
  $table_name = $wpdb->prefix . "wishlists_image";
  $row_id = $_POST['rowid'];

  $response = $wpdb->delete( $table_name, array( 'id' => $row_id ), array( '%d' ) );

  echo $response;
  die();
}

add_filter( 'woocommerce_save_account_details_required_fields', 'cc_change_required_fields', 10);
function cc_change_required_fields( $fields ) {

  unset($fields['account_first_name']);
  unset($fields['account_last_name']);
  return $fields;
}


function get_store_rating( $post_id ) {
  global $wpdb;
  $comments_count = wp_count_comments($post_id);
  $ratings = $wpdb->get_var( $wpdb->prepare("
    SELECT SUM(meta_value) FROM $wpdb->commentmeta
    LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
    WHERE meta_key = 'pixrating'
    AND comment_post_ID = %d
    AND comment_approved = '1'
    AND meta_value > 0
    ", $post_id ) );
  $average = 0;

  if ( !empty( $ratings ) ) {

    $get_average = number_format( $ratings / $comments_count->all, 2, '.', '' );

    update_post_meta( $post_id, 'pixrating_average', $get_average );

    $average = (string) round( $get_average );
  }
  $args = array(
   'rating' => $average,
   'type' => 'rating',
   'number' => $comments_count,
   'echo' => false
   );
  require_once( ABSPATH . 'wp-admin/includes/template.php' );
  return wp_star_rating( $args );

}


function cc_get_store_status( $store_id ){
  $current_day = strtolower( date( 'l',current_time('timestamp') ) );
  $cur_time_str = date ( 'g:i A' , current_time( 'timestamp' ) );
  $cur_time = strtotime( $cur_time_str );
  $store_time = get_post_meta( $store_id, 'wpsl_hours' );
  if( !empty($store_time) )
    $store_day = $store_time[0][$current_day];
  if( !empty($store_day) ){
    $exploded_time = explode(',', $store_day[0]);
    $start_time = strtotime($exploded_time[0]);
    $end_time = strtotime($exploded_time[1]);
    $current_status = "Closed";
    if( ($cur_time >= $start_time) && ( $cur_time <= $end_time ) ){
      $current_status = "Open Now";
    }
  } else {
    $current_status = "Closed";
  }
  return $current_status;
}

add_filter( 'wpsl_store_meta', 'cpm_star_rating_meta', 10, 2 );
function cpm_star_rating_meta(  $store_meta, $store_id ) {

  $store_meta['avg_rating'] = get_store_rating( $store_id );
  $store_meta['store_status'] = cc_get_store_status( $store_id );

  return $store_meta;

}

add_filter( 'wpsl_frontend_meta_fields', 'cpm_wpsl_frontend_meta_fields', 10 );
function cpm_wpsl_frontend_meta_fields( $store_fields ) {

  $store_fields['wpsl_avg_rating'] =array(
    'name' => 'avg_rating'
    );
  return $store_fields;
}



add_filter( 'wpsl_store_header_template', 'change_store_template', 10 );
function change_store_template( $header_template ) {

  global $wpsl_settings;

  if ( $wpsl_settings['new_window'] ) {
    $new_window = ' target="_blank"';
  } else {
    $new_window = '';
  }

  $header_template = '<strong><a' . $new_window . ' href="<%= permalink %>"><%= store %></a></strong><a class="cpm-view-store" href="<%= permalink %>"><i class="fa fa-search" aria-hidden="true"></i>View Profile</a><br/>';
  $header_template .= '<% if ( typeof avg_rating !== "undefined" ) { %>' . "\r\n";
  $header_template .= '<%= avg_rating %>';
  $header_template .= '<% } %>';
  return $header_template;
}

add_filter( 'wpsl_listing_template', 'cpm_cc_wpsl_listing_template', 10 );
function cpm_cc_wpsl_listing_template( $listing_template ) {
  global $wpsl_settings;
  // echo "<pre>";
  // print_r($listing_template);
  // echo "</pre>";
  $listing_template = '<li data-store-id="<%= id %>">' . "\r\n";
  $listing_template .= "\t\t" . '<div class="wpsl-store-location">' . "\r\n";
  $listing_template .= "\t\t\t" . '<p class="clearfix"><%= thumb %>' . "\r\n";
  $listing_template .= "\t\t\t" . "<div class='map-description'>";
  $listing_template .= "\t\t\t\t" . wpsl_store_header_template( 'listing' ) . "\r\n"; // Check which header format we use
  $listing_template .= "\t\t\t\t" . '<span class="wpsl-street"><%= address %></span>' . "\r\n";
  $listing_template .= "\t\t\t\t" . '<% if ( address2 ) { %>' . "\r\n";
  $listing_template .= "\t\t\t\t" . '<span class="wpsl-street"><%= address2 %></span>' . "\r\n";
  $listing_template .= "\t\t\t\t" . '<% } %>' . "\r\n";
  $listing_template .= "\t\t\t\t" . '<span>' . wpsl_address_format_placeholders() . '</span>' . "\r\n"; // Use the correct address format
  $listing_template .= "\t\t\t\t" . '<span class="wpsl-country"><%= country %></span>' . "\r\n";
  $listing_template .= "\t\t\t\t" . '<span class="cc-store-status"><% if ( typeof store_status !== "undefined" ) { %>' . "\r\n";
  $listing_template .= '<i class="fa fa-lightbulb-o"></i> <%= store_status %>'. "\r\n";
  $listing_template .= '<% } %></span>'. "\r\n";
  $listing_template .= "\t\t" . '</div>' . "\r\n";
  $listing_template .= "\t\t\t" . '</p>' . "\r\n";
  $listing_template .= "\t\t\t" . wpsl_more_info_template() . "\r\n"; // Check if we need to show the 'More Info' link and info
  $listing_template .= "\t\t" . '</div>' . "\r\n";
  $listing_template .= "\t\t" . '<div class="wpsl-direction-wrap">' . "\r\n";

  if ( !$wpsl_settings['hide_distance'] ) {
    $listing_template .= "\t\t\t" . '<%= distance %> ' . esc_html( $wpsl_settings['distance_unit'] ) . '' . "\r\n";
  }

  $listing_template .= "\t\t\t" . '<%= createDirectionUrl() %>' . "\r\n";
  $listing_template .= "\t\t" . '</div>' . "\r\n";
  $listing_template .= "\t" . '</li>';
  $listing_template .= "\n";

  return $listing_template;
}

add_filter( 'wpsl_marker_props', 'cc_cpm_wpsl_admin_marker_dir', 999 );
function cc_cpm_wpsl_admin_marker_dir( $marker_props ){
  $marker_props = array(
        'scaledSize' => '35,44', // 50% of the normal image to make it work on retina screens.
        'origin'     => '0,0',
        'anchor'     => '12,35'
        );
  return $marker_props;
}


add_filter( 'wpsl_thumb_size', 'cc_wpsl_thumb_size', 10 );
function cc_wpsl_thumb_size( $size ) {

  $size = array( 340, 260);

  return $size;
}

add_shortcode( 'special_button_filter', 'cc_special_button' );
function cc_special_button($atts=array()){
  ob_start();
  ?>
  <form id="cc-cat-form-specials" action="<?php echo esc_url( home_url() ); ?>/products/product-filter/" method="POST" >

        <?php $term = get_term_by( 'name', 'Specials', 'product_tag', OBJECT );  ?>
        <input name="product_tag[]" value="<?php echo $term->term_id; ?>" type="hidden">
        <a href="javascript:void(0)" onclick="document.getElementById('cc-cat-form-specials').submit(); return false;" class="cc-cpm-btn btn btn-primary btn-lg">
            Specials
        </a>
    </form>
  <?php
  return ob_get_clean();
}

//mailchimp shbscribe for pdf documents
include 'MailChimp.php';

add_action( 'wp_ajax_cpm_mailchimp_subscribe', 'cpm_mailchimp_subscribe' );
add_action( 'wp_ajax_nopriv_cpm_mailchimp_subscribe', 'cpm_mailchimp_subscribe' );
function cpm_mailchimp_subscribe() {

  $mailchimp_api_key = get_theme_mod('cpm_mailchimp_api_key');
  $mailchimp_list_id = get_theme_mod('cpm_mailchimp_list_id');
  $email = $_POST['user_email'];
  $doc_id = $_POST['doc_id'];

  $mmailChimp = new \DrewM\MailChimp\MailChimp($mailchimp_api_key);

  $mailchimp_status = 'subscribed';


  $result = $mmailChimp->post( "lists/".$mailchimp_list_id."/members",
    [
    'email_address' => $email,
    'status'        => $mailchimp_status,
    // 'merge_fields'      => array('FNAME'=>'Davy', 'LNAME'=>'Jones'),
    'interests'         => array( '7d241526cb' => true ),
    'GROUPINGS'=> array(
      array(
        'name' => 'Website downloads',
        'groups' => 'Website subscribers'
        )
      )

    ]);


  $success = array();

  $aerr = $mmailChimp->getLastError();;
  if ( $mmailChimp->success() ) {

    $idoc_url = wp_get_attachment_url( $doc_id );

    $success = array('status' => true, 'url' => esc_url( $idoc_url ), 'message' => 'Thanks for subscribing, your download will automatically start now.', 'res' => $result['status'], 'err' => $aerr );
  }
  elseif ( $result['status'] == 400 ) {
      // $message = $mmailChimp->getLastError();
    $idoc_url = wp_get_attachment_url( $doc_id );
    $success = array('status' => true, 'url' => esc_url( $idoc_url ), 'message' => 'Thanks for subscribing, your download will automatically start now.', 'res' => $result['status'], 'err' => $aerr );
  } else {
    $success = array('status' => false, 'url' => esc_url( $idoc_url ), 'message' => 'Something went wrong !!! Please Try Again.', 'res' => $result['status'] );
  }

  echo json_encode( $success );
  die();
}

add_action( 'wp_ajax_cpm_mailchimp_list_subscribe', 'cpm_mailchimp_list_subscribe' );
add_action( 'wp_ajax_nopriv_cpm_mailchimp_list_subscribe', 'cpm_mailchimp_list_subscribe' );
function cpm_mailchimp_list_subscribe() {

  $mailchimp_api_key = get_theme_mod('cpm_mailchimp_api_key');
  $email = $_POST['user_email'];
  $list_id = $_POST['list_id'];

  $mmailChimp = new \DrewM\MailChimp\MailChimp($mailchimp_api_key);

  $mailchimp_status = 'subscribed';
  $result = $mmailChimp->post( "lists/".$list_id."/members",
    [
    'email_address' => $email,
    'status'        => $mailchimp_status,

    ]);


  $success = array();

  $aerr = $mmailChimp->getLastError();;
  if ( $mmailChimp->success() ) {

    // $idoc_url = wp_get_attachment_url( $doc_id );

    $success = array('status' => true, 'message' => 'Thank you for subscribe.', 'res' => $result['status'], 'err' => $aerr );
  }
  elseif ( $result['status'] == 400 ) {
      // $message = $mmailChimp->getLastError();
    $idoc_url = wp_get_attachment_url( $doc_id );
    $success = array('status' => true, 'message' => 'Thank you for subscribe.', 'res' => $result['status'], 'err' => $aerr );
  } else {
    $success = array('status' => false, 'message' => 'Something went wrong !!! Please Try Again.', 'res' => $result['status'] );
  }

  echo json_encode( $success );
  die();
}


function return_mailchimp_lists() {

  $mailchimp_api_key = get_theme_mod('cpm_mailchimp_api_key');
  $mailchimp_list_id = get_theme_mod('cpm_mailchimp_list_id');

  $mmailChimp = new \DrewM\MailChimp\MailChimp($mailchimp_api_key);

  $mailchimp_status = 'subscribed';
  $result = $mmailChimp->get( "lists/",[
    'count'=>100
    ]);
  $return_result = array();
  if ( !empty( $result ) ) {

    foreach ($result as $result_value) {
      if ( is_array( $result_value ) ) {

        foreach ($result_value as $value_results) {

          if ( !empty( $value_results['id'] ) && !empty( $value_results['name'] )) {

            $return_result[$value_results['id']] = $value_results['name'];
          }
        }
      }
    }
  }
  return $return_result;
}


add_action( 'gform_after_submission', 'cc_after_submission', 10, 2 );
function cc_after_submission( $entry, $form ) {


  if ( $entry['form_id'] == 1 ) {

  $mailchimp_api_key = get_theme_mod('cpm_mailchimp_api_key');
  $mailchimp_list_id = get_theme_mod('cpm_mailchimp_list_id');

  $mmailChimp = new \DrewM\MailChimp\MailChimp($mailchimp_api_key);

  $mailchimp_status = 'subscribed';
 // [10914c7e88] =>
 //            [7d241526cb] =>

  $result = $mmailChimp->post( "lists/".$mailchimp_list_id."/members",
    [
    'email_address' => $entry[3],
    'status'        => $mailchimp_status,
    'merge_fields'      => array('FNAME'=>$entry[2], 'LNAME'=>''),
    'interests'         => array( '10914c7e88' => true ),
    'GROUPINGS'=> array(
      array(
        'name' => 'Contact forms',
        'groups' => 'Website subscribers'
        )
      )

    ]);
}
}


function save_product_type_meta( $post_id, $post, $update ) {

  if ( $post->post_type == 'product' ) {
    $term_id_array = array();

    if ( isset( $_POST['attribute_names'] ) && !empty( $_POST['attribute_names'] ) ) {
      foreach ($_POST['attribute_names'] as $keyy => $find_attr) {
        if ( $find_attr == 'pa_color') {
          // continue;
          $pa_color_terms = $_POST['attribute_values'][$keyy];
          if ( !empty( $pa_color_terms ) ) {

            foreach ($pa_color_terms as $pa_color_value) {
              $get_terms_val = get_term_by( 'slug', $pa_color_value, 'pa_color', ARRAY_A );
              if ( !empty( $get_terms_val ) ) {
                if ( !in_array( $get_terms_val['term_id'], $term_id_array ) ) {
                  array_push( $term_id_array, $get_terms_val['term_id'] );
                }
              }
            }
          }
        }
      }
    }

    $taxonomy_array = array( 'pa_fibre','pa_material', 'pa_rooms', 'pa_quality', 'pa_looks', 'pa_floor', 'pa_color', 'pa_style', 'pa_rent', 'pa_sell', 'pa_filter-colour' );
    // $taxonomy_array = array('pa_floor', 'pa_color', 'pa_style', 'pa_rent', 'pa_sell', 'pa_filter-colour' );

    if ( !empty( $term_id_array ) ) {

      foreach ($term_id_array as $term_value) {
        $term_metas = get_term_meta( $term_value, 'pa_color_rel_lifes', true );
        foreach ($term_metas as $meta_key => $term_meta_value) {

          if ( $meta_key == 'product_accents') {
            wp_set_post_terms( $post_id, $term_meta_value, 'product_color', true );
          } else {
            wp_set_post_terms( $post_id, $term_meta_value, $meta_key, true );
          }
        }
      }

      $attributes = get_post_meta( $post_id, '_product_attributes', true );

      foreach ($taxonomy_array as $taxonomy_value) {

        if ( !empty( $attributes ) ) {
          if ( !array_key_exists( $taxonomy_value, $attributes ) ) {
            // $attributess[$taxonomy_value] = array(
            //   'name' => $taxonomy_value,
            //   'value' => '',
            //   'position' => 0,
            //   'is_visible' => 1,
            //   'is_variation' => 0,
            //   'is_taxonomy' => 1,
            //   );
            // update_post_meta( $post_id, '_product_attributes', $attributess );
          }
          else {
            $attributess[$taxonomy_value] = array(
              'name' => $taxonomy_value,
              'value' => '',
              'position' => 0,
              'is_visible' => 1,
              'is_variation' => 0,
              'is_taxonomy' => 1,
              );
            update_post_meta( $post_id, '_product_attributes', $attributess );
          }
        } else {
          $default_attributes = array('pa_floor', 'pa_color', 'pa_style', 'pa_rent', 'pa_sell', 'pa_filter-colour' );
          if(in_array($taxonomy_value, $default_attributes))
          {
            $attributess[$taxonomy_value] = array(
              'name' => $taxonomy_value,
              'value' => '',
              'position' => 0,
              'is_visible' => 1,
              'is_variation' => 0,
              'is_taxonomy' => 1,
              );
            update_post_meta( $post_id, '_product_attributes', $attributess );

          }
          }
      }
    }
      // die("hello");
  }

}
add_action( 'save_post', 'save_product_type_meta', 10, 3 );


function cc_strip_excerpt( $post_content, $post_id, $limit = 20, $words = true ) {

  $except_initial = strip_tags( $post_content );

  if ( $words ) {
    $excerpt = explode( ' ', $except_initial, $limit );
    if ( count( $excerpt ) >= $limit ) {
      array_pop( $excerpt );
      $excerpt = implode( " ", $excerpt ) . '... <a href="'.esc_url( get_permalink($post_id) ).'" rel="bookmark" class="view-more">View More</a>';
    } else {
      $excerpt = implode( " ", $excerpt ) . '';
    }
    /** TODO */
    $excerpt = preg_replace( '`\[[^\]]*\]`', '', $excerpt );
    return '<p>' . $excerpt . '</p>';
  } else {
    $excerpt = $except_initial;
    return '<p>'. substr( $excerpt, 0, $limit ) . ( strlen( $excerpt ) > $limit ? '...' : '' ) . '</p>';
  }
}


add_action( 'pre_get_posts', 'pre_query_search_filter' );
function pre_query_search_filter( $query ) {

  if ( ! is_admin() && $query->is_main_query() && $query->is_search() ) {
    if ( isset( $_GET['posts_type'] ) ) {
      $query->set('post_type', $_GET['posts_type']);
    }
  }
}

// add_filter( 'get_search_query', 'cc_get_search_query', 10 );
// function cc_get_search_query( $query ) {
//   $query = get_query_var( 'search' );
//   return $query;
// }

function get_my_tax_name($taxname){
  $pa_terms = get_terms( $taxname, array(
      'hide_empty' => false,
      'fields' => 'id=>slug',
      )
  );
  $values = array_values($pa_terms);
  return $values;
}

// function cc_existing_tax_name($taxname){
//     $pa_terms = get_terms( $taxname, array(
//         'hide_empty' => false,
//         'fields' => 'names',
//         )
//     );
//     return $pa_terms;
//   }

add_action( 'gform_pre_submission', 'cpm_product_quote_pre_submission_handler' );
function cpm_product_quote_pre_submission_handler( $form ) {
  global $post;
  if('product' == $post->post_type)
  {
    $_POST['input_16'] = $post->post_title ." ( ". get_permalink($post->ID) ." )";
  }
  if(isset($_GET['product_cat'])){
    $product_cat_name = '';
    // $product_cat_name = get_cat_name( $cat_id )
    $filter_cats = get_terms(array(
        'hide_empty' => false,
        'taxonomy' => 'product_cat',
        'include' => $_GET['product_cat'],
      ));
    if($filter_cats)
    {
      foreach ($filter_cats as $single_cats) {
        $product_cat_name .= $single_cats->name.', ';
      }
    $_POST['input_12'] = rtrim($product_cat_name, ', ');
    }
  }

  if(isset($_GET['pa_floor'])){
    $product_floors_name = '';
    // $product_cat_name = get_cat_name( $cat_id )
    $filter_floors = get_terms(array(
        'hide_empty' => false,
        'taxonomy' => 'pa_floor',
        'include' => $_GET['pa_floor'],
      ));
    if($filter_floors)
    {
      foreach ($filter_floors as $single_filter_floors) {
        $product_floors_name .= $single_filter_floors->name.', ';
      }
    $_POST['input_13'] = rtrim($product_floors_name, ', ');
    }
  }

  if(isset($_GET['pa_filter-colour'])){
    $product_filter_colour_name = '';
    // $product_cat_name = get_cat_name( $cat_id )
    $filter_colours = get_terms(array(
        'hide_empty' => false,
        'taxonomy' => 'pa_filter-colour',
        'include' => $_GET['pa_filter-colour'],
      ));
    if($filter_colours)
    {
      foreach ($filter_colours as $single_filter_colours) {
        $product_filter_colour_name .= $single_filter_colours->name.', ';
      }
    $_POST['input_14'] = rtrim($product_filter_colour_name, ', ');
    }
  }

  if(isset($_GET['product_feature'])){
    $product_filter_feature_name = '';
    // $product_cat_name = get_cat_name( $cat_id )
    $filter_features = get_terms(array(
        'hide_empty' => false,
        'taxonomy' => 'product_feature',
        'include' => $_GET['product_feature'],
      ));
    if($filter_features)
    {
      foreach ($filter_features as $single_filter_features) {
        $product_filter_feature_name .= $single_filter_features->name.', ';
      }
    $_POST['input_15'] = rtrim($product_filter_feature_name, ', ');
    }
  }

}

function add_atom_data($content) {
 $t = get_the_modified_time('F jS, Y');
 $author = get_the_author();
 $title = get_the_title();
if (is_home() || is_singular() || is_archive() ) {
 $content .= '<div class="hatom-extra" style="display:none;visibility:hidden;"><span class="entry-title">'.$title.'</span> was last modified: <span class="updated"> '.$t.'</span> by <span class="author vcard"><span class="fn">'.$author.'</span></span></div>';
 }
 return $content;
 }
add_filter('the_content', 'add_atom_data');

// access control rules
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Credentials: true");


add_filter('query_vars', 'custom_query_vars_bdokimakis', 10, 1 );
//add_action('init', 'custom_rewrite_rules_bdokimakis', 10, 1 );

function custom_query_vars_bdokimakis($vars){
  $vars[] = 'cat_slug';
  $vars[] = 'fibre_slug';
  $vars[] = 'brand_slug';
  $vars[] = 'type';
  $vars[] = 'lifestyle';
  $vars[] = 'feature';
  return $vars;
}

function custom_rewrite_rules_bdokimakis() {
  add_rewrite_rule(
    '^category-page/([^/]*)/?([^/]*)/?',
    'index.php?pagename=category-page&cat_slug=$matches[1]&fibre_slug=$matches[2]',
    'top'
  );

	add_rewrite_rule(
    '^fibers-page/([^/]*)/?',
    'index.php?pagename=fibers-page&cat_slug=$matches[1]',
    'top'
  );
  
  add_rewrite_rule(
    '^brand/([^/]*)/?([^/]*)/?([^/]*)/?',
    'index.php?pagename=brand&brand_slug=$matches[1]&cat_slug=$matches[2]&fibre_slug=$matches[3]',
    'top'
  );
  
  add_rewrite_rule(
    '^product-filter/([^/]*)/?([^/]*)/?([^/]*)/?',
    'index.php?pagename=product-filter&type=$matches[1]&lifestyle=$matches[2]&feature=$matches[3]',
    'top'
  );
  
  add_rewrite_rule(
    '^products/([^/]*)/?([^/]*)/?([^/]*)/?([^/]*)/?',
    'index.php?pagename=product-filter&type=$matches[1]&lifestyle=$matches[2]&feature=$matches[3]&fibres=$matches[4]',
    'top'
  );
}

add_action( 'preprocess_comment', 'ct_minimum_comment_length', 8 );

function ct_minimum_comment_length( $commentdata ){
    $minlength = 20;//minimal length you want to limit the comment content
    preg_match_all( '/./u', trim( $commentdata['comment_content'] ), $maxlength );
    $maxlength = count( $maxlength[0] );
    if( $maxlength < $minlength ) {
        wp_die( sprintf(_('Come on buddy, say at least %s characters', 'ct'), $minlength ));
    }
    return $commentdata;
}


function my_search_form( $form ) {

    $form = '<form role="search" method="get" class="search-form" action="' . esc_url( home_url( '/' ) ) . '">
				<input type="text" class="search-field" placeholder="type keyword(s) here" value="' . get_search_query() . '" name="s" />
				<button type="submit" class="btn btn-submit search-submit">Search</button>
			</form>';

    return $form;
}
add_filter( 'get_search_form', 'my_search_form' );

add_theme_support( 'post-thumbnails' );
function cc_mime_types($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}

add_filter('upload_mimes', 'cc_mime_types');

function template_part($template, $data = array()){

    extract($data);
    ob_start();
    require get_stylesheet_directory() . '/template-parts/' . $template . '.php';

    return ob_get_clean();
}

function enqueue_versioned_script( $handle, $src = false, $deps = array(), $in_footer = false ) {
    wp_enqueue_script( $handle, get_stylesheet_directory_uri() . $src, $deps, filemtime( get_stylesheet_directory() . $src ), $in_footer );
}

function enqueue_versioned_style( $handle, $src = false, $deps = array(), $media = 'all' ) {
    wp_enqueue_style( $handle, get_stylesheet_directory_uri() . $src, $deps = array(), filemtime( get_stylesheet_directory() . $src ), $media );
}
function dump($data, $exit = false){
    echo "<pre>";
    print_r($data);
    echo "</pre>";

    if($exit){
        exit();
    }
}

add_filter( 'wpseo_breadcrumb_output', 'custom_wpseo_breadcrumb_output' );
function custom_wpseo_breadcrumb_output( $output ){

    $output = str_replace("<span><span>", "", $output);
    $output = str_replace("</span></span>", "", $output);

    return $output;
}

function newDesign() {
    $post = get_post();

    $flag = false;
    if (!empty($post)) {
        if ($post->post_type == 'wpsl_stores' || $post->post_type == 'post' || $post->post_type == 'product') {
            $flag = true;
        }
    }

    if (is_front_page() || $flag) {
        return true;
    } else {
        return false;
    }

}

getCatalogType();

function getCatalogType() {
    /*
    if (!empty($_COOKIE['catalog-type']) && $_COOKIE['catalog-type'] == 'room') {
        define('CATEGORY_TYPE', 'room');
    } else {
        define('CATEGORY_TYPE', 'swatch');
    }
    */
    define('CATEGORY_TYPE', 'swatch');
}

function strWordCut($string,$length,$link,$end='... ')
{
    $string = strip_tags($string);

    if (strlen($string) > $length) {

        // truncate string
        $stringCut = substr($string, 0, $length);

        // make sure it ends in a word so assassinate doesn't become ass...
        $string = substr($stringCut, 0, strrpos($stringCut, ' ')).$end.'<a href="'.$link.'" >see more</a>';
    }
    return $string;
}


add_filter( 'site_transient_update_plugins', 'filter_plugin_updates' );
function filter_plugin_updates( $value ) {
    unset( $value->response['wp-store-locator/wp-store-locator.php'] );
    return $value;
}


function short_code_content_media($atts) {
    ob_start();
    require get_stylesheet_directory() . '/template-parts/mediacontent.php';
    return ob_get_clean();
}
add_shortcode('mediacontent' , 'short_code_content_media' );

function addRelatedProducts() {
    global $wpdb;

    $args = [
        'post_type'   => 'product',
        'numberposts' => -1
    ];

    $products = get_posts($args);

    $colorsData = get_terms([
        'taxonomy' => 'pa_color'
    ]);

    $relatedData = [];

    if (!empty($products)) {
        foreach ($products as $prod) {
            $baseName = '';
            $mainProductColor = [];
            $relatedProducts = [];
            $product = wc_get_product($prod->ID);
            if ( $product instanceof WC_Product) {
                $attrs = $product->get_attributes();
                if (!empty($attrs)) {
                    foreach ($attrs as $key => $attr) {
                        if ($key == 'pa_color') {
                            $data = $attr->get_data();
                            if (!empty($data['options'])) {
                                foreach ($data['options'] as $optionID) {
                                    foreach ($colorsData as $color) {
                                        if ($color->term_id == $optionID) {
                                            $pos = strpos($prod->post_title, $color->name);
                                            if ($pos !== false) {
                                                $mainProductColor = $color;
                                                $baseNameData = explode($color->name, $prod->post_title);
                                                if (isset($baseNameData[1])) {
                                                    $baseName = trim($baseNameData[0]);
                                                }

                                                if (!empty($baseName)) {
                                                    $search_query = "SELECT ID FROM {$wpdb->prefix}posts
                                                                         WHERE post_type = 'product' 
                                                                         AND post_title LIKE %s";
                                                    $like = $baseName.'%';
                                                    $results = $wpdb->get_results($wpdb->prepare($search_query, $like), ARRAY_N);
                                                    foreach($results as $key => $array){
                                                        $relatedProducts[] = $array[0];
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $relatedData[$prod->ID] = [
                'ID'              => $prod->ID,
                'title'           => $prod->post_title,
                'baseName'        => $baseName,
                'mainColor'       => $mainProductColor,
                'relatedProducts' => $relatedProducts
            ];
        }
    }


    if (!empty($relatedData)) {
        foreach ($relatedData as $item) {
            if (!empty($item['mainColor'])) {
                $colorProductField = get_field_object('current_colour', $item['ID']);
                if (!empty($colorProductField['key'])) {
                    update_field($colorProductField['key'], $item['mainColor']->term_id, $item['ID']);
                } else {
                    update_field('field_5f290e4682bd7', $item['mainColor']->term_id, $item['ID']);
                }
            }
            if (!empty($item['relatedProducts'])) {
                $relatedProductsField = get_field_object('related_products', $item['ID']);
                if (!empty($relatedProductsField['key'])) {
                    update_field($relatedProductsField['key'], $item['relatedProducts'], $item['ID']);
                } else {
                    update_field('field_5f290e8682bd8', $item['relatedProducts'], $item['ID']);
                }
            }
        }
    }

    dump($relatedData);
    exit();
}
//addRelatedProducts();
add_action( 'wp_ajax_load_search_results', 'load_search_results' );
add_action( 'wp_ajax_nopriv_load_search_results', 'load_search_results' );

function load_search_results() {
    $query = $_POST['query'];

    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        's' => $query,
        'posts_per_page' => 4
    );
    $search = new WP_Query( $args );

    ob_start();

    if ( $search->have_posts() ) :
        ?>
        <div class="drop-search-tile">

            <?php
            while ( $search->have_posts() ) : $search->the_post();

                $primary = new WPSEO_Primary_Term('product_cat', get_the_ID());
                $primary = $primary->get_primary_term();
                $primary_cat = get_term_by('term_taxonomy_id', $primary);
                $featured_image = get_field('swatch_image', get_the_ID());
                ?>
                <a href="<?= get_permalink(get_the_ID())?>" class="search-result-card">
                    <div class="search-result-card__img"><img src="<?= isset($featured_image['url']) ? $featured_image['url'] : '' ?>" alt="<?= the_title()?>"></div>
                    <div class="search-result-card__title">
                        <div class="search-result-card__name"><?= the_title()?></div>
                        <div class="search-result-card__whish"><i class="ic-bar-heart"></i></div>
                    </div>
                    <div class="search-result-card__subtitle"><?= $primary_cat->name?></div>
                </a>
            <?php

            endwhile;
            ?>
        </div>
        <div class="drop-search-total">
            <div class="drop-search-total__value">showing 4 of <?= $search->found_posts ?> results for ‘<?= $query ?>'</div>
        </div>
        <div class="drop-search-show"><a href="#" class="drop-search-show__link btn btn-index btn--grey" id="full-search-load">view all products</a></div>
    <?php else :
        echo 'No results';
    endif;

    $content = ob_get_clean();

    echo $content;
    die();

}

add_action( 'wp_ajax_load_related_results', 'load_related_results' );
add_action( 'wp_ajax_nopriv_load_related_results', 'load_related_results' );

function load_related_results() {
    $query = $_POST['query'];

    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        's' => $query,
        'posts_per_page' => 4
    );
    $search = new WP_Query( $args );

    ob_start();

    if ( $search->have_posts() ) :
        ?>
        <div class="drop-search-category">
        <div class="drop-search-category__title">related categories</div>
        <ul class="drop-search-category__list">

        <?php

        while ( $search->have_posts() ) : $search->the_post();
            $primary = new WPSEO_Primary_Term('product_cat', get_the_ID());
            $primary = $primary->get_primary_term();
            $primary_cat = get_term_by('term_taxonomy_id', $primary);
            $style_value = get_field('style_filter', get_the_ID());
            $styles_array = get_field_object('style_filter', get_the_ID());
            if(array_key_exists($style_value[0],$styles_array['choices'])) {
                $style_title = $styles_array['choices'][$style_value[0]];
            }

            if (($search->current_post + 1)  !=  $search->post_count) : ?>
                <li><a href="<?= get_permalink(get_the_ID())?>">shop  <?= isset($primary_cat->name) ? $primary_cat->name : 'Carpet'?>  / <?= isset($style_title) ? $style_title : 'Cut Pile'?></a></li>
            <?php else :?>
                <li><a href="<?= get_permalink(get_the_ID())?>">shop  <?= isset($primary_cat->name) ? $primary_cat->name : 'Carpet' ?>  / <?= isset($style_title) ? $style_title : 'Cut Pile'?></a></li>
                </ul>
                </div>
                <div class="drop-search-category">
                <div class="drop-search-category__title">related articles</div>
                <ul class="drop-search-category__list">
                <?php
                $args = [
                    'numberposts' => 2,
                    'post_type' => ['post', 'page'],
                    's' => $query
                ];
                $rel_art = get_posts($args);
                if(!empty($rel_art)) {
                    foreach ($rel_art as $article)  :
                        ?>
                        <li><a href="<?= get_permalink($article->ID)?>"><?= $article->post_title?></a></li>
                    <?php
                    endforeach;
                }

            endif;
        endwhile;

        ?>
        </ul>
        </div>
    <?php
    endif;

    $content = ob_get_clean();

    echo $content;
    die();

}