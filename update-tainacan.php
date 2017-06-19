<?php

/**
 *
 * @link              https://github.com/medialab-ufg/plugin-update-tainacan
 * @since             1.0.0
 * @package           update-tainacan
 *
 * @wordpress-plugin
 * Plugin Name:       Update Tainacan
 * Plugin URI:        https://github.com/medialab-ufg/plugin-update-tainacan
 * Description:       Atualização do tema Tainacan e seus plugins
 * Version:           1.0.0
 * Author:            Marcus Molinari
 * Author URI:        https://github.com/medialab-ufg/plugin-update-tainacan
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       update-tainacan
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-update-tainacan-activator.php
 */
function activate_update_tainacan() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-update-tainacan-activator.php';
	Update_Tainacan_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-update-tainacan-deactivator.php
 */
function deactivate_update_tainacan() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-update-tainacan-deactivator.php';
	Update_Tainacan_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_update_tainacan' );
register_deactivation_hook( __FILE__, 'deactivate_update_tainacan' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-update-tainacan.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_plugin_name() {

	$plugin = new Update_Tainacan();
	$plugin->run();

}
run_plugin_name();
