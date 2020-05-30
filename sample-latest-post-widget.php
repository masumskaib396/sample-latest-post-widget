<?php 
/*
Plugin Name: Sample Latest Post widget
Plugin URI: https://github.com/masumskaib396/sample-latest-post-widget
Description: This Plugin Is Sample Latest Post Widget
Version: 1.0.0
Author: msakib
Author URI: https://profiles.wordpress.org/msakib/
License: GPLv2 or later
Text Domain: srpw
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//Set plugin version constant.
define( 'SRPW_VERSION', '1.0.0');

// Plugin Addons Folder Path
define( 'SRPW_WIDGET_DIR', plugin_dir_path( __FILE__ ) . 'widget/' );

// Assets Folder URL
define( 'SRPW_ASSETS_PUBLIC', plugins_url( 'assets', __FILE__ ) );


require_once(SRPW_WIDGET_DIR. 'related-post.php' );

function srpw_scripts(){
    wp_enqueue_style( 'srpw-style', SRPW_ASSETS_PUBLIC . '/css/style.css', SRPW_VERSION );
}
add_action('wp_enqueue_scripts', 'srpw_scripts');
