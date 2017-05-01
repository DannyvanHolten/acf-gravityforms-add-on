<?php

namespace ACFGravityformsField;

use GFAPI;

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
    public function isGravityFormsActive($inline = false, $alt = false)
    {
        if (!class_exists('GFAPI')) {
            // @todo: actually get the activation hook going with ajax
            $notice = sprintf(__('Warning: You need to <a href="%s">Activate Gravityforms</a> in order to use the Advanced Custom Fields: Gravityforms Add-on.',
                ACF_GF_FIELD_TEXTDOMAIN), admin_url('admin.php?page=gf_new_form'));

            $this->createNotice($notice, $inline, $alt);
        }
    }

    public function hasActiveGravityForms($inline = false, $alt = false)
    {
        $forms = GFAPI::get_forms();
        if (empty($forms)) {
            $notice = sprintf(__(' Warning: There are no active forms. You need to <a href="%s">Create a New Form</a> in order to use the Advanced Custom Fields: Gravityforms Add-on.',
                ACF_GF_FIELD_TEXTDOMAIN), admin_url('admin.php?page=gf_new_form'));

            $this->createNotice($notice, $inline, $alt);
        }
    }

    /**
     * Check if gravityforms is active. If not, issue a notice
     */
    public function isAdvancedCustomFieldsActive($inline = false, $alt = false)
    {
        if (!function_exists('get_field')) {
            // @todo: actually get the activation hook going with ajax
            $notice = __('Warning: Advanced Custom Fields needs to be activated in order to use the Advanced Custom Fields: Gravityforms Add-on.',
                ACF_GF_FIELD_TEXTDOMAIN);

            $this->createNotice($notice, $inline, $alt);
        }
    }

    /**
     * A wrapper for all the notices.
     */
    public function createNotice($notice, $inline = false, $alt = false)
    {
        $inline = $inline ? ' inline' : '';
        $alt = $alt ? ' notice-alt' : '';

        echo '<div class="notice notice-warning ' . $inline . $alt . '"><p>' . $notice . '</p></div>';
    }
}
