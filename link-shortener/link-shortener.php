<?php
/**
 * Plugin Name:     Link Shortner
 * Plugin URI:      https://wordpress.org/plugins/link-shortener/
 * Description:     Generate unique short link and share any social media.
 * Author:          Dipakkumar Parmar
 * Contributors: 	dipakparmar443, nareshparmar827
 * Author URI:      https://profiles.wordpress.org/dipakparmar443/
 * Donate link:     https://www.paypal.me/dipakparmar443/
 * Text Domain:     link-shortener
 * License:         GPL-2.0-or-later
 * License URI:     https://www.gnu.org/licenses/gpl-2.0.html 
 * Domain Path:     /languages
 * Version:         1.1
 *
 * @package         Link_Shortener
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once 'includes/class-' . basename( __FILE__ );

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