<?php

namespace ACFGravityforms;

use acf_field;

class Field extends acf_field
{
	public function __construct()
	{
		$this->name = 'form';
		$this->label = __('Form', 'gravityforms-acf-field');
		$this->category = __('Relational', 'acf');
		$this->defaults = [
			'allow_multiple' => 0,
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
		/**
		 * Render a field setting that will tell us if an empty field is allowed or not.
		 */
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

		/**
		 * Render a field setting that will tell us if multiple forms are allowed
		 */
		acf_render_field_setting($field, [
			'label'   => __('Allow Multiple?', 'acf'),
			'type'    => 'radio',
			'name'    => 'allow_multiple',
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
	 */
	public function render_field($field)
	{


		/*
		 * Review the data of $field.
		 * This will show what data is available
		 */
		// vars
		$field = array_merge($this->defaults, $field);
		$choices = [];
		//Show notice if Gravity Forms is not activated
		if (class_exists('RGFormsModel')) {

			$forms = RGFormsModel::get_forms(1);

		} else {
			echo "<font style='color:red;font-weight:bold;'>Warning: Gravity Forms is not installed or activated. This field does not function without Gravity Forms!</font>";
		}

		//Prevent undefined variable notice
		if (isset($forms)) {
			foreach ($forms as $form) {
				$choices[intval($form->id)] = ucfirst($form->title);
			}
		}
		// override field settings and render
		$field['choices'] = $choices;
		$field['type'] = 'select';
		if ($field['allow_multiple']) {
			$multiple = 'multiple="multiple" data-multiple="1"';
			echo "<input type=\"hidden\" name=\"{$field['name']}\">";
		} else {
			$multiple = '';
		}
		?>
        <select id="<?php echo str_replace(['[', ']'], ['-', ''], $field['name']); ?>" name="<?php echo $field['name'];
		if ($field['allow_multiple']) {
			echo "[]";
		} ?>"<?php echo $multiple; ?>>
			<?php
			if ($field['allow_null']) {
				echo '<option value="">- Select -</option>';
			}

			foreach ($field['choices'] as $key => $value) {
				$selected = '';
				if ((is_array($field['value']) && in_array($key, $field['value'])) || $field['value'] == $key) {
					$selected = ' selected="selected"';
				}
				?>
                <option value="<?php echo $key; ?>"<?php echo $selected; ?>><?php echo $value; ?></option>
			<?php } ?>
        </select>
		<?php
	}


	/**
	 *  This filter is applied to the $value after it is loaded from the db and before it is returned to the template
	 *
	 * @type  filter
	 * @since 3.6
	 * @date  23/01/13
	 *
	 * @param $value (mixed) the value which was loaded from the database
	 * @param $post_id (mixed) the $post_id from which the value was loaded
	 * @param $field (array) the field array holding all the field options
	 *
	 * @return  $value (mixed) the modified value
	 */

	public function format_value($value, $post_id, $field)
	{

		//Return false if value is false, null or empty
		if (!$value || empty($value)) {
			return false;
		}

		//If there are multiple forms, construct and return an array of form objects
		if (is_array($value) && !empty($value)) {

			$form_objects = [];
			foreach ($value as $k => $v) {
				$form = GFAPI::get_form($v);
				//Add it if it's not an error object
				if (!is_wp_error($form)) {
					$form_objects[$k] = $form;
				}
			}
			//Return false if the array is empty
			if (!empty($form_objects)) {
				return $form_objects;
			} else {
				return false;
			}


			//Else return single form object
		} else {

			$form = GFAPI::get_form(intval($value));
			//Return the form object if it's not an error object. Otherwise return false.
			if (!is_wp_error($form)) {
				return $form;
			} else {
				return false;
			}

		}

	}

}