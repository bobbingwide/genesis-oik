<?php // (C) Copyright Bobbing Wide 2017
/**
 * Template Name: Blog
 *
 * The blog page loop logic is located in Genesis lib/structure/loops.php.
 * Here we override the Blog page so that it can be assigned to a particular page as a template.
 * We also make it look a bit more like the A to Z archive pages
 * 
 *
 */


/**
 * Enqueue special styles for archives
 */
function genesis_oik_after_footer() {
 	$timestamp = null;
	if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
		$timestamp = filemtime( get_stylesheet_directory() . "/archive.css" );
	}
	wp_enqueue_style( "archive-css", get_stylesheet_directory_uri() . '/archive.css', array(), $timestamp );
}


//add_action( "genesis_after_footer", "genesis_oik_after_footer" );
add_action( "wp_enqueue_scripts", "genesis_oik_after_footer" );

add_action( "genesis_before_loop", "genesis_oik_a2z", 9 );

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
genesis();
