<?php

namespace ACFGravityformsField;

use GFFormsModel;

class Notices
{
	/**
	 * Get our forms
	 *
	 * @var array
	 */
	public $forms;

	/**
	 * Make sure all hooks are being executed.
	 */
	public function addHooks()
	{
		add_action('admin_notices', [$this, 'isGravityFormsActive']);
		add_action('admin_notices', [$this, 'isAdvancedCustomFieldsActive']);
	}

	/**
	 * Check if gravityforms is active. If not, issue a notice
	 */
	public function isGravityFormsActive($inline = '', $alt = '')
	{
		if (!class_exists('GFAPI')) {
			$notice = sprintf(__(
				'Warning: You need to <a href="%s">Activate Gravityforms</a> in order to use the Advanced Custom Fields: Gravityforms Add-on.',
				ACF_GF_FIELD_TEXTDOMAIN
			), admin_url('plugins.php'));

			$this->createNotice($notice, $inline, $alt);
		}
	}

	/**
	 * Check if there are any active gravityforms forms. If not, issue a notice
	 */
	public function hasActiveGravityForms($inline = '', $alt = '')
	{

		if (class_exists('GFFormsModel')) {
			$this->forms = GFFormsModel::get_forms(true, false, 'title');
		}

		if (!$this->forms) {
			$notice = sprintf(__(
				' Warning: There are no active forms. You need to <a href="%s">Create a New Form</a> in order to use the Advanced Custom Fields: Gravityforms Add-on.',
				ACF_GF_FIELD_TEXTDOMAIN
			), admin_url('admin.php?page=gf_new_form'));

			$this->createNotice($notice, $inline, $alt);
		}
	}

	/**
	 * Check if advanced custom fields is active. If not, issue a notice
	 */
	public function isAdvancedCustomFieldsActive($inline = '', $alt = '')
	{
		if (!function_exists('get_field')) {
			$notice = sprintf(__(
				'Warning: You need to <a href="%s">Activate Advanced Custom Fields</a> in order to use the Advanced Custom Fields: Gravityforms Add-on.',
				ACF_GF_FIELD_TEXTDOMAIN
			), admin_url('plugins.php'));

			$this->createNotice($notice, $inline, $alt);
		}
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
