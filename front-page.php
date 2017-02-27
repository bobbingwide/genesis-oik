<?php // (C) Copyright Bobbing Wide 2015-2017
/**
 * Template file for the front-page which may also be the home page.
 *
 * We don't want:
 * - Title
 * - Sidebar - this is chosen using the "Layout settings"
 * - Breadcrumbs - chosen using Genesis > Theme settings > Breadcrumbs: Front page checkbox
 *
 * Found out how to do this by using {@link genesis.wp-a2z.org}
 * and oik-bwtrace and good old grep
 * and most recently... genesis_all()
 */
if ( !is_home() ) {
	remove_action( "genesis_entry_header", "genesis_do_post_title" );
}

//add_action( "genesis_before_loop", "genesis_oik_a2z" );



//add_action( "genesis_after_footer", "genesis_oik_after_footer" );
add_action( "wp_enqueue_scripts", "genesis_oik_after_footer" );

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
genesis();


/**
 * Enqueue special styles for archives
 */
function genesis_oik_after_footer() {
 	$timestamp = null;
	if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
		$timestamp = filemtime( get_stylesheet_directory() . "/front-page.css" );
	}
	wp_enqueue_style( "archive-css", get_stylesheet_directory_uri() . '/front-page.css', array(), $timestamp );
}


