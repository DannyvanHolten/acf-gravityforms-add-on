<?php

namespace ACFGravityformsField;

use GFAPI;

class Notices
{
    /**
     * Get our forms
     *
     * @var array
     */
    public $forms;

    /**
     * Acces utility methods
     *
     * @var Utils
     */
    public $utils;

    public function __construct()
    {
        if (class_exists('GFAPI')) {
            $this->forms = GFAPI::get_forms();
        }

        $this->utils = new Utils();
    }

    /**
     * Make sure all hooks are being executed.
     */
    public function addHooks()
    {
        add_action('admin_notices', [$this, 'isGravityFormsActive']);
        add_action('admin_notices', [$this, 'isAdvancedCustomFieldsActive']);
    }

    /**
     * Check if gravityforms is installled and active. If not, issue an activation or installation notice
     */
    public function isGravityFormsActive($inline = '', $alt = '')
    {
        $notice = "";

        if ($this->utils->isPluginInstalled("Gravity Forms")) {
            if (!class_exists('GFAPI')) {
                $activateUrl = $this->utils->generatePluginActivationLinkUrl('gravityforms/gravityforms.php');

                $notice = sprintf(__('Warning: You need to <a href="%s">Activate Gravityforms</a> in order to use the Advanced Custom Fields: Gravityforms Add-on.',
                    ACF_GF_FIELD_TEXTDOMAIN), $activateUrl);
            }
        } else {
            $notice = sprintf(__('Warning: You need to <a href="%s" target="_blank">Install Gravityforms</a> in order to use the Advanced Custom Fields: Gravityforms Add-on.',
                ACF_GF_FIELD_TEXTDOMAIN), 'http://www.gravityforms.com');
        }
        
        if ($notice) $this->createNotice($notice, $inline, $alt);
    }

    /**
     * Check if there are any active gravityforms forms. If not, issue a notice
     */
    public function hasActiveGravityForms($inline = '', $alt = '')
    {
        if (!$this->forms) {
            $notice = sprintf(__(' Warning: There are no active forms. You need to <a href="%s">Create a New Form</a> in order to use the Advanced Custom Fields: Gravityforms Add-on.',
                ACF_GF_FIELD_TEXTDOMAIN), admin_url('admin.php?page=gf_new_form'));

            $this->createNotice($notice, $inline, $alt);
        }
    }

    /**
     * Check if advanced custom fields is installed and active. If not, issue an activation or installation notice
     */
    public function isAdvancedCustomFieldsActive($inline = '', $alt = '')
    {
        $notice = "";

        if ($this->utils->isPluginInstalled("Advanced Custom Fields")) {
            if (!class_exists('acf')) {
                $activateUrl = $this->utils->generatePluginActivationLinkUrl('advanced-custom-fields/acf.php');

                $notice = sprintf(__('Warning: You need to <a href="%s">Activate Advanced Custom Fields</a> in order to use the Advanced Custom Fields: Gravityforms Add-on.',
                    ACF_GF_FIELD_TEXTDOMAIN), $activateUrl);
            }
        } else {
            $installUrl = $this->utils->generatePluginInstallLinkUrl('advanced-custom-fields');

            $notice = sprintf(__('Warning: You need to <a href="%s">Install Advanced Custom Fields</a> in order to use the Advanced Custom Fields: Gravityforms Add-on.',
                ACF_GF_FIELD_TEXTDOMAIN), $installUrl);
        }

        if ($notice) $this->createNotice($notice, $inline, $alt);
    }

    /**
     * A wrapper for all the notices.
     */
    public function createNotice($notice, $inline = '', $alt = '')
    {
        $inline = $inline ? ' inline' : '';
        $alt = $alt ? ' notice-alt' : '';

        echo '<div class="notice notice-warning ' . $inline . $alt . '"><p>' . $notice . '</p></div>';
    }
}
