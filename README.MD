# Smarty Gettext Language Selector

## Description

If you are using the template engine [Smarty](http://www.smarty.net/) and using [gettext for PHP](http://php.net/manual/en/book.gettext.php) to provide internationalization for your homepage, this plugin might be of use for you.

It provides both a smarty block, which generates an image dropdown, allowing the user to chose between the available languages. It further automatically displays the according flag next to the language. The chosen language is then sent via POST request to the current loaded site.

Second part of this plugin is a class which can be called at any common core class of your application, but before actually making use of any gettext functions. It can be initialized with a default language (for example, preferred language of the user currently logged in or application default language). The class then takes into account the POST value of the smarty block and, if that is not present, the default value, and performs gettext configuration be defining the locale and environment settings. Finally, it returns the chosen language, if you want to update the user settings.

## Installation

The package is available via [Composer and Packagist](https://packagist.org/packages/wazaari/smarty-gettext-language-selector), or directly using [GitHub](https://github.com/waza-ari/smarty-gettext-language-selector). So you can simply add the following line to your `require` section of your `composer.json`. 

```
    "wazaari/smarty-gettext-language-selector": "dev-master"
```

Next, you need to include some JS and CSS dependencies from the components folder:

``` html
<link href="components/msdropdown/css/msdropdown/dd.css" rel="stylesheet" type="text/css" />
<link href="components/msdropdown/css/msdropdown/flags.css" rel="stylesheet" type="text/css" />
<script type="application/javascript" src="components/msdropdown/js/msdropdown/jquery.dd.min.js"></script>
```

The package has a few requirements, which are:

```
	"ext-gettext": "*",
	"php": ">=5.2.1",
	"smarty/smarty": "3.*",
	"components/jquery": "*",
	"components/msdropdown": ">3"
```

Those are installed automatically as dependency when installing using Composer.

## Usage

You can either opt only to use the smarty language block to allow the user to choose a language. The usage of the gettext class is optional, you could also choose to use the POST value otherwise.

### Smarty Block

The Smarty function is called `{printLanguageSelector}` and can simply be used as such. It takes a number of arguments, which are described below:

- **$languageList** (required): Array of allowed languages, in the format "gettext-shortcode" => "Display Language". Example: "de_DE.utf8" => "Deutsch". Bear in mind that the shortcode needs to match the shortcode used by gettext (needs to match the locale available at system).
- **$selectWidth** (required, default="300px"): Defines the width of the select field, expressed as CSS property
- **$inputName** (required, default="languageSelector"): Name and ID of the select element. Will also be the array name in the `$_POST` array.
- **$displayFlags** (optional, default=true): Defines whether small language icons shall be displayed or not
- **$languageFlagMap** (optional, default=array()): Array of shortcodes mapped to an available flag. Only relevant if `$displayFlags == true`. The array should be in the format "gettext-shortcode" => "flag name w/o file extension". Example: "de_DE.utf8" => "de". If `$displayFlags == true` and no entry is found, a default icon is shown.

##### Example

``` smarty
{printLanguageSelector languageList=$languageList languageFlagMap=$flagList selectedLanguage=$currentLanguage selectWidth="96%"}
```

Where both arrays are defined in PHP and assigned to the template:

``` php
$page->assign('currentLanguage', self::getLanguage());
$page->assign('languageList', array('de_DE.utf8' => "Deutsch", 'en_GB.utf8' => "Englisch"));
$page->assign('flagList', array('de_DE.utf8' => "de", 'en_GB.utf8' => "gb"));
```

### LanguageSelector class

The class can be called anywhere in your core application, but before the first gettext texts are used, as the class sets the environment variables based on the chosen language. It is best explained by a slightly complex example:

``` php
LanguageSelector::$defaultLanguage = (self::isUser() ? self::getUser()->getLanguage() : $configLanguage);
$newLang = LanguageSelector::setGettextLanguage('messages', KRAS_BASEDIR."/tpl/locale");
if (self::isUser()) self::getUser()->setLanguage($newLang);
```

The first line sets the default language. If the user has a preferred language, use this. If there is no user logged in (anonymous) or the user has no preferred language, use the configured system default language.

The second line now calls the LanguageSelector class. It requires two arguments, which are the textdomain, and the path of the translation files. Those are later passed to the required gettext calls.

Finally, if the user has changed the language using the dropdown selector, update the user settings to reflect the change.

## Available Flags

This package uses [msdropdown](https://github.com/marghoobsuleman/ms-Dropdown) to allow the image dropdown, which ships with some flag sprites. Those can be used out of the box and are also used for this package. The list of available flags hence is defined by the available flags of this package. Have a look at either the [flag sprites](https://github.com/marghoobsuleman/ms-Dropdown/blob/master/images/msdropdown/icons/flagssprite_small.png) or the [flag CSS stylesheet](https://github.com/marghoobsuleman/ms-Dropdown/blob/master/css/msdropdown/flags.css).

## License

The package is available under [MIT license](http://opensource.org/licenses/MIT). You can find a copy of the license among the source code.

## Credits

The image dropdown was developed by [Marghoob Suleman](http://www.marghoobsuleman.com/jquery-image-dropdown), which is released at [GitHub under MIT license](https://github.com/marghoobsuleman/ms-Dropdown). This package is used to create the image dropdown.