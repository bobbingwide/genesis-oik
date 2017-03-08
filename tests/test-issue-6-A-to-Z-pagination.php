<?php // (C) Copyright Bobbing Wide 2017

/**
 * Tests that A to Z pagination has been implemented as required.
 * 
 * So first we need to know what the requirement was, then confirm that it's been implemented. 
 * 
 * 
 * 
 * The full table is for: oik-plugins.co.uk / oik-plugins.com
 * bobbingwidewebdesign.com ( with the bwdesign thugin ) only populates a subset of the post types
 * 
 * post_type       | letter taxonomy | display on archive? | same on bwdesign?
 * --------------- | --------------- | ------------------- | -----------------
 * post            |	letters	       | y									 | y
 * page            |	letters	       | y 									 | y
 * oik-plugins     |	letters	       | y 									 | y
 * oik_shortcodes  |	letters        | y									 | y
 * oik-themes      |	letters        | y 									 | y
 * oik-faq         |	letters        | y									 | n/a
 * oik_shortcodes    |	oik_letters  | y									 | uses "letters"
 * oik_sc_param      |	oik_letters  | y									 | n/a
 * shortcode_example |	oik_letters  | y									 | n/a
 * oik_file          |	oik_letters  | y									 | n/a
 * oik_class         |	oik_letters  | y									 | n/a
 * oik_hook          |	oik_letters  | y									 | n/a
 * oik_api           |	oik_letters  | y 									 | n/a
 * 							  																				 
 * 
 
 * We can use oik-a2z to list the post_type / letter taxonomy associations
 * ... the admin interface has a Defined taxonomies display
 * 
 * Then we need to check that the correct taxonomy is being displayed on the archive pages.
 * 
 * - Can we do this by displaying the templates one by one?
 * - Will this work for those templates which re-use function names?
 * - That'll be a good test won't it!
 * 
 */
 
class tests_issue_6_a_to_z_pagination extends BW_UnitTestCase {

	function test_post_type_archive_contains_letter_taxonomy() {
	
	
	}



}

 
