<?php // (C) Copyright Bobbing Wide 2015-2017
/**
 * Template file for the home page
 *
 * We don't want:
 * - Title
 * - Sidebar - this is chosen using the "Layout settings"
 * - Breadcrumbs - chosen using Genesis > Theme settings > Breadcrumbs: Front page checkbox
 *
 */
if ( !is_home() ) {
	remove_action( "genesis_entry_header", "genesis_do_post_title" );
}

add_action( "wp_enqueue_scripts", "genesis_oik_wp_enqueue_scripts" );

add_action( "genesis_before_loop", "genesis_oik_a2z", 9 );

//add_action( "genesis_before_loop", "genesis_oik_a2z" );
genesis();




/**
 * Enqueue special styles for oik_letters
 */
function genesis_oik_wp_enqueue_scripts() {
	$timestamp = null;
	if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
		$timestamp = filemtime( get_stylesheet_directory() . "/archive.css" );
	}
	wp_enqueue_style( "archive-css", get_stylesheet_directory_uri() . '/archive.css', array(), $timestamp );
}
