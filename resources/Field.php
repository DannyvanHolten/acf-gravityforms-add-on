<?php

namespace ACFGravityformsField;

use acf_field;
use RGFormsModel;
use GFAPI;

class Field extends acf_field
{
	public function __construct()
	{
		$this->name = 'forms';
		$this->label = __('Forms', 'gravityforms');
		$this->category = __('Relational', 'acf');
		$this->defaults = [
			'return_format'  => 'form_object',
			'multiple' => 0,
			'allow_null'     => 0
		];

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
				'post_object' => __('Post Object', 'acf'),
				'id'          => __('Post ID', 'acf')
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
		$field = array_merge($this->defaults, $field);
		$choices = [];

		// Gravityforms not activated? Stop and issue a warning.
		if (class_exists('RGFormsModel')) {
			// Get all forms
			$forms = RGFormsModel::get_forms(1);
		} else {
			$warning = __('Warning: Gravityforms needs to be activated in order to use this field.',
				ACF_GF_FIELD_TEXTDOMAIN);
			$button = '<a class="button" href=' . admin_url('plugins.php') . '>' . __('Activate Gravityforms here',
					ACF_GF_FIELD_TEXTDOMAIN) . '</a>';

			echo '<p style="color:#d54e21;">' . $warning . '</p>' . $button;

			// Don't continue, because we have nothing to show
			return false;
		}

		// Check if there are forms and set our choices
		if (!empty($forms)) {
			foreach ($forms as $form) {
				if ((int)$form->is_active === 1) { // === is not possible because it doesn't recognize the type
					$choices[$form->id] = ucfirst($form->title);
				}
			}
		}

		// No active forms? Stop and issue a warning.
		if (empty($choices)) {
			$warning = __('Warning: There are no active forms. You need to create or activate a form first',
				ACF_GF_FIELD_TEXTDOMAIN);
			$button = '<a class="button" href=' . admin_url('admin.php?page=gf_new_form') . '>' . __('Create a New Form',
					'gravityforms') . '</a>';
			echo '<p style="color:#d54e21;">' . $warning . '</p>' . $button;

			// Don't continue, because we have nothing to show
			return false;
		}

		// Override field settings and start rendering
		$field['choices'] = $choices;
		$field['type'] = 'select';

		// Start building the html for our field
		$html = $field['multiple'] ? '<input type="hidden" name="{$field[\'name\']}">' : '';
		$html .= '<select id="' . str_replace(['[', ']'], ['-', ''], $field['name']) . '" name="' . $field['name'];
		$html .= $field['multiple'] ? '[]" multiple="multiple" data-multiple="1">' : '">';
		$html .= $field['allow_null'] ? '<option value="">' . __('- Select a form -',
				ACF_GF_FIELD_TEXTDOMAIN) . '</option>' : '';

		// Loop trough all our choices
		foreach ($field['choices'] as $formId => $formTitle) {
			$html .= '<option value="' . $formId . '"';
			$html .= (is_array($field['value']) && in_array($formId, $field['value'],
					false)) || $field['value'] === $formId ? ' selected="selected"' : '';
			$html .= '>' . $formTitle . '</option>';
		}

		// Close the field
		$html .= '</select>';

		echo $html;
	}

	/**
	 * Return a form object when not empty
	 *
	 * @param $value
	 * @param $post_id
	 * @param $field
	 * @return array|bool
	 */
	public function format_value($value, $post_id, $field)
	{
		return $this->process_value($value, $field);
	}

	/**
	 * Check what to return on basis of return format
	 *
	 * @param $value
	 * @param $field
	 * @return array|bool|int
	 */
	private function process_value($value, $field)
	{
		if (is_array($value)) {

			$form_objects = [];
			foreach ($value as $key => $formId) {
				$form = $this->process_value($formId, $field);
				//Add it if it's not an error object
				if ($form) {
					$form_objects[$key] = $form;
				}
			}

			//Return false if the array is empty
			if (!empty($form_objects)) {
				return $form_objects;
			} else {
				return false;
			}

		} else {
			if (!is_array($field)) {
				$field = [];
			}

			if (empty($field['return_format'])) {
				$field['return_format'] = 'post_object';
			}

			if ($field['return_format'] === 'id') {
				return (int)$value;
			}

			if ($field['return_format'] === 'form_object') {
				$form = GFAPI::get_form($value);
				//Return the form object if it's not an error object. Otherwise return false.
				if (!is_wp_error($form)) {
					return $form;
				}
			}

			return false;
		}
	}
}