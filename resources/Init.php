<?php

namespace ACFGravityformsField;

class Init
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
		add_action('acf/include_field_types', [$this, 'addField']);
		add_action('acf/register_fields', [$this, 'addFieldforV4']);
		add_action('admin_init', [$this, 'loadTextDomain']);
		add_action('admin_notices', [$this, 'isGravityFormsActive']);
		add_action('admin_notices', [$this, 'isAdvancedCustomFieldsActive']);
	}

	/**
	 * Add a new Field object for our newest version in Advanced Custom Fields
	 */
	public function addField()
	{
		new Field();
	}

	/**
	 * Add a new Field object for other versions (V4 in this case) of Advanced Custom Fields
	 *
	 */
	public function addFieldforV4()
	{
		new FieldForV4();
	}

	/**
	 * Check if gravityforms is active. If not, issue a notice
	 */
	public function isGravityFormsActive()
	{
		if (!function_exists('gravity_form')) {
			echo '<div class="notice notice-warning"><p>
					' . __('Warning: Gravityforms needs to be activated in order to use the Advanced Custom Fields: Gravityforms Add-on.',
					'gravityforms-acf-field') . '
					</p></div>';
		}
	}


	/**
	 * Check if gravityforms is active. If not, issue a notice
	 */
	public function isAdvancedCustomFieldsActive()
	{
		if (!function_exists('get_field')) {
			echo '<div class="notice notice-warning"><p>
					' . __('Warning: Advanced Custom Fields needs to be activated in order to use the Advanced Custom Fields: Gravityforms Add-on.',
					'gravityforms-acf-field') . '
					</p></div>';
		}
	}

	/**
	 * Load the gettext plugin textdomain located in our language directory.
	 */
	public function loadTextDomain()
	{
		load_plugin_textdomain(ACF_GF_FIELD_TEXTDOMAIN, false, ACF_GF_FIELD_LANGUAGES);
	}
}