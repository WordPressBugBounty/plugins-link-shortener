<?php
/**
 * Plugin Name:     Link Shortner
 * Plugin URI:      https://wordpress.org/plugins/link-shortener/
 * Description:     Generate unique short link and share any social media.
 * Author:          Dipak Parmar
 * Contributors: 	dipakparmar443, nareshparmar827
 * Author URI:      https://profiles.wordpress.org/dipakparmar443/
 * Donate link:     https://www.paypal.me/dipakparmar443/
 * Text Domain:     link-shortener
 * Domain Path:     /languages
 * Version:         1.0
 *
 * @package         Link_Shortener
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once 'includes/class-' . basename( __FILE__ );

/**
 * Plugin textdomain.
 */
function link_shortener_textdomain() {
	load_plugin_textdomain( 'link-shortener', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'link_shortener_textdomain' );

/**
 * Plugin activation.
 */
function link_shortener_activation() {
	// Activation code here.
}
register_activation_hook( __FILE__, 'link_shortener_activation' );

/**
 * Plugin deactivation.
 */
function link_shortener_deactivation() {
	// Deactivation code here.
}
register_deactivation_hook( __FILE__, 'link_shortener_deactivation' );

/**
 * Initialization class.
 */
function link_shortener_init() {
	new Link_Shortener();
}
add_action( 'plugins_loaded', 'link_shortener_init' );
