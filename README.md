# Advanced Custom Fields Gravity Forms Add-on

Provides an Advanced Custom Field which allows a WordPress editorial user or administrator to select a Gravity Form as part of a field group configuration.

## Getting started

The plugin is primarily available from the [WordPress plugin repository](http://www.wordpress.org/plugins/acf-gravityforms-add-on). It allows you to choose a Gravity Form in WordPress Admin and use the selected form ID in your Theme or Plugin to output the form.

**This plugin does not have any effect on the output of the website**. It adds a [custom ACF field type](https://www.advancedcustomfields.com/resources/creating-a-new-field-type/) for use in an [ACF field group](https://www.advancedcustomfields.com/resources/creating-a-field-group/).

## Installation and usage

1. Upload the plugin files to the `/wp-content/plugins/acf-gravityforms-add-on` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Add a new field of type 'Forms' to the required ACF field group.

You can also install _Advanced Custom Fields: Gravity Forms Add-on_ using Composer.

`composer require dannyvanholten/acf-gravityforms-add-on`

…or if you make use of WPackagist, …

`composer require wpackagist-plugin/acf-gravityforms-add-on`

## Using Advanced Custom Fields: Gravity Forms Add-on

To use the the field you just need to know how Advanced Custom Fields work. You can check out [their documentation](https://www.advancedcustomfields.com/resources/).

The Gravity Forms Add-on returns either an single form object / ID or an array of objects / IDs.
Now we know that we can easily use it to build our fields :)

### Output of the form in the frontend

This plugin doesn't integrate any code to the frontend of the website. You will need to ensure that
your own Plugin or Theme handles the output of the form. An example of how do do this is detailed in
[this blog post](https://www.gravityforms.com/blog/embed-forms-using-code/) on the Gravity Forms website.

#### Getting the form ID

Please refer to the documentation for the ACF method `get_field` for full details of how to use it.

If you return an ID from your ACF field configuration:

```php
$form_id = get_field('my-form');
gravity_form($form_id);
```

If you return an object/array from your ACF field configuration:

```php
$form = get_field('my-form');
gravity_form($form['id']);
```

If you return multiple Form IDs from your ACF field configuration:

```php
$form_ids = get_field('my-form');

foreach($form_ids as $form_id) {
    gravity_form($form_id);
}
```

#### Filtering the field HTML

Version 1.3.4 added a plain HTML filter to the output of the field. This filter is not applied to fields in ACF version 4.

```php
apply_filters('acf-gravityforms-add-on/field_html', string $field_html, array $field, string $field_options, string $multiple)
```

## Getting involved

Want to get involved and improve _Advanced Custom Fields: Gravity Forms Add-on_? Fork this repo and whenever you have something just make a pull request. After review we might add it to our [GitHub Repository](https://github.com/DannyvanHolten/acf-gravityforms-add-on).

## Credits

This plugin is maintained by [Say Hello GmbH](https://www.sayhello.ch/agency/), a specialist WordPress agency in Spiez, Switzerland.

The plugin was initially developed by [Danny van Holten](https://github.com/DannyvanHolten) based on work by [@stormuk](https://github.com/stormuk/Gravity-Forms-ACF-Field), ([@lgladdy](https://github.com/lgladdy) and [@adampope](https://github.com/adampope)).
