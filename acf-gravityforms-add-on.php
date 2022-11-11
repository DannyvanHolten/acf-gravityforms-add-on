<?php
/*
 * Plugin Name: Advanced Custom Fields: Gravity Forms Add-on
 * Plugin URI: https://github.com/dannyvanholten/acf-gravityforms-add-on
 * Description: Provides an Advanced Custom Field which allows a WordPress editorial user or administrator to select a Gravity Form as part of a field group configuration.
 * Version: 1.3.5
 * Requires at least: 4.6
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Author: Say Hello GmbH
 * Author URI: http://www.sayhello.ch/
 * Copyright: Say Hello GmbH
 * Text Domain: acf-gravityforms-add-on
 * Domain Path: /languages
*/

if (!defined('ABSPATH')) {
	exit;
} // Exit if accessed directly

// Define multiple necessary constants
define('ACF_GF_FIELD_VERSION', '1.3.5');
define('ACF_GF_FIELD_LANGUAGES', dirname(plugin_basename(__FILE__)) . '/languages/');

// This remains defined just in case anyone is using it, but it is no longer used by this plugin.
define('ACF_GF_FIELD_TEXTDOMAIN', 'acf-gravityforms-add-on');

define('ACF_GF_FIELD_ASSETS', plugin_dir_url(__FILE__));
define('ACF_GF_FIELD_RESOURCES', __DIR__ . '/resources/');

// Use composer to autoload our classes
require_once __DIR__ . '/vendor/autoload.php';

// Initiate the field!
new ACFGravityformsField\Init();
