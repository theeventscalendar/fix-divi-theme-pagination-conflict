<?php
/**
 * Plugin Name: The Events Calendar — Fix Divi Theme Pagination Conflict
 * Description: This plugin attempts to fix an issue that arises with the Divi theme and events pagination.
 * Version: 1.0.0
 * Author: Modern Tribe, Inc.
 * Author URI: http://m.tri.be/1x
 * License: GPLv2 or later
 */

defined( 'WPINC' ) or die;

function tribe_remove_divi_pre_get_posts( $query ) {
	if ( $query->tribe_is_event_query ) {
		remove_action( 'pre_get_posts', 'et_custom_posts_per_page' );
	}
}

function tribe_attempt_to_remove_divi_post_per_page_conflict() {
	add_filter( 'parse_query', 'tribe_attempt_to_remove_divi_post_per_page_conflict', 100 );
}

add_action( 'plugins_loaded', 'tribe_attempt_to_remove_divi_post_per_page_conflict', 15 );
