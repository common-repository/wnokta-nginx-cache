<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              wnokta.com/bb
 * @since             1.0.0
 * @package           Wnokta_nginx_cache
 *
 * @wordpress-plugin
 * Plugin Name:       wnokta nginx cache
 * Plugin URI:        wnokta.com/bb
 * Description:       WNOKTA Tarafından geliştirilen önbellek eklentisi, bu basit bir eklenti değildir, özel olarak wnokta sunucularında barınan siteler için hazırlanmıştır. Muadillerine göre 10 kata kadar sitenizi hızlandırır. Tamamen ücretsizdir.
 * Version:           1.0.0
 * Author:            WNOKTA Bilişim Hizmetleri Ltd. şti.
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wnokta_nginx_cache
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
define( 'WNOKTA_NGINX_CACHE_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wnokta_nginx_cache-activator.php
 */
function activate_wnokta_nginx_cache() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wnokta_nginx_cache-activator.php';
	Wnokta_nginx_cache_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wnokta_nginx_cache-deactivator.php
 */
function deactivate_wnokta_nginx_cache() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wnokta_nginx_cache-deactivator.php';
	Wnokta_nginx_cache_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wnokta_nginx_cache' );
register_deactivation_hook( __FILE__, 'deactivate_wnokta_nginx_cache' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wnokta_nginx_cache.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wnokta_nginx_cache() {

	$plugin = new Wnokta_nginx_cache();
	$plugin->run();

}
run_wnokta_nginx_cache();
