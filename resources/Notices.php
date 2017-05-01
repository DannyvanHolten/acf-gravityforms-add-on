<?php

namespace ACFGravityformsAddOn;

use GFAPI;

class Notices
{
    /**
     * Check if gravityforms is active. If not, issue a notice
     */
    public static function isGravityFormsActive($inline = false, $alt = false)
    {
        if (!function_exists('gravity_form')) {
            echo '<div class="notice notice-warning ' . $inline ? 'notice-inline' : '' . '"><p>'
                . __('Warning: Gravityforms needs to be activated in order to use the Advanced Custom Fields: Gravityforms Add-on.',
                    'gravityforms-acf-field') .
                '</p></div>';
        }
    }

    /**
     * Check if gravityforms is active. If not, issue a notice
     */
    public static function isAdvancedCustomFieldsActive()
    {
        if (!function_exists('get_field')) {
            echo '<div class="notice notice-warning"><p>'
                . __('Warning: Advanced Custom Fields needs to be activated in order to use the Advanced Custom Fields: Gravityforms Add-on.',
                    'gravityforms-acf-field') .
                '</p></div>';
        }
    }

    /**
     * Check if gravityforms is active. If not, issue a notice
     */
    public static function hasActiveGravityForm($inline = false, $alt = false)
    {
        if (!GFAPI::get_forms()) {
            echo '<div class="notice notice-warning ' . $inline ? 'notice-inline' : '' . '"><p>'
                . __('Warning: Gravityform has no active forms. You need to create or activate a form in order to use the Advanced Custom Fields: Gravityforms Add-on.',
                    'gravityforms-acf-field') .
                '</p></div>';
        }
    }
}
