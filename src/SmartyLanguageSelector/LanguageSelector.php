<?php
/**
 * This file is part of smarty-gettext-language-selector. 
 * 
 * File: LanguageSelector.php
 *
 * User: dherrman
 * Date: 24.02.2015
 * Time: 18:42
 *
 * Purpose: Please fill...
 */

namespace SmartyLanguageSelector;

/**
 * Class LanguageSelector
 * @package SmartyLanguageSelector
 */
class LanguageSelector {

    /**
     * Sets the gettext localization based on a POST/GET/XXX parameter set by the smarty language chooser
     *
     * @param $textDomain
     * @param $textDomainPath
     * @param string $defaultLanguage Language to fall back if there is no language specified
     * @return string Returns the chosen locale, which is either the default language or a user-selected language
     * @throws GettextException
     */
    public static function setGettextLanguage($textDomain, $textDomainPath, $defaultLanguage = "en_US.utf8") {
        $chosenLanguage = $defaultLanguage;

        //Find chosen language


        //Perform Gettext settings
        putenv("LC_ALL=$chosenLanguage");
        $res = setlocale(LC_ALL, $chosenLanguage);
        if (!$res) {
            throw new GettextException("Unable to set locale to ".$chosenLanguage.". The language was not understood by your system.");
        }
        bindtextdomain($textDomain, $textDomainPath);
        textdomain($textDomain);

        return $chosenLanguage;
    }

}