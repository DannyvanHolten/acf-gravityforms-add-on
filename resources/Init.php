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
		add_action('admin_init', [$this, 'addNotices']);
	}

	/**
	 * Initialize the notices
	 */
	public function addNotices()
	{
		$notices = new Notices();
		$notices->addHooks();
	}

	/**
	 * Add a new Field object for our newest version in Advanced Custom Fields
	 */
	public function addField()
	{
		$field = new Field();

		// Added 31.3.2022 to avoid errors when using “show in REST”
		// https://wordpress.org/support/topic/fatal-error-when-show-in-rest-is-active/
		if (function_exists('acf_register_field_type')) {
			acf_register_field_type($field);
		}
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
	 * Load the gettext plugin textdomain located in our language directory.
	 */
	public function loadTextDomain()
	{
		load_plugin_textdomain(ACF_GF_FIELD_TEXTDOMAIN, false, ACF_GF_FIELD_LANGUAGES);
	}
}
