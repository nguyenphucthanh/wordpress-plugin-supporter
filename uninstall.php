<?php

/**
 * 
 * This file runs when the plugin in uninstalled (deleted).
 * This will not run when the plugin is deactivated.
 * Ideally you will add all your clean-up scripts here
 * that will clean-up unused meta, options, etc. in the database.
 *
 */

// If plugin is not being uninstalled, exit (do nothing)
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

global $wpdb;

// Do something here if plugin is being uninstalled.
delete_option('supporter_enable_float');
delete_option('supporter_custom_css');

$wpdb->query( "
	DELETE FROM $wpdb->postmeta
	WHERE $wpdb->postmeta.post_id in (
		SELECT $wpdb->posts.ID
		FROM $wpdb->posts
		WHERE $wpdb->posts.post_type = 'supporter'
	)
");

$wpdb->query( "
	DELETE FROM $wpdb->posts
	WHERE $wpdb->posts.post_type = 'supporter'
");