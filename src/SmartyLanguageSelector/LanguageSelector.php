<?php
namespace SmartyLanguageSelector;

/**
 * Class LanguageSelector
 * @package SmartyLanguageSelector
 */
class LanguageSelector
{

    /**
     * @var string Name of the HTML select form element, which allows to choose the language.
     *              Used to get the result from $_POST
     */
    public static $inputName = "languageSelector";

    /**
     * @var string Locale to fall back if there is no change made by the user
     */
    public static $defaultLanguage = "en_US.utf8";

    /**
     * Sets the gettext localization based on a POST/GET/XXX parameter set by the smarty language chooser
     *
     * @param $textDomain
     * @param $textDomainPath
     * @return string Returns the chosen locale, which is either the default language or a user-selected language
     * @throws GettextException
     */
    public static function setGettextLanguage($textDomain, $textDomainPath)
    {
        $chosenLanguage = self::$defaultLanguage;

        //Find chosen language
        if (isset($_POST[self::$inputName])) {
            $chosenLanguage = $_POST[self::$inputName];
        }

        //Perform Gettext settings
        putenv("LC_ALL=$chosenLanguage");
        $res = setlocale(LC_ALL, $chosenLanguage);
        if (!$res) {
            throw new GettextException(
                "Unable to set locale to ".$chosenLanguage.". The language was not understood by your system."
            );
        }
        bindtextdomain($textDomain, $textDomainPath);
        textdomain($textDomain);

        return $chosenLanguage;
    }
}
