<?php // (C) Copyright Bobbing Wide 2017


/**
 * Confirm that wp_custom_css_cb is not registered as a filter function for wp_head
 *
 * 
 * OR can we confirm that all the functions have a genesis_oik_ or goik_ prefix?
 */
class Tests_issue_5_disable_wp_custom_css extends BW_UnitTestCase {

	/**
	 * 
	 * Finds the name of the functions.php file
	 * `C:\apache\htdocs\wordpress\wp-content\themes\genesis-oik/functions.php`
	 * with \ converted to /
	 */
	function test_wp_custom_css_cb_not_attached_to_wp_head_action() {
	
		$has_filter = has_filter( "wp_head", "wp_customcsss_cb" );
		$this->assertFalse( $has_filter );
	}
	
}	
	
