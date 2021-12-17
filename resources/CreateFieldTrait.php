<?php

namespace ACFGravityformsField;

trait CreateFieldTrait {
	protected function createAcfField($type, $name, $value, $choices) {
		do_action(
			'acf/create_field',
			[
				'type'    => $type,
				'name'    => $name,
				'value'   => $value,
				'choices' => $choices,
				'layout'  => 'horizontal',
			]
		);
	}
}
