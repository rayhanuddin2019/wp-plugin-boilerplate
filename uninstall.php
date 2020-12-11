<?php
/**
 * wp-plugin-boilerplate Uninstall
 *
 * Uninstalling wp-plugin-boilerplate deletes user roles, pages, tables, and options.
 *
 * @package wp-plugin-boilerplate\Uninstaller
 * @version 1.0
 */

defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

global $wpdb, $wp_version;

wp_clear_scheduled_hook( 'prefix_scheduled_sales' );


/*
 * Only remove options and page data if this plugin constant is set to true in user's
 * wp-config.php. This is to prevent data loss when deleting the plugin from the backend
 * and to ensure only the site owner can perform this action.
 */
if ( defined( 'PREFIX_REMOVE_ALL_DATA' ) && true === PREFIX_REMOVE_ALL_DATA ){ 

	// Pages.
	wp_trash_post( get_option( 'wp_plugin_boilarplat_page_id' ) );

	// Delete options.
	$wpdb->query( "DELETE FROM $wpdb->options WHERE option_name LIKE 'wp_plugin_boilarplate\_%';" );
	$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}wp_plugin_boilarplate_items" );

	// Clear any cached data that has been removed.
	wp_cache_flush();
}
