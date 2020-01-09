<?php // (C) Copyright Bobbing Wide 2015-2019

genesis_oik_functions_loaded();

/**
 * Function to invoke when genesis-oik is loaded
 * 
 * Register the hooks for this theme
 */
function genesis_oik_functions_loaded() {

	//* Child theme (do not remove) - is this really necessary? 
	define( 'CHILD_THEME_NAME', 'Genesis OIK' );
	define( 'CHILD_THEME_URL', 'https://www.oik-plugins.com/oik-themes/genesis-oik' );

	if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
		$timestamp = filemtime( get_stylesheet_directory() . "/style.css" );
		define( 'CHILD_THEME_VERSION', $timestamp );
	} else { 
		define( 'CHILD_THEME_VERSION', '1.2.2' );
	}
	
	// Start the engine. This is necessary if we want to use genesis_ APIs at initial load
	// @TODO - determine if this can be deferred.
	include_once( get_template_directory() . '/lib/init.php' );
	
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

	add_filter( 'genesis_pre_get_option_footer_text', "goik_footer_creds_text" );
	
  //add_filter( 'genesis_pre_get_option_site_layout', 'genesis_oik_pre_get_option_site_layout', 10, 2 );
	
	remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
	
	// Remove post info
	remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
	add_action( 'genesis_entry_footer', 'genesis_oik_post_info' );
	//add_filter( "genesis_edit_post_link", "__return_false" );

  genesis_oik_register_sidebars();
	
	genesis_oik_edd();
	
  add_theme_support( 'woocommerce' );
	
	remove_action( 'wp_head', 'wp_custom_css_cb', 11 );
	remove_action( 'wp_head', 'wp_custom_css_cb', 101 );
	//add_filter( 'sidebars_widgets', 'genesis_oik_sidebars_widgets' );
	//add_action( 'wp_register_sidebar_widget', 'genesis_oik_wp_register_sidebar_widget' );
	
	add_filter( "the_title", "genesis_oik_the_title", 9, 2 );

	/** Allows some blocks to have alignwide or alignfull */

	add_theme_support( "align-wide");
	// Load regular editor styles into the new block-based editor.
	//add_theme_support( 'editor-styles' );

	// Load default block styles.
	//add_theme_support( 'wp-block-styles' );


}

/**
 * Display footer credits for the oik theme
 */	
function goik_footer_creds_text( $text ) {

	/**
	 * Cause shortcodes to be registered.
	 */
	do_action( "oik_add_shortcodes" );
	$text = "[bw_wpadmin]";
  $text .= '<br />';
	$text .= "[bw_copyright]"; 
	$text .= '<hr />';
	$text .= 'Website designed and developed by [bw_link text="Herb Miller" herbmiller.me] of';
	$text .= ' <a href="//www.bobbingwide.com" title="Bobbing Wide - web design, web development">[bw]</a>';
	$text .= '<br />';
	$text .= '[bw_power] and oik-plugins';

  return( $text );
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
 * "block"
 * "block_example"
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
  $cpts = array( "oik-plugins", "oik_shortcodes", "shortcode_example", "download", "oik_pluginversion", "oik-themes", "block", "block_example" );
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
 * EDD extensions for genesis-oik
 */
function genesis_oik_edd() {
	add_filter( "edd_checkout_image_size", "goik_edd_checkout_image_size", 10, 2 );
}

/**
 * Implement "edd_checkout_image_size" for genesis-oik
 */
function goik_edd_checkout_image_size( $dimensions ) {
	return( array( "auto", "auto" ) );
}

/**
 * Display the post info in our style
 *
 * We only want to display the post date and post modified date plus the post_edit link. 
 * 
 * Note: On some pages the post edit link appeared multiple times - so we had to find a fancy way
 * of turning it off, except when we really wanted it. 
 * Solution was to not use "genesis_post_info" but to expand shortcodes ourselves  
 *
 *
 */
function genesis_oik_post_info() {
	remove_filter( "genesis_edit_post_link", "__return_false" );
	$output = genesis_markup( array(
    'html5'   => '<p %s>',
    'xhtml'   => '<div class="post-info">',
    'context' => 'entry-meta-before-content',
    'echo'    => false,
	) );
	$string = sprintf( __( 'Published: %1$s', 'genesis-oik' ), '[post_date]' );
	$string .= '<span class="splitbar">';
	$string .= ' | ';
	$string .= '</span>';
	$string .= '<span class="lastupdated">';
	$string .= sprintf( __( 'Last updated: %1$s', 'genesis-oik' ), '[post_modified_date]' );
	$string .= '</span>';
  $string .= ' [post_edit]';
	//$output .= apply_filters( 'do_shortcodes', $string);
	$output .= do_shortcode( $string );
	$output .= genesis_html5() ? '</p>' : '</div>';  
	echo $output;
	add_filter( "genesis_edit_post_link", "__return_false" );
}

/**
 * Display the sidebar for the given post type
 *
 * Normally we just append -widget-area but for some post types we override it 
 *
 * Post type  | Sidebar used
 * ---------- | -------------
 * oik_premiumversion | oik_pluginversion-widget-area
 * oik_sc_param | sidebar-alt
 * 
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
	$cpts = array( "oik_premiumversion" => "oik_pluginversion-widget-area" 
							 , "oik_sc_param" => "sidebar-alt"
							 , "attachment" => "sidebar-alt"
							 , "post" => "sidebar"
							 );
	$dynamic_sidebar = bw_array_get( $cpts, $post_type, "$post_type-widget-area" ); 
	dynamic_sidebar( $dynamic_sidebar );
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
		// $layout = __genesis_return_full_width_content();
	}
	return( $layout );
}

/**
 * Echo a comment
 *
 * @param string $string the text to echo inside the comment
 */
if ( !function_exists( "_e_c" ) ) { 
function _e_c( $string ) {
	echo "<!--\n";
	echo $string;
	echo "-->";
}
}


function genesis_oik_sidebars_widgets( $widgets ) {
	//unset( $widgets[ 'wp_inactive_widgets' ] );
	bw_trace2( $widgets );
	bw_backtrace();
	//gob();
	return( $widgets );
}

function genesis_oik_wp_register_sidebar_widget( $widget ) {
	global $wp_registered_widgets;
	global $_wp_sidebars_widgets;
	if ( $widget[ 'id' ] == 'text-96' ) {
		bw_backtrace();
		bw_trace2( $wp_registered_widgets, "wp_registered_widgets" );
		bw_trace2( $_wp_sidebars_widgets, "_wp_sidebars_widgets" );
	}
	
}

/**
 * Displays the A to Z pagination
 */
function genesis_oik_a2z() {
	$args = genesis_oik_a2z_display_args();
	$taxonomy = genesis_oik_a2z_query_letter_taxonomy( "letters", $args );
	do_action( "oik_a2z_display", $taxonomy, $args );
}

/**
 * Determines the args to pass to oik_a2z_display
 */
function genesis_oik_a2z_display_args() {
	$args = array();
	if ( is_archive() ) {
		$post_type = get_query_var( "post_type" );
		$args['post_type'] = $post_type;
	}
	return( $args );
}

/**
 * Returns the Letter taxonomy associated to the post type
 * 
 * If post_type is not set then we return the 
 */ 
function genesis_oik_a2z_query_letter_taxonomy( $taxonomy, $args ) {
	$post_type = bw_array_get( $args, "post_type", null );
	if ( $post_type ) {
		$oik_letters = array( "oik_shortcodes" => "letters"
												, "oik_api" => "oik_letters"
												, "oik_class" => "oik_letters"
												, "oik_file" => "oik_letters"
												, "oik_hook" => "oik_letters"
			, "block" => "block_letters"
			, "block_example" => "block_letters"
			, "shortcode_example" => "letters"
												);
		$taxonomy = bw_array_get( $oik_letters, $post_type, $taxonomy );
	}
	return( $taxonomy );
}

/**
 * Displays the A to Z pagination for oik_letters
 */
function genesis_oik_a2z_letters() {
	$args = genesis_oik_a2z_display_args();
	$taxonomy = genesis_oik_a2z_query_letter_taxonomy( "oik_letters", $args );
	do_action( "oik_a2z_display", $taxonomy, $args );
}


/**
 * Implement 'the_title' for genesis-oik
 * 
 * We want to wrap the Summary in a span tag with class="summary"
 * 
 * We cater for the fact that the following filters may be applied 
 * by implementing our filter before these.
 * `
 * : 10   wptexturize;1 convert_chars;1 trim;1 do_shortcode;1
 * : 11   capital_P_dangit;1
 * `
 * 
 * Find   | Convert to
 * ------ | ----------
 * func() - blah | func() span - blah espan 
 * this - that | this span- that espan
 *
 * 
 * Note: We don't expect both '()' and '-' in the text 
 * 	
 * @param string $text the post title being filtered
 * @param ID $id post ID 
 * @return string
 */
function genesis_oik_the_title( $text, $id ) {
	//bw_trace2();
	$pos = strpos( $text, "() " );
	if ( $pos ) {
		$text = str_replace( "() ", '() <span class="summary">', $text );
		$text .= "</span>";
	}	else {
		$pos = strpos( $text, " - " );
		if ( $pos ) {
			$text = str_replace( " - ", ' <span class="summary">- ', $text );
			$text .= "</span>";
		}
	}	
	return( $text );
} 


