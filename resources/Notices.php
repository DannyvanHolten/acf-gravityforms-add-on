<?php

namespace ACFGravityformsAddOn;

class Notices
{
    public function __construct()
    {
        $this->addHooks();
    }

    /**
     * Make sure all hooks are being executed.
     */
    private function addHooks()
    {

    }

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
}
