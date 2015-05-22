<?php
/*
 * Plugin Name: Supporter
 * Version: 1.0
 * Plugin URI: https://github.com/nguyenphucthanh/wordpress-plugin-supporter
 * Description: Supporter management with floating widget, support Skype, Yahoo and Telephone
 * Author: Nguyen Phuc Thanh
 * Author URI: https://github.com/nguyenphucthanh/wordpress-plugin-supporter
 * Requires at least: 4.0
 * Tested up to: 4.0
 *
 * Text Domain: supporter
 * Domain Path: /lang/
 *
 * @package WordPress
 * @author Nguyen Phuc Thanh
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

/*Add metabox*/
require_once( 'supporter-add-metabox.php' );

/*Float widget*/
require_once( 'supporter-float-widget.php' );

/*Float widget*/
require_once( 'supporter-shortcode.php' );

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
