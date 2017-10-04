=== Advanced Custom Fields: Gravityforms Add-on ===
Contributors: DannyvanHolten
Donate link: http://www.dannyvanholten.com/
Tags: gravityforms, gravity form, forms, form, acf, advanced custom fields, fields, custom fields
Requires at least: 4.6
Tested up to: 4.7.5
Stable tag: 1.2.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Advanced Custom Field with which we can select Gravityforms.

== Description ==

Advanced Custom Field with which we can select Gravityforms.

Finally the Advanced Custom Fields: Gravityforms Add-on is available on the WordPress plugin repository!

Any documentation can be found on: [Gravityforms ACF Field GitHub Repository.](https://github.com/DannyvanHolten/acf-gravityforms-add-on)

== Installation ==

The plugin is available from the [WordPress plugin repository](http://www.wordpress.org/plugins/acf-gravityforms-add-on)

1. Upload the plugin files to the `/wp-content/plugins/acf-gravityforms-add-on` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the Settings->Plugin Name screen to configure the plugin
4. (Make your instructions match the desired user flow for activating and installing your plugin. Include any steps that might be needed for explanatory purposes)

You can also install Advanced Custom Fields: Gravityforms Add-on trough composer

`composer require dannyvanholten/acf-gravityforms-add-on`

or if you make use of WPackagist

`composer require wpackagist/acf-gravityforms-add-on`

== Frequently Asked Questions ==

== Screenshots ==

1. You can select Form as a field type while adding an ACF Field.
2. The actual selection of the field
3. You can select all your Gravity forms
4. If ACF or Gravityforms is not added it will give a notice (Notices from [WP Growl Notifications](https://wordpress.org/plugins/wp-growl-notifications)

== Changelog ==

## 1.1.1
### Fixed
* Fixed the preselecting of values because of a typehinting bug.

## 1.1
### Added
* Added admin notices to check if ACF & Gravityforms are active

## 1.0.1
### Fixed
* Fixed a bug not causing the multiple option to render in ACF V4

## 1.0
### Added
* Changed names because of release on WordPress
* Documentation for WordPress

## 0.2
### Changed
* Refactor the entire repo. Doesn't look the same at all anymore

## 0.1
### Added
* The repo is set up

== Upgrade Notice ==