<?php // (C) Copyright Bobbing Wide 2015

//* Child theme (do not remove) - is this really necessary? 
define( 'CHILD_THEME_NAME', 'Genesis OIK' );
define( 'CHILD_THEME_URL', 'http://www.bobbingwide.com/oik-themes' );
define( 'CHILD_THEME_VERSION', '2.1.2' );


/**
 * Implement 'wp_ajax_send-attachment-to-editor' to not attach an unattached media item
 * 
 * In WordPress TRAC 22085 there was a change
 * that caused unattached media files (images) to be attached to posts if they are inserted into the post
 *
 * https://core.trac.wordpress.org/ticket/22085
 *
 * If you don't like this strategy you can disable it using this simple, rather hacky, action hook.
 * 
 * It relies on the following code being in wp_ajax_send_attachment_to_editor()
 *
 * `
 * if ( 0 == $post->post_parent && $insert_into_post_id = intval( $_POST['post_id'] ) ) {
 *     wp_update_post( array( 'ID' => $id, 'post_parent' => $insert_into_post_id ) );
 *  }
 * `
 *
 * It also relies on there being no other code that requires the post_id value.
 * If this were not the case we'd have to
 * - reset it in a later hook, which doesn't look particularly possible
 * - or implement a different solution to cause current_user_can() to fail
 * - or apply a pretend setting of $post->post_parent at the end of get_post()
 * 
 */
function dont_attach( $blah ) {
	//$_POST['post_id'] = 0;
}

/*
 * Hook into the AJAX request before WordPress, using priority 0
 */ 
add_action( 'wp_ajax_send-attachment-to-editor', 'dont_attach', 0 );


/**
 * Display footer credits for the oik theme
 */	
function oik_footer_creds_text( $text ) {
	$text = "[bw_wpadmin]";
  $text .= '<br />';
	$text .= "[bw_copyright]"; 
	$text .= '<hr />';
	$text .= 'Website designed and developed by [bw_link text="Herb Miller" herbmiller.me] of';
	$text .= ' <a href="//www.bobbingwide.com" title="Bobbing Wide - web design, web development">[bw]</a>';
	$text .= '<br />';
	$text .= '[bw_power]';
  return( $text );
}

/**
 * Trace all genesis hooks
 * 
 * So we can attempt to see what hook causes Genesis to do something.
 * Use View source and look for all the genesis hook names inside HTML comments
 * 
 * Notes:
 * - it's not safe to produce HTML comments before the doctype tag has been created
 * - we're only interested hooks prefixed 'genesis_'
 *
 * @param string $tag the action hook or filter
 * @param mixed $args parameters? 
 */
function genesis_all( $tag, $args2=null ) {
	static $ok_to_e_c = false;
	if ( $ok_to_e_c ) {
		if ( 0 === strpos( $tag, "genesis_" ) ) {
			$hooked = genesis_get_hooks( $tag );
			_e_c( "$tag $hooked" );
		}
	} else {
		if ( "genesis_doctype" === $tag ) {
			$ok_to_e_c = true;
		}
	}
}

/**
 * Return the attached hooks
 *
 * @param string $tag the action hook or filter
 * @return string the attached hook information
 *
 */
function genesis_get_hooks( $tag ) {
	global $wp_filter; 
  if ( isset( $wp_filter[ $tag ] ) ) {
		$hooks = null;
		foreach ( $wp_filter[ $tag ] as $priority => $functions ) {
			$hooks .= "\n: $priority  ";
			foreach ( $functions as $index => $args ) {
				$hooks .= " ";
				if ( is_array( $args['function'] ) ) {
					//bw_trace2( $args, "args" );
					$object_name = get_class( $args['function'][0] );
					$hooks .= $object_name . '::' . $args['function'][1];
				} else {
					$hooks .= $args['function'];
				}
			}
		}
	} else {
		$hooks = null;
	}
	return( $hooks ); 
}

/**
 * Echo a comment
 *
 * @param string $string the text to echo inside the comment
 */

function _e_c( $string ) {
	echo "<!--";
	echo $string;
	echo "-->";
}

/**
 * Register special sidebars 
 *
 * We support special sidebars for
 * "oik-plugins"
 * "oik_shortcodes"
 * "oik_pluginversion"
 * "shortcode_example"
 * "download"
 *
 * We don't display sidebars for
 * 
 * Everything else may have the default sidebar 
   
	 'before_widget' => '<widget id="%1$s" name="%1$s" class="widget %2$s">',
      'before_title' => '<title>',
      'after_title' => '</title>',
      'after_widget' => '</widget>'

 */
function genesis_oik_register_sidebars() {
  //bw_backtrace();
  $cpts = array( "oik-plugins", "oik_shortcodes", "shortcode_example", "download", "oik_pluginversion", "oik-themes" );
  $theme_widget_args = array( );
  foreach ( $cpts as $cpt ) {
    $theme_widget_args['group'] = 'default';
    $theme_widget_args['id'] = "$cpt-widget-area";
    $theme_widget_args['name'] = "$cpt widget area";
    $theme_widget_args['description'] = "sidebar for $cpt";  
    genesis_register_sidebar( $theme_widget_args );
  }
}

/**
 * Display the post info in our style
 *
 * We only want to display the post date and post modified date
 *
 */
function genesis_oik_post_info() {
	$output = genesis_markup( array(
    'html5'   => '<p %s>',
    'xhtml'   => '<div class="post-info">',
    'context' => 'entry-meta-before-content',
    'echo'    => false,
	) );
	$string = sprintf( __( 'Published %1$s', 'genesis-oik' ), '[post_date]' );
	$string .= ' | ';
	$string .= sprintf( __( 'Last updated %1$s', 'genesis-oik' ), '[post_modified_date]' );
	$string .= ' [post_edit]';
	$output .= apply_filters( 'genesis_post_info', $string);
	$output .= genesis_html5() ? '</p>' : '</div>';  
	echo $output;
}

/**
 * Display the sidebar for the given post type
 *
 * Note: uses oik_pluginversion for oik_premiumversion
 * 
 */
function genesis_oik_get_sidebar() {
	//* Output primary sidebar structure
	genesis_markup( array(
		'html5'   => '<aside %s>',
		'xhtml'   => '<div id="sidebar" class="sidebar widget-area">',
		'context' => 'sidebar-primary',
	) );
	do_action( 'genesis_before_sidebar_widget_area' );
	$post_type = get_post_type();
	if ( $post_type == "oik_premiumversion" ) {
		$post_type = "oik_pluginversion";
	}
	dynamic_sidebar( "$post_type-widget-area" );
	do_action( 'genesis_after_sidebar_widget_area' );
	genesis_markup( array(
		'html5' => '</aside>', //* end .sidebar-primary
		'xhtml' => '</div>', //* end #sidebar
	) );
} 

/**
 * Implement 'genesis_oik_pre_get_option_site_layout' filter 
 *
 * The _genesis_layout has not been defined so we need to decide based on the 
 * previous setting for the Artisteer theme.
 *
 * @param string $layout originally null
 * @param string $setting the current default setting 
 * @return string $layout which is either to have a sidebar or not
 */
function genesis_oik_pre_get_option_site_layout( $layout, $setting ) {
	//bw_trace2();
	$artisteer_sidebar = genesis_get_custom_field( "_theme_layout_template_default_sidebar" );
	if ( $artisteer_sidebar ) {	
		$layout = __genesis_return_content_sidebar();
	} else {
		$layout = __genesis_return_full_width_content();
	}
	return( $layout );
}


/**
 * Register the hooks for this theme
 */
function genesis_oik_functions_loaded() {
	// Start the engine	- @TODO Is this necessary?
	include_once( get_template_directory() . '/lib/init.php' );
	
	if ( defined( "GENESIS_ALL" ) && GENESIS_ALL ) {
  	add_action( "all", "genesis_all", 10, 2 );
	}
	//* Add HTML5 markup structure
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

	//* Add viewport meta tag for mobile browsers
	add_theme_support( 'genesis-responsive-viewport' );
	
	// Add support for structural wraps
	add_theme_support( 'genesis-structural-wraps', array(
	 'header',
	//	'nav',
	//        'subnav',
		'site-inner'
	) );

	//* Add support for custom background
	add_theme_support( 'custom-background' );

	//* Add support for 5-column footer widgets - requires extra CSS
	add_theme_support( 'genesis-footer-widgets', 5 );

	add_filter( 'genesis_footer_creds_text', "oik_footer_creds_text" );
	
  add_filter( 'genesis_pre_get_option_site_layout', 'genesis_oik_pre_get_option_site_layout', 10, 2 );
	
	remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
	
	// Remove post info
	remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
	add_action( 'genesis_entry_footer', 'genesis_oik_post_info' );
	
  genesis_oik_register_sidebars();

}

genesis_oik_functions_loaded();
