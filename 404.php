<?php	// (C) Copyright Bobbing Wide 2016

/**
 * Output a 404 "Not Found" error message
 * 
 * Plugins should respond to "genesis_404" and decide whether or not to 
 * handle the filters for entry_title and entry_content
 *
 */
function genesis_oik_404() {
	/**
	 * Indicate that the 404 page is about to be displayed
	 *
	 * @param string $noneactually this is just a test
	 */
	do_action( "genesis_404" );
	echo '<article class="entry">';
  printf( '<h1 class="entry-title">%s</h1>', apply_filters( 'genesis_404_entry_title', __( 'Not found', 'genesis-oik' ) ) );
	echo '<div class="entry-content">';
	$default_text = '<p>'; 
	$default_text .= sprintf( __( 'The page you are looking for no longer exists. Perhaps you can return back to the site\'s <a href="%s">homepage</a> and see if you can find what you are looking for. Or, you can try finding it by using the search form below.', 'genesis-oik' ), trailingslashit( home_url() ) );
	$default_text .= '</p>';
	echo apply_filters( 'genesis_404_entry_content', $default_text );

	get_search_form();
  echo '</div>';
  echo '</article>';
}

/*
 * Replace default loop with the 404 page
 * Then do the default loop anyway?
 */
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'genesis_oik_404', 8 );
genesis();
