<?php

namespace ACFGravityformsField;

use acf_field;
use GFAPI;

class Field extends acf_field
{
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
		$this->label = __('Forms', 'gravityforms');
		$this->category = __('Relational', 'acf');
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
	public function render_field_settings($field)
	{
		// Render a field settings that will tell us if an empty field is allowed or not
		acf_render_field_setting($field, [
			'label'        => __('Return Value', 'acf'),
			'instructions' => __('Specify the returned value on front end', 'acf'),
			'type'         => 'radio',
			'name'         => 'return_format',
			'layout'       => 'horizontal',
			'choices'      => [
				'post_object' => __('Form Object', ACF_GF_FIELD_TEXTDOMAIN),
				'id'          => __('Form ID', ACF_GF_FIELD_TEXTDOMAIN)
			],
		]);

		// Render a field setting that will tell us if an empty field is allowed or not.
		acf_render_field_setting($field, [
			'label'   => __('Allow Null?', 'acf'),
			'type'    => 'radio',
			'name'    => 'allow_null',
			'choices' => [
				1 => __('Yes', 'acf'),
				0 => __('No', 'acf'),
			],
			'layout'  => 'horizontal'
		]);

		// Render a field setting that will tell us if multiple forms are allowed.
		acf_render_field_setting($field, [
			'label'   => __('Select multiple values?', 'acf'),
			'type'    => 'radio',
			'name'    => 'multiple',
			'choices' => [
				1 => __('Yes', 'acf'),
				0 => __('No', 'acf'),
			],
			'layout'  => 'horizontal'
		]);
	}

	/**
	 * Render our Gravity Form field with all the forms as options
	 *
	 * @param $field
	 * @return bool
	 */
	public function render_field($field)
	{

		if (class_exists('GFAPI')) {
			$this->forms = GFAPI::get_forms();
		}

		// Set our defaults
		$field = array_merge($this->defaults, $field);
		$choices = [];

		// Check if we have some valid forms
		if (!$this->hasValidForms()) {
			return false;
		}

		foreach ($this->forms as $form) {
			$choices[$form['id']] = $form['title'];
		}

		// Override field settings and start rendering
		$field['choices'] = $choices;
		$field['type'] = 'select';
		// Create a css id for our field
		$fieldId = str_replace(['[', ']'], ['-', ''], $field['name']);

		// Check if we're allowing multiple selections.
		$hiddenField = '';
		$multiple = '';
		$fieldOptions = '';

		if ($field['multiple']) {
			$hiddenField = '<input type="hidden" name="{$field[\'name\']}">';
			$multiple = '[]" multiple="multiple" data-multiple="1';
		}

		// Check if we're allowing an empty form. If so, create a default option
		if ($field['allow_null']) {
			$fieldOptions .= '<option value="">' . __('- Select a form -', ACF_GF_FIELD_TEXTDOMAIN) . '</option>';
		}

		// Loop trough all our choices
		foreach ($field['choices'] as $formId => $formTitle) {
			$selected = '';

			if ((is_array($field['value']) && in_array($formId, $field['value'], false))
				|| (int)$field['value'] === (int)$formId
			) {
				$selected = ' selected';
			}

			$fieldOptions .= '<option value="' . $formId . '"' . $selected . '>' . $formTitle . '</option>';
		}

		// Start building the html for our field
		$fieldHhtml = $hiddenField;
		$fieldHhtml .= '<select id="' . $fieldId . '" name="' . $field['name'] . $multiple . '">';
		$fieldHhtml .= $fieldOptions;
		$fieldHhtml .= '</select>';

		echo $fieldHhtml;
	}

	/**
	 * Return a form object when not empty
	 *
	 * @param $value
	 * @param $postId
	 * @param $field
	 * @return array|bool
	 */
	public function format_value($value, $postId, $field)
	{
		return $this->processValue($value, $field);
	}

	/**
	 *
	 *  This filter is applied to the $value before it is updated in the db
	 *
	 * @param  $value - the value which will be saved in the database
	 * @param  $post_id - the $post_id of which the value will be saved
	 * @param  $field - the field array holding all the field options
	 *
	 * @return $value - the modified value
	 */
	public function update_value($value)
	{
		// Strip empty array values
		if (is_array($value)) {
			$value = array_values(array_filter($value));
		}
		return $value;
	}

	/**
	 * Check what to return on basis of return format
	 *
	 * @param $value
	 * @param $field
	 * @return array|bool|int
	 */
	public function processValue($value, $field)
	{
		if (is_array($value)) {
			$formObjects = [];

			foreach ($value as $key => $formId) {
				$form = $this->processValue($formId, $field);
				//Add it if it's not an error object
				if ($form) {
					$formObjects[$key] = $form;
				}
			}

			// Return the form object
			if (!empty($formObjects)) {
				return $formObjects;
			}

			// Else return false
			return false;
		}

		// Make sure field is an array
		$field = (array)$field;

		if (!empty($field['return_format']) && $field['return_format'] === 'id') {
			return (int)$value;
		}
		$form = GFAPI::get_form($value);

		//Return the form object if it's not an error object. Otherwise return false.
		if (!is_wp_error($form)) {
			return $form;
		}

		return false;
	}

	/**
	 * Check if we actually have forms that we can use for our field
	 *
	 * @return bool
	 */
	public function hasValidForms()
	{
		// Stop if Gravityforms is not active
		if (!class_exists('GFAPI')) {
			$this->notices->isGravityformsActive(true, true);

			return false;
		}

		// Check if there are forms and set our choices
		if (!$this->forms) {
			$this->notices->hasActiveGravityForms(true, true);

			return false;
		}

		return true;
	}
}
