<?php
/*
Plugin Name: ACF Gravityforms Field
Plugin URI: https://github.com/dannyvanholten/gravityforms-acf-field
Description: Advanced Custom Field to select a Gravity Form
Version: 0.1
Author: Danny van Holten
Author URI: http://www.dannyvanholten.com/
Copyright: Danny van Holten
*/

if (!defined('ABSPATH')) {
	exit;
} // Exit if accessed directly

// Define multiple necessary constants
define('GF_ACF_FIELD_VERSION', 1.0);
define('GF_ACF_FIELD_TEXTDOMAIN', 'gravityforms-acf-field');
define('GF_ACF_FIELD_LANGUAGES', dirname(plugin_basename(__FILE__)) . '/languages/');

define('GF_ACF_FIELD_ASSETS', plugin_dir_url(__FILE__));
define('GF_ACF_FIELD_RESOURCES', __DIR__ . '/resources/');

// Use composer to autoload our classes
require_once __DIR__ . '/vendor/autoload.php';

// Initiate the field!
new ACFGravityforms/Init();


////Added to check if Gravity Forms is installed on activation.
//function gff_activate() {
//
//    if (class_exists('RGFormsModel')) {
//
//			return true;
//
//		}	else {
//
//			$html = '<div class="notice notice-error">';
//				$html .= '<p>';
//					$html .= __( 'Warning: Gravity Forms is not installed or activated. This plugin does not function without Gravity Forms!', 'gravityforms-acf-field' );
//				$html .= '</p>';
//			$html .= '</div>';
//			echo $html;
//
//		}
//}
//register_activation_hook( __FILE__, 'gff_activate' );