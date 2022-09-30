<?php
/**
 *
 * @wordpress-plugin
 * Plugin Name:       CAHNRS News 
 * Plugin URI:        https://cahnrs.wsu.edu/
 * Description:       Creates Gutenberg Blocks and Post Types for News Website 
 * Version:           1.0.0
 * Author:            CAHNRS Communications
 * Author URI:        https://cahnrs.wsu.edu/
 * Text Domain:       cahnrs-news-plugin
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

function cahnrs_news_init(){
	require_once __DIR__ . '/includes/plugin.php';
}

add_action( 'after_setup_theme', 'cahnrs_news_init' );


// Gets the plugin's URL.
function _get_plugin_url() {
  static $plugin_url;

  if (empty($plugin_url)) {
    $plugin_url = plugins_url(null, __FILE__);
  }

  return $plugin_url;
}