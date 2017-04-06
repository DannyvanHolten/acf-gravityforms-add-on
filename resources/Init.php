<?php

namespace ACFGravityforms;

class Init
{

	public function __construct()
	{
		$this->addHooks();
	}

	private function addHooks()
	{
		add_action('acf/include_field_types', [$this, 'addField']);
		add_action('acf/register_fields', [$this, 'DeprecatedField']);
	}

	public function addField()
	{
		new Field();
	}

	public function addDeprecatedField()
	{
		new DeprecatedField();
	}
}