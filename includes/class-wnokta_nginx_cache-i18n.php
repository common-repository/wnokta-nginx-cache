<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       wnokta.com/bb
 * @since      1.0.0
 *
 * @package    Wnokta_nginx_cache
 * @subpackage Wnokta_nginx_cache/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wnokta_nginx_cache
 * @subpackage Wnokta_nginx_cache/includes
 * @author     WNOKTA Bilişim Hizmetleri Ltd. şti. <wnokta.nginx.cache@wnokta.com>
 */
class Wnokta_nginx_cache_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wnokta_nginx_cache',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
