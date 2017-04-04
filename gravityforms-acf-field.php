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

// $version = 5 and can be ignored until ACF6 exists
function include_field_types_Gravity_Forms( $version ) {

  include_once('gravity_forms-v5.php');

}

add_action('acf/include_field_types', 'include_field_types_gravity_forms'); 


function register_fields_Gravity_Forms() {
  include_once('gravity_forms-v4.php');
}

add_action('acf/register_fields', 'register_fields_gravity_forms');

//Added to check if Gravity Forms is installed on activation.
function gff_activate() {

    if (class_exists('RGFormsModel')) {
			
			return true;
			
		}	else {
			
			$html = '<div class="error">';
				$html .= '<p>';
					$html .= _e( 'Warning: Gravity Forms is not installed or activated. This plugin does not function without Gravity Forms!' );
				$html .= '</p>';
			$html .= '</div>';
			echo $html;
			
		}
}
register_activation_hook( __FILE__, 'gff_activate' );
?>