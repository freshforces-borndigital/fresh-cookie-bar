<?php
/**
 * Plugin Name: Fresh Cookie Bar
 * Plugin URI:  https://github.com/freshforces-borndigital/freshcookiebar
 * Description: Cookie consent bar for GDPR compliant website.
 * Version:     0.1.0
 * Author:      Fresh Forces - Born Digital
 * Author URI:  https://fresh-forces.com/
 * License:     GPL-3.0 License
 * License URI: https://oss.ninja/gpl-3.0?organization=Fresh-Forces
 * Text Domain: freshcookiebar
 *
 * @package FreshCookieBar
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

load_plugin_textdomain( 'freshcookiebar', false, basename( dirname( __FILE__ ) ) . '/languages' );

// identities constants.
define( 'FRESHCOOKIEBAR_PLUGIN_VERSION', '0.1.0' );
define( 'FRESHCOOKIEBAR_PLUGIN_URL', rtrim( plugin_dir_url( __FILE__ ), '/' ) );
define( 'FRESHCOOKIEBAR_PLUGIN_DIR', rtrim( plugin_dir_path( __FILE__ ), '/' ) );

// libraries using composer.
require_once FRESHCOOKIEBAR_PLUGIN_DIR . '/vendor/autoload.php';

require_once FRESHCOOKIEBAR_PLUGIN_DIR . '/autoload.php';
