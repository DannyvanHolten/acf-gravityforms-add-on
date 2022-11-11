=== Advanced Custom Fields: Gravity Forms Add-on ===
Contributors: DannyvanHolten, markhowellsmead
Tags: gravityforms, gravity form, forms, form, acf, advanced custom fields, fields, custom fields, sayhellogmbh
Requires at least: 4.6
Tested up to: 6.1
Stable tag: 1.3.5
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Provides an Advanced Custom Field which allows a WordPress editorial user or administrator to select a Gravity Form as part of a field group configuration.

== Description ==

Provides an Advanced Custom Field which allows a WordPress editorial user or administrator to select a Gravity Form as part of a field group configuration.

Full documentation can be found in the [plugin's GitHub Repository](https://github.com/DannyvanHolten/acf-gravityforms-add-on).

== Installation ==

The plugin is available from the [WordPress plugin repository](http://www.wordpress.org/plugins/acf-gravityforms-add-on)

1. Upload the plugin files to the `/wp-content/plugins/acf-gravityforms-add-on` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Add a new field of type 'Forms' to the required ACF field group.

You can also install Advanced Custom Fields: Gravity Forms Add-on using Composer.

`composer require dannyvanholten/acf-gravityforms-add-on`

…or if you make use of WPackagist, …

`composer require wpackagist-plugin/acf-gravityforms-add-on`

== Screenshots ==

1. You can select 'Form' as a field type while adding an ACF Field.
2. The actual selection of the field.
3. You can select all your Gravity Forms.
4. If ACF or Gravity Forms is not added it will give a notice (Notices from [WP Growl Notifications](https://wordpress.org/plugins/wp-growl-notifications).

== Development ==

Version 1.3.2 added a plain HTML filter to the output of the field. This filter is not applied to fields in ACF version 4.

`apply_filters('acf-gravityforms-add-on/field_html', string $field_html, array $field, string $field_options, string $multiple)`

== Changelog ==

Further changes can be found in the [changelog](https://github.com/DannyvanHolten/acf-gravityforms-add-on/blob/master/CHANGELOG.md)
