<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://velocitydeveloper.com/
 * @since             1.0.0
 * @package           Velocity_Tour_Travel
 *
 * @wordpress-plugin
 * Plugin Name:       Velocity Tour & Travel
 * Plugin URI:        https://velocitydeveloper.com/
 * Description:       Plugin tour and travel by Velocity Developer
 * Version:           1.0.0
 * Author:            Velocity Developer
 * Author URI:        https://velocitydeveloper.com/
 * License:           GPL-3.0+
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       velocity-tour-travel
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'VELOCITY_TOUR_TRAVEL_VERSION', '1.0.0' );


/**
 * Define constants
 *
 * @since 1.2.0
 */
if (!defined('VELOCITY_TOUR_TRAVEL_DIR'))	define('VELOCITY_TOUR_TRAVEL_DIR', plugin_dir_path(__FILE__)); // Plugin directory absolute path with the trailing slash. Useful for using with includes eg - /var/www/html/wp-content/plugins/velocity-tour-travel/
if (!defined('VELOCITY_TOUR_TRAVEL_DIR_URI'))	define('VELOCITY_TOUR_TRAVEL_DIR_URI', plugin_dir_url(__FILE__)); // URL to the plugin folder with the trailing slash. Useful for referencing src eg - http://localhost/wp-content/plugins/velocity-tour-travel


/// Load everything
$includes = [
	'includes/lib/cmb2/init.php', // load cmb2
	'includes/meta-box.php', // load meta-box 
	'includes/functions.php', // load functions
	'includes/shortcodes/paket-slideshow.php',
	'includes/shortcodes/paket-adventure-level.php',
];
foreach ($includes as $include) {
	require_once(VELOCITY_TOUR_TRAVEL_DIR.$include);
}


// Add custom scripts and styles
function velocity_tour_scripts() {

	// Get the version.
	$the_version = VELOCITY_TOUR_TRAVEL_VERSION;
	if (defined('WP_DEBUG') && true === WP_DEBUG) {
		$the_version = $the_version.'.'.time();
	}

	$wptheme = wp_get_theme( 'velocity' );	
	if (!$wptheme->exists()) {
		wp_enqueue_style( 'vtt-bootstrap-style', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css');
		wp_enqueue_script( 'vtt-bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js', array(), null, true );
	}

	wp_enqueue_script('slick', VELOCITY_TOUR_TRAVEL_DIR_URI . 'assets/js/slick.min.js', array(), $the_version, true);

	wp_enqueue_style('slick', VELOCITY_TOUR_TRAVEL_DIR_URI . 'assets/css/slick.min.css', array(), $the_version, false);
	wp_enqueue_style('slick-theme', VELOCITY_TOUR_TRAVEL_DIR_URI . 'assets/css/slick-theme.min.css', array(), $the_version, false);
	wp_enqueue_style( 'vtt-custom-style', VELOCITY_TOUR_TRAVEL_DIR_URI.'assets/css/custom.css', array(), $the_version, false);
}
add_action( 'wp_enqueue_scripts', 'velocity_tour_scripts' );