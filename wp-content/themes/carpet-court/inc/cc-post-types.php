<?php
/**
 * Created by PhpStorm.
 * User: Rubal
 * Date: 2/16/16
 * Time: 10:01 AM
 */

add_action( 'init', 'cc_post_types',0 );

function cc_post_types() {

    //Designer Tips
    $tips_labels = array(
        'name'               => _x( 'Tips', 'post type general name', 'carpet-court' ),
        'singular_name'      => _x( 'Tip', 'post type singular name', 'carpet-court' ),
        'menu_name'          => _x( 'Tips', 'admin menu', 'carpet-court' ),
        'name_admin_bar'     => _x( 'Tip', 'add new on admin bar', 'carpet-court' ),
        'add_new'            => _x( 'Add New', 'Designer Tip', 'carpet-court' ),
        'add_new_item'       => __( 'Add New Designer Tip', 'carpet-court' ),
        'new_item'           => __( 'New Designer Tip', 'carpet-court' ),
        'edit_item'          => __( 'Edit Designer Tip', 'carpet-court' ),
        'view_item'          => __( 'View Designer Tip', 'carpet-court' ),
        'all_items'          => __( 'All Designer Tips', 'carpet-court' ),
        'search_items'       => __( 'Search Designer Tips', 'carpet-court' ),
        'parent_item_colon'  => __( 'Parent Designer Tips:', 'carpet-court' ),
        'not_found'          => __( 'No Designer Tips found.', 'carpet-court' ),
        'not_found_in_trash' => __( 'No Designer Tips found in Trash.', 'carpet-court' )
    );

    $tips_args = array(
        'labels'             => $tips_labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'taxonomies'         => array('cc_design_cat'),
        'rewrite'            => array( 'slug' => 'designer-tip' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
    );

    register_post_type( 'cc_tips', $tips_args );

    //Designer Tips category
    $labels = array(
        'name'              => _x( 'Tips Categories', 'taxonomy general name' ),
        'singular_name'     => _x( 'Category', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Categories' ),
        'all_items'         => __( 'All Categories' ),
        'parent_item'       => __( 'Parent Category' ),
        'parent_item_colon' => __( 'Parent Category:' ),
        'edit_item'         => __( 'Edit Category' ),
        'update_item'       => __( 'Update Category' ),
        'add_new_item'      => __( 'Add New Category' ),
        'new_item_name'     => __( 'New Category Name' ),
        'menu_name'         => __( 'Category' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'category' ),
    );

    register_taxonomy( 'cc_design_cat', array( 'cc_tips' ), $args );

    //Designer Troubleshooting
    $troubleshooting_labels = array(
        'name'               => _x( 'Troubleshooting', 'post type general name', 'carpet-court' ),
        'singular_name'      => _x( 'Troubleshooting', 'post type singular name', 'carpet-court' ),
        'menu_name'          => _x( 'Troubleshooting', 'admin menu', 'carpet-court' ),
        'name_admin_bar'     => _x( 'Troubleshooting', 'add new on admin bar', 'carpet-court' ),
        'add_new'            => _x( 'Add New', 'Designer Troubleshooting', 'carpet-court' ),
        'add_new_item'       => __( 'Add New Designer Troubleshooting', 'carpet-court' ),
        'new_item'           => __( 'New Designer Troubleshooting', 'carpet-court' ),
        'edit_item'          => __( 'Edit Designer Troubleshooting', 'carpet-court' ),
        'view_item'          => __( 'View Designer Troubleshooting', 'carpet-court' ),
        'all_items'          => __( 'All Designer Troubleshooting', 'carpet-court' ),
        'search_items'       => __( 'Search Designer Troubleshooting', 'carpet-court' ),
        'parent_item_colon'  => __( 'Parent Designer Troubleshooting:', 'carpet-court' ),
        'not_found'          => __( 'No Designer Troubleshooting found.', 'carpet-court' ),
        'not_found_in_trash' => __( 'No Designer Troubleshooting found in Trash.', 'carpet-court' )
    );

    $troubleshooting_args = array(
        'labels'             => $troubleshooting_labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'taxonomies'         => array('cc_trouble_cat'),
        'rewrite'            => array( 'slug' => 'designer-troubleshooting' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
    );

    register_post_type( 'cc_troubleshooting', $troubleshooting_args );

    //Designer Troubleshooting category
    $trouble_labels = array(
        'name'              => _x( 'Categories', 'taxonomy general name' ),
        'singular_name'     => _x( 'Category', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Categories' ),
        'all_items'         => __( 'All Categories' ),
        'parent_item'       => __( 'Parent Category' ),
        'parent_item_colon' => __( 'Parent Category:' ),
        'edit_item'         => __( 'Edit Category' ),
        'update_item'       => __( 'Update Category' ),
        'add_new_item'      => __( 'Add New Category' ),
        'new_item_name'     => __( 'New Category Name' ),
        'menu_name'         => __( 'Category' ),
    );

    $trouble_args = array(
        'hierarchical'      => true,
        'labels'            => $trouble_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'category' ),
    );
    register_taxonomy( 'cc_trouble_cat', array( 'cc_troubleshooting' ), $trouble_args );


    //Ideas
    $idea_labels = array(
        'name'               => _x( 'Ideas', 'post type general name', 'carpet-court' ),
        'singular_name'      => _x( 'Idea', 'post type singular name', 'carpet-court' ),
        'menu_name'          => _x( 'Ideas', 'admin menu', 'carpet-court' ),
        'name_admin_bar'     => _x( 'Idea', 'add new on admin bar', 'carpet-court' ),
        'add_new'            => _x( 'Add New', 'Idea', 'carpet-court' ),
        'add_new_item'       => __( 'Add New Idea', 'carpet-court' ),
        'new_item'           => __( 'New Idea', 'carpet-court' ),
        'edit_item'          => __( 'Edit Idea', 'carpet-court' ),
        'view_item'          => __( 'View Idea', 'carpet-court' ),
        'all_items'          => __( 'All Ideas', 'carpet-court' ),
        'search_items'       => __( 'Search Ideas', 'carpet-court' ),
        'parent_item_colon'  => __( 'Parent Ideas:', 'carpet-court' ),
        'not_found'          => __( 'No Ideas found.', 'carpet-court' ),
        'not_found_in_trash' => __( 'No Ideas found in Trash.', 'carpet-court' )
    );

    $idea_args = array(
        'labels'             => $idea_labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'taxonomies'         => array('cc_idea_cat'),
        'rewrite'            => array( 'slug' => 'idea' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
    );

    register_post_type( 'cc_ideas', $idea_args );

//Ideas category
    $idea_cat_labels = array(
        'name'              => _x( 'Idea Categories', 'taxonomy general name' ),
        'singular_name'     => _x( 'Category', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Categories' ),
        'all_items'         => __( 'All Categories' ),
        'parent_item'       => __( 'Parent Category' ),
        'parent_item_colon' => __( 'Parent Category:' ),
        'edit_item'         => __( 'Edit Category' ),
        'update_item'       => __( 'Update Category' ),
        'add_new_item'      => __( 'Add New Category' ),
        'new_item_name'     => __( 'New Category Name' ),
        'menu_name'         => __( 'Category' ),
    );

    $idea_cat_args = array(
        'hierarchical'      => true,
        'labels'            => $idea_cat_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'category' ),
    );

    register_taxonomy( 'cc_idea_cat', array( 'cc_ideas' ), $idea_cat_args );

}
