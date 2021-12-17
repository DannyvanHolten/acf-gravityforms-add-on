<?php

namespace ACFGravityformsField;

use acf_field;
use GFFormsModel;

class FieldForV4 extends acf_field
{
	/**
	 * will hold info such as dir / path
	 *
	 * @var $settings
	 */
	public $settings;

	/**
	 * will hold default field options
	 *
	 * @var array
	 */
	public $defaults;

	/**
	 * Make sure we can easily access our notices
	 *
	 * @var Notices
	 */
	public $notices;

	/**
	 * Get our forms
	 *
	 * @var array
	 */
	public $forms;

	public function __construct()
	{
		$this->name = 'forms';
		$this->label = __('Gravity Form', 'gravityforms');
		$this->category = __('Relational', 'acf'); // Basic, Content, Choice, etc
		$this->defaults = [
			'return_format' => 'form_object',
			'multiple'      => 0,
			'allow_null'    => 0
		];

		// Get our notices up and running
		$this->notices = new Notices();

		// Execute the parent constructor as well
		parent::__construct();
	}

	/**
	 * Create extra settings for our gravityforms field. These are visible when editing a field.
	 *
	 * @param $field
	 */
	public function create_options($field)
	{
		// defaults?
		$field = array_merge($this->defaults, $field);

		// key is needed in the field names to correctly save the data
		$key = $field['name'];

		// Create Field Options HTML
		$returnFormatChoices = [
			'post_object' => __( 'Form Object', ACF_GF_FIELD_TEXTDOMAIN ),
			'id'          => __( 'Form ID', ACF_GF_FIELD_TEXTDOMAIN ),
		];

		$this->tableRowMarkup( $this->name,
			__( 'Return Value', 'acf' ),
			$this->createAcfField( 'radio',
				'fields[' . $key . '][return_format]',
				$field['return_format'],
				$returnFormatChoices )
		);

		$choices = [
			1 => __( 'Yes', 'acf' ),
			0 => __( 'No', 'acf' ),
		];

		$this->tableRowMarkup(
			$this->name,
			__( 'Allow Null?', 'acf' ),
			$this->createAcfField( 'radio', 'fields[' . $key . '][allow_null]', $field['allow_null'], $choices )
		);

		$this->tableRowMarkup( $this->name,
			__( 'Select multiple values?', 'acf' ),
			$this->createAcfField( 'radio', 'fields[' . $key . '][multiple]', $field['multiple'], $choices )
		);
	}

    private function tableRowMarkup($optionName, $labelTitle, $renderedField)
    {
	    return sprintf( '
            <tr class="field_option field_option_%s">
                <td class="label"><label>%s</label></td>
                <td>%s</td>
            </tr>',
		    $optionName,
		    $labelTitle,
		    $renderedField
	    );
    }

	/**
	 * Render our Gravity Form field with all the forms as options
	 *
	 * @param $field
	 * @return bool
	 */
	public function create_field($field)
	{
		if (class_exists('GFFormsModel')) {
			$this->forms = GFFormsModel::get_forms();
		}

		// Set our defaults
		$field = array_merge($this->defaults, $field);
		$choices = [];

		// Check if we have some valid forms
		$fieldObject = new Field();
		if (!$fieldObject->hasValidForms()) {
			return false;
		}

		foreach ($this->forms as $form) {
			$choices[$form->id] = $form->title;
		}

		// Override field settings and start rendering
		$field['choices'] = $choices;
		$field['type'] = 'select';

		do_action('acf/create_field', $field);
	}

	/**
	 *  This filter is applied to the $value before it is updated in the db
	 *
	 *  @param  $value - the value which will be saved in the database
	 *  @param  $post_id - the $post_id of which the value will be saved
	 *  @param  $field - the field array holding all the field options
	 *
	 *  @return $value - the modified value
	 */
	public function update_value($value, $post_id, $field)
	{
		return is_array($value) ? array_values(array_filter($value)) : $value;
	}

	/**
	 * Return a form object when not empty
	 *
	 * @param $value
	 * @param $postId
	 * @param $field
	 * @return array|bool
	 */
	public function format_value_for_api($value, $postId, $field)
	{
		$fieldObject = new Field();
		return $fieldObject->processValue($value, $field);
	}

	protected function createAcfField($type, $name, $value, $choices)
	{
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
