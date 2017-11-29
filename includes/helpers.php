<?php
/**
 * Function helper
 *
 * @package    Search_In_Other_Blogs
 * @since      0.9.9.1
 * @author     Kostas Krevatas
 * @copyright  Copyright (c) 2015, Kostas Krevatas
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Display list of tags for widget.
 *
 * @since  0.9.9.1
 */
function siob_tags_list() {

	// Arguments
	$args = array(
		'number' => 99
	);

	// Allow dev to filter the arguments
	$args = apply_filters( 'siob_tags_list_args', $args );

	// Get the tags
	$tags = get_terms( 'post_tag', $args );

	return $tags;
}

/**
 * Display list of categories for widget.
 *
 * @since  0.9.9.1
 */
function siob_cats_list() {

	// Arguments
	$args = array(
		'number' => 99
	);

	// Allow dev to filter the arguments
	$args = apply_filters( 'siob_cats_list_args', $args );

	// Get the cats
	$cats = get_terms( 'category', $args );

	return $cats;
}