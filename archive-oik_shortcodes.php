<?php // (C) Copyright Bobbing Wide 2015-2017

/**
 * Special archive file for oik_shortcodes
 *
 * Caters for links for shortcodes which this website doesn't know about.
 * What we expect to happen is that the shortcode will be found so we display the singular page.
 * 
 * But when the shortcode isn't found, due to the way the link has been formed.
 * we end up on this archive page with no posts.
 *
 * And so the genesis standard loop invokes genesis_loop_else.
 * 
 * The format of the link that will produce this message is:
 * `http://example.com/oik-shortcodes/oik-shortcode/oik-function`
 * `
 *
 * This is different to:
 * `http://example.com/oik_shortcodes/oik-shortcode`
 * 
 * @TODO Of course, if there aren't any oik_shortcodes posts then we'll get here as well
 * .. and the query vars won't be set. So currently the message looks funny.
 * 
 * Note: This code is dependent upon oik
 */
 
/**
 * Implements 'genesis_loop_else' for genesis-oik 
 */
function genesis_oik_shortcode_not_defined() {
	e( "Sorry, we're unable to display information for the selected shortcode." );
	br( "The shortcode is not yet registered to this site." );
	
	$oik_shortcode = get_query_var( "oik-shortcode" );
	if ( $oik_shortcode ) {
		$p = "Shortcode: ";
		$p .= esc_html( $oik_shortcode );
		p( $p );
	}
	
	$oik_function = get_query_var( "oik-function" );
	if ( $oik_function ) {
	
		$p = "Function: ";
		$p .= esc_html( $oik_function );
		p( $p );
		
	}
	bw_flush();
}

remove_action( "genesis_loop_else", "genesis_do_noposts" );
add_action( "genesis_loop_else", "genesis_oik_shortcode_not_defined" );

remove_action( "genesis_entry_content", "genesis_do_post_image", 8 );

require_once( CHILD_DIR . '/archive.php' );


