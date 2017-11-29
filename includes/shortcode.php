<?php
/**
 * Shortcode helper
 *
 * @package    Search_In_Other_Blogs
 * @since      0.9.4
 * @author     Kostas Krevatas
 * @copyright  Copyright (c) 2017, Kostas Krevatas
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Display recent posts with shortcode.
 *
 * @since  0.9.4
 */
function siob_shortcode( $atts, $content ) {
	if ( isset( $atts['cssid'] ) ) {
		$atts['cssID'] = $atts['cssid'];
		unset( $atts['cssid'] );
	}
	$args = shortcode_atts( siob_get_default_args(), $atts );
	return siob_get_recent_posts( $args );
}
add_shortcode( 'siob', 'siob_shortcode' );
