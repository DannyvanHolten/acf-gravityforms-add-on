<?php

namespace ACFGravityformsField;

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
        add_action('admin_notices', [$this, 'isGravityFormsActive']);
        add_action('admin_notices', [$this, 'isAdvancedCustomFieldsActive']);
    }

    /**
     * Check if gravityforms is active. If not, issue a notice
     */
    public function isGravityFormsActive()
    {
        if (!function_exists('gravity_form')) {
            echo '<div class="notice notice-warning"><p>'
                . __('Warning: Gravityforms needs to be activated in order to use the Advanced Custom Fields: Gravityforms Add-on.',
                    'gravityforms-acf-field') .
                '</p></div>';
        }
    }

    /**
     * Check if gravityforms is active. If not, issue a notice
     */
    public function isAdvancedCustomFieldsActive()
    {
        if (!function_exists('get_field')) {
            echo '<div class="notice notice-warning"><p>'
                . __('Warning: Advanced Custom Fields needs to be activated in order to use the Advanced Custom Fields: Gravityforms Add-on.',
                    'gravityforms-acf-field') .
                '</p></div>';
        }
    }
}
