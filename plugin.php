<?php
/**
 * Plugin Name: The Events Calendar Extension: Fix Divi Theme Pagination Conflict
 * Description: This plugin attempts to fix an issue that arises with the Divi theme and events pagination.
 * Version: 1.0.0
 * Author: Modern Tribe, Inc.
 * Author URI: http://m.tri.be/1971
 * License: GPLv2 or later
 */

defined( 'WPINC' ) or die;

class Tribe__Extension__Fix_Divi_Theme_Pagination_Conflict {

    /**
     * The semantic version number of this extension; should always match the plugin header.
     */
    const VERSION = '1.0.0';

    /**
     * Each plugin required by this extension
     *
     * @var array Plugins are listed in 'main class' => 'minimum version #' format
     */
    public $plugins_required = array(
        'Tribe__Events__Main' => '4.2'
    );

    /**
     * The constructor; delays initializing the extension until all other plugins are loaded.
     */
    public function __construct() {
        add_action( 'plugins_loaded', array( $this, 'init' ), 100 );
    }

    /**
     * Extension hooks and initialization; exits if the extension is not authorized by Tribe Common to run.
     */
    public function init() {

        // Exit early if our framework is saying this extension should not run.
        if ( ! function_exists( 'tribe_register_plugin' ) || ! tribe_register_plugin( __FILE__, __CLASS__, self::VERSION, $this->plugins_required ) ) {
            return;
        }

        add_action( 'plugins_loaded', array( $this, 'attempt_to_remove_divi_post_per_page_conflict' ), 15 );
    }

    public function attempt_to_remove_divi_post_per_page_conflict() {
        add_filter( 'parse_query', array( $this, 'remove_divi_pre_get_posts' ), 100 );
    }

    public function remove_divi_pre_get_posts( $query ) {
        if ( $query->tribe_is_event_query ) {
            remove_action( 'pre_get_posts', 'et_custom_posts_per_page' );
        }
    }
}

new Tribe__Extension__Fix_Divi_Theme_Pagination_Conflict();
