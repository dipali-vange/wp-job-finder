<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.logicrays.com/
 * @since             1.0.0
 * @package           Wp_Job_Finder
 *
 * @wordpress-plugin
 * Plugin Name:       WP Job Finder
 * Plugin URI:        https://www.logicrays.com/
 * Description:       This plugin helps the candidate to find jobs in their desired criteria.
 * Version:           1.0.0
 * Author:            LogicRays
 * Author URI:        https://www.logicrays.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-job-finder
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
define( 'WP_JOB_FINDER_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-job-finder-activator.php
 */
function activate_wp_job_finder() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-job-finder-activator.php';
	Wp_Job_Finder_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-job-finder-deactivator.php
 */
function deactivate_wp_job_finder() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-job-finder-deactivator.php';
	Wp_Job_Finder_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_job_finder' );
register_deactivation_hook( __FILE__, 'deactivate_wp_job_finder' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-job-finder.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_job_finder() {

	$plugin = new Wp_Job_Finder();
	$plugin->run();

}
run_wp_job_finder();
