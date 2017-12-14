<?php

/**
 * Plugin Name:       CNR Mobilogy Widgets
 * Version:           1.0.0
 * Author:            Code n' Roll
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       cnr
 * Domain Path:       /lang/
 */


define( 'VC_CUSTOM_ELEMENTS_DIR', plugin_dir_url( __FILE__ ) );

if( ! defined( 'THEME_TEXT_DOMAIN' ) ){
	define( 'THEME_TEXT_DOMAIN', 'cnr' );
}

add_action( 'vc_before_init', 'cnr_vc_before_init_actions' );

function cnr_vc_before_init_actions() {

	// Require new custom Element
	require_once 'squared-menu.php';
	require_once 'quick-topics.php';
	require_once 'video-tutorials.php';

}
