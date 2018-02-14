<?php
/*
Plugin Name: Private Posts
Plugin URI: https://shtrak.eu
Description: This plugin adds the ability to create private posts
Author: venqka
Author URI: https://shtrak.eu
Text Domain: sh
Domain Path: /languages
Version: 1.0
*/

include( 'ppt-settings.php' );
include( 'ppt-functions.php' );

/***********************************************
	Load textdomain
***********************************************/

function pp_load_textdomain() {

	load_plugin_textdomain( 'pp', false, basename( dirname( __FILE__ ) ) . '/languages' );

}
add_action( 'plugins_loaded', 'pp_load_textdomain' );

/*************************************************
	Enqueue
*************************************************/

function pp_enqueue() {

	wp_enqueue_style( 'pp-styles', plugin_dir_url( __FILE__ ) . 'styles/style.css', array(), '1.0', false );

}
add_action( 'wp_enqueue_scripts', 'pp_enqueue' );

/***********************************************
	Register private post type
***********************************************/

function pp_private_post_type() {

	$ppt_labels = array(

		'name'               => _x( 'Private posts', 'post type general name', 'pp' ),
		'singular_name'      => _x( 'Private post', 'post type singular name', 'pp' ),
		'menu_name'          => _x( 'Private posts', 'admin menu', 'pp' ),
		'name_admin_bar'     => _x( 'Private post', 'add new on admin bar', 'pp' ),
		'add_new'            => _x( 'Add New', 'Private post', 'pp' ),
		'add_new_item'       => __( 'Add New Private post', 'pp' ),
		'new_item'           => __( 'New Private post', 'pp' ),
		'edit_item'          => __( 'Edit Private post', 'pp' ),
		'view_item'          => __( 'View Private post', 'pp' ),
		'all_items'          => __( 'All Private posts', 'pp' ),
		'search_items'       => __( 'Search Private posts', 'pp' ),
		'parent_item_colon'  => __( 'Parent Private posts:', 'pp' ),
		'not_found'          => __( 'No Private posts found.', 'pp' ),
		'not_found_in_trash' => __( 'No Private posts found in Trash.', 'pp' )
	);

	$ppt_args = array(
		'labels'            	=> $ppt_labels,
        'description'        	=> __( 'These posts are password protected.', 'pp' ),
		'public'             	=> true,
		'exclude_from_search'	=> true,
		'publicly_queryable'	=> true,
		'show_in_nav_menus'		=> false,
		'show_ui'            	=> true,
		'show_in_menu'       	=> true,
		'query_var'          	=> true,
		'rewrite'            	=> array( 'slug' => 'private-posts' ),
		'capability_type'    	=> 'post',
		'has_archive'        	=> true,
		'hierarchical'       	=> false,
		'menu_position'      	=> 5,
		'menu_icon'				=> 'dashicons-hidden',
		'supports'           	=> array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )

	);
	register_post_type( 'private-post', $ppt_args );
}
add_action('init', 'pp_private_post_type' );

/***********************************************
	Exclude private post from feed
***********************************************/

function pp_exclude_ppt_from_feed( $query ) {

	if ( $query->is_feed() && in_array( 'private-post', (array) $query->get( 'post_type' ) ) ) {
		die( 'Feed disabled' );
	}
}
add_filter( 'pre_get_posts', 'pp_exclude_ppt_from_feed' );



/***********************************************
	Private posts templates
***********************************************/

/*************** Single **********************/

function pp_ppt_single_template( $single ) {
	    
    global $post;
    $template = plugin_dir_path( __FILE__ ) . 'templates/single-ppt.php';
	    
    if ( is_private( $post->ID ) ) {

        if( file_exists( $template ) ) {
            return $template;
        }

    }
    return $single;
}
add_filter( 'single_template', 'pp_ppt_single_template' );

/*************** Archive **********************/

function pp_ppt_archive_template( $archive ) {
    
    global $post;
    $template = plugin_dir_path( __FILE__ ) . 'templates/archive-ppt.php';
     
    if ( is_private( $post->ID ) ) {

        if( file_exists( $template ) ) {
            return $template;
        }
    }
    return $archive;
}
add_filter( 'archive_template', 'pp_ppt_archive_template' );
