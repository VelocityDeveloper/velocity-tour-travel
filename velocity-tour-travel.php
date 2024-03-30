<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://velocitydeveloper.com
 * @since             1.0.0
 * @package           Velocity_Tour_Travel
 *
 * @wordpress-plugin
 * Plugin Name:       Velocity Tour & Travel
 * Plugin URI:        https://velocitydeveloper.com
 * Description:       Plugin tour and travel by Velocity Developer
 * Version:           1.0.0
 * Author:            Velocity Developer
 * Author URI:        https://velocitydeveloper.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
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
 * The code that runs during plugin activation.
 * This action is documented in includes/class-velocity-tour-travel-activator.php
 */
function activate_velocity_tour_travel() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-velocity-tour-travel-activator.php';
	Velocity_Tour_Travel_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-velocity-tour-travel-deactivator.php
 */
function deactivate_velocity_tour_travel() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-velocity-tour-travel-deactivator.php';
	Velocity_Tour_Travel_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_velocity_tour_travel' );
register_deactivation_hook( __FILE__, 'deactivate_velocity_tour_travel' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-velocity-tour-travel.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_velocity_tour_travel() {

	$plugin = new Velocity_Tour_Travel();
	$plugin->run();

}
run_velocity_tour_travel();
