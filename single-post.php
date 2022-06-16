<?php // (C) Copyright Bobbing Wide 2015-2017
/**
 * Template file for the "post" post type
 *
 * We do want:
 * - Breadcrumbs - turn on in Genesis theme settings
 * - Title	- though this can come from the Breadcrumbs
 * - the content 
 * - the create date and modification date with Edit link
 * - Primary sidebar - always below the main content.
 * - Filed Under:
 * 
 *
 * We don't want:
 * - Post info from meta data
 * - Published by
 */
function genesis_oik_single_post() {
	//add_theme_support( 'html5' );
	
	add_post_type_support( "post", 'genesis-after-entry-widget-area' );
	add_post_type_support( "post", "genesis-entry-meta-after-content" );

	// Remove post info
	//remove_action( 'genesis_entry_header', 'genesis_do_post_title', 10 );

	// Remove breadcrumbs
	//remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

	// Remove the entry meta in the entry footer. i.e. Remove the Filed Under:
	//remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

	add_action( 'genesis_entry_footer', 'genesis_post_meta' );
	add_action( 'genesis_before_content', 'genesis_oik_a2z' );
	

	//bw_disable_filter( 'genesis_edit_post_link', 
	//remove_action( 'genesis_edit_post_link', 
	//remove_action( 'genesis_before_post_content', 'genesis_post_info' );

	// Remove post info
	remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
	//add_action( 'genesis_entry_footer', 'genesis_post_info' );
	add_action( 'genesis_entry_footer', 'genesis_oik_post_info' );

	// Put the image before the rest of the content.
	//add_action( 'genesis_entry_content', 'genesis_image_do_entry_content', 9 );

	remove_action( 'genesis_after_content', 'genesis_get_sidebar' );
	add_action( 'genesis_after_content', 'genesis_oik_get_sidebar' );

	add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );
}
genesis_oik_single_post();
genesis();
