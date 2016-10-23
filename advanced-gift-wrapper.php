<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://profiles.wordpress.org/vishalkakadiya/
 * @since             1.0.0
 * @package           Advanced_Gift_Wrapper
 *
 * @wordpress-plugin
 * Plugin Name:       Advanced Gift Wrapper
 * Plugin URI:        http://profiles.wordpress.org/vishalkakadiya/
 * Description:       Give more comfort to your customers with advance gift wrap solution.
 * Version:           1.0.0
 * Author:            Vishal Kakadiya
 * Author URI:        http://profiles.wordpress.org/vishalkakadiya/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       advanced-gift-wrapper
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


define( 'AGW_POST_TYPE', 'product' );
define( 'AGW_POST_TAXONOMY', 'product_cat' );
define( 'AGW_POST_TERM', 'agw-gift-wrap' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-agw-activator.php
 */
function activate_advanced_gift_wrapper() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-agw-activator.php';
	AGW_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-agw-deactivator.php
 */
function deactivate_advanced_gift_wrapper() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-agw-deactivator.php';
	AGW_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_advanced_gift_wrapper' );
register_deactivation_hook( __FILE__, 'deactivate_advanced_gift_wrapper' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-advanced-gift-wrapper.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_advanced_gift_wrapper() {

	$plugin = new Advanced_Gift_Wrapper();
	$plugin->run();

}
run_advanced_gift_wrapper();
