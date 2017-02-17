<?php // (C) Copyright Bobbing Wide 2017

/**
 * Implement a tighter loop for taxonomy archives
 * 
 * Basically we don't want any content except the featured image
 * 
 * BUT 
 * one day we might look at {@link https://github.com/desandro/masonry}
 * 
 */
function genesis_oik_do_loop() {
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			//do_action( 'genesis_before_entry' );
			printf( '<article %s>', genesis_attr( 'entry' ) );
			//do_action( 'genesis_before_entry_content' );
			//printf( '<div %s>', genesis_attr( 'entry-content' ) );
			do_action( 'genesis_entry_header' );
			do_action( 'genesis_entry_content' );
			//echo '</div>';
			//do_action( 'genesis_after_entry_content' );
			//do_action( 'genesis_entry_footer' );
			echo '</article>';
			//do_action( 'genesis_after_entry' );
		}
		do_action( 'genesis_after_endwhile' );
	} else {
		do_action( 'genesis_loop_else' );
	}
}

/**
 * Enqueue special styles for archives
 */
function genesis_oik_after_footer() {
 	$timestamp = null;
	if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
		$timestamp = filemtime( get_stylesheet_directory() . "/taxonomy.css" );
	}
	wp_enqueue_style( "taxonomy-css", get_stylesheet_directory_uri() . '/taxonomy.css', array(), $timestamp );
}
/*
 * Output from genesistant
 *
 * We don't want either post_content nor post_content_nav
 * but we do want the image and may need the post permalink
 * but this should be before the image
 * 
 * `
 * <!--
 * action genesis_entry_content genesis_loop,genesis_entry_content
 *
 * : 8   genesis_do_post_image;1
 * : 10   genesis_do_post_content;1
 * : 12   genesis_do_post_content_nav;1
 * : 14   genesis_do_post_permalink;1--> 
 */
remove_action( "genesis_entry_content", "genesis_do_post_image", 8 );
remove_action( "genesis_entry_content", "genesis_do_post_content", 10 );
remove_action( "genesis_entry_content", "genesis_do_post_content_nav", 12 ); 
remove_action( "genesis_entry_content", "genesis_do_post_permalink", 14 );
add_action( "genesis_entry_content", "genesis_do_post_permalink", 6 );
 
// Not necessary to remove these hooks if we don't invoke the action
 
//remove_action( "genesis_entry_footer", 'genesis_oik_post_info' );
//remove_action( "genesis_entry_footer", "genesis_entry_footer_markup_open", 5);
//remove_action( "genesis_entry_footer", "genesis_entry_footer_markup_close", 15 );
//remove_action( "genesis_entry_header", "genesis_do_post_format_image", 4 );

remove_action( "genesis_loop", "genesis_do_loop" );
add_action( "genesis_loop", "genesis_oik_do_loop" );


//add_action( "genesis_after_footer", "genesis_oik_after_footer" );
add_action( "wp_enqueue_scripts", "genesis_oik_after_footer" );

//add_action( "genesis_after_endwhile", "genesis_oik_a2z", 9 );
add_action( "genesis_before_loop", "genesis_oik_a2z", 9 );

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
genesis();
