<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://yourpropfirm.com/
 * @since             1.0.0
 * @package           Sellkit_Fyfx
 *
 * @wordpress-plugin
 * Plugin Name:       Sellkit Add-on - YPF Checkout
 * Plugin URI:        https://yourpropfirm.com/
 * Description:       Plugin for Customize Sellkit Checkout Page
 * Version:           1.0.0
 * Author:            Ardika JM Consulting
 * Author URI:        https://yourpropfirm.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sellkit-fyfx
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
define( 'SELLKIT_FYFX_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sellkit-fyfx-activator.php
 */
function activate_sellkit_fyfx() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sellkit-fyfx-activator.php';
	Sellkit_Fyfx_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sellkit-fyfx-deactivator.php
 */
function deactivate_sellkit_fyfx() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sellkit-fyfx-deactivator.php';
	Sellkit_Fyfx_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_sellkit_fyfx' );
register_deactivation_hook( __FILE__, 'deactivate_sellkit_fyfx' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-sellkit-fyfx.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-sellkit-fyfx-functions.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-sellkit-fyfx-functions-frontend.php';
/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_sellkit_fyfx() {

	$plugin = new Sellkit_Fyfx();
	$plugin->run();

}
run_sellkit_fyfx();
