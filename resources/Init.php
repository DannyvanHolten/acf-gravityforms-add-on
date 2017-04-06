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
}