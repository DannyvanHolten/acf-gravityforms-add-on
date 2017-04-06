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
//		add_action('acf/register_fields', [$this, 'addFieldV4']);
	}

	public function addField()
	{
		require_once(__DIR__ . 'Field.php');
	}

	public function addFieldV4()
	{
		require_once(__DIR__ . 'FieldV4.php');
	}
}