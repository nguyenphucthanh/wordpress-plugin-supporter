<?php
/*
 * Plugin Name: Supporter
 * Version: 1.0
 * Plugin URI: http://www.hughlashbrooke.com/
 * Description: This is your starter template for your next WordPress plugin.
 * Author: Hugh Lashbrooke
 * Author URI: http://www.hughlashbrooke.com/
 * Requires at least: 4.0
 * Tested up to: 4.0
 *
 * Text Domain: supporter
 * Domain Path: /lang/
 *
 * @package WordPress
 * @author Hugh Lashbrooke
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Load plugin class files
require_once( 'includes/class-supporter.php' );
require_once( 'includes/class-supporter-settings.php' );

// Load plugin libraries
require_once( 'includes/lib/class-supporter-admin-api.php' );
require_once( 'includes/lib/class-supporter-post-type.php' );
require_once( 'includes/lib/class-supporter-taxonomy.php' );

/**
 * Returns the main instance of Supporter to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object Supporter
 */
function Supporter () {
	$instance = Supporter::instance( __FILE__, '1.0.0' );

	if ( is_null( $instance->settings ) ) {
		$instance->settings = Supporter_Settings::instance( $instance );
	}

	return $instance;
}

$supporter = Supporter();

$supporter->register_post_type( 'supporter', __( 'Supporters', 'supporter' ), __( 'Supporter', 'supporter' ) );

/*Add metabox*/
require_once( 'supporter-add-metabox.php' );

/*Float widget*/
require_once( 'supporter-float-widget.php' );