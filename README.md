# Advanced Custom Fields: Gravityforms Add-on

Advanced Custom Field with which we can select Gravityforms.

## Getting started

The plugin is available from the [WordPress plugin repository](http://www.wordpress.org/plugins/acf-gravityforms-add-on)

1. Upload the plugin files to the `/wp-content/plugins/acf-gravityforms-add-on` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Add a new field of type 'Forms' to the required ACF field group.

You can also install Advanced Custom Fields: Gravityforms Add-on using Composer.

`composer require dannyvanholten/acf-gravityforms-add-on`

…or if you make use of WPackagist, …

`composer require wpackagist-plugin/acf-gravityforms-add-on`

## Using Advanced Custom Fields: Gravityforms Add-on

To use the the field you just need to know how Advanced Custom Fields work. You can check out [their documentation](https://www.advancedcustomfields.com/resources/).

The Gravityforms Add-on returns either an single form object / id or an array of objects / id's
Now we know that we can easily use it to build our fields :)

#### If you return an ID

```php
$form = get_field('my-form');
gravity_form($form, true, true, false, '', true, 1);
```

#### If you return an Object

```php
$form = get_field('my-form');
gravity_form($form['id'], true, true, false, '', true, 1);
```

#### If you return multiple Form ID's

```php
$forms = get_field('my-form');

foreach($forms as $form) {
    gravity_form($form, true, true, false, '', true, 1);
}
```

## Getting involved

Want to get involved and improve Advanced Custom Fields: Gravityforms Add-on? Fork this repo and whenever you have something just make a pull request. After review we might add it to the [Gravityforms ACF Field GitHub Repository](https://github.com/DannyvanHolten/acf-gravityforms-add-on).

## Getting ahead

As Gravityforms & Advanced Custom Fields are continuously in development we like to take a look ahead together for what's coming. If you want to get involved developing Advanced Custom Fields: Gravityforms Add-on you can ask us if you can implement some of the features yourself.

-   [x] Add dutch translations
-   [x] Create an admin notice when plug-in gets activated but Gravityforms is not activated yet
-   [x] Improve code by implementing code climate's hints.

## Credits

This plugin is currently maintained by [Say Hello GmbH](https://sayhello.ch/), a specialist WordPress agency in Spiez, Switzerland.

The plugin was initially developed by [Danny van Holten](https://github.com/DannyvanHolten) based on work by [@stormuk](https://github.com/stormuk/Gravity-Forms-ACF-Field) ([@lgladdy](https://github.com/lgladdy) & [@adampope](https://github.com/adampope)). Be sure to follow them!
