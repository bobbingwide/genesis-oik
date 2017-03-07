<?php // (C) Copyright Bobbing Wide 2017

/**
 * Confirm that wp_custom_css_cb is not registered as a filter function for wp_head
 *
 * 
 * OR can we confirm that all the functions have a genesis_oik_ or goik_ prefix?
 */
class Tests_issue_5_disable_wp_custom_css extends BW_UnitTestCase {

	/**
	 * Tests that 'wp_custom_css_cb' is no longer registered to 'wp_head'
	 * 
	 * Regardless of the priority.
	 * 
	 * In the first implementation of this test the function name was wrong, so it passed invalidly. 
	 * Now we check the function is defined, belt and braces.
	 *
	 */
	function test_wp_custom_css_cb_not_attached_to_wp_head_action() {
		$function = "wp_custom_css_cb";
		$exists = function_exists( $function  );
		$this->assertTrue( $exists );
		$has_filter = has_filter( "wp_head", $function );
		$this->assertFalse( $has_filter );
	}
	
}	
	
