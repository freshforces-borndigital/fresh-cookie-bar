<?php
/**
 * Autoloading
 *
 * @package FreshCookieBar
 */

namespace Freshcookiebar;

defined( 'ABSPATH' ) || die( "Can't access directly" );

// setup classes.
require __DIR__ . '/class-setup.php';

// init classes.
new Setup();
