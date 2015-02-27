<?php

/**
 * This function is a Smarty Plugin which displays a language selector, which in turn reloads the site
 *  and passes the chosen language as POST argument to the application
 *
 * In the Smarty template, the function can be used as follows:
 *
 *  {printLanguageSelector}
 *
 * which will print a DropDown box with the available languages. The function takes a few parameters,
 *  which are documented below:
 *
 * $languageList                Array of allowed languages, in the format "gettext-shortcode" => "Display Language"
 *                              Example "de_DE.utf8" => "Deutsch". Bear in mind that the shortcode needs to match
 *                              the shortcode used by gettext (needs to match the locale available at system)
 * $inputName=languageSelector  Name and ID of the select element
 * $displayFlags = true         Defines whether small language icons shall be displayed or not
 * $languageFlagMap = array()   Array of shortcodes mapped to an available flag. Only relevant it $displayFlags == true
 *                              The array should be in the format "gettext-shortcode" => "flag name w/o file extension"
 *                              Example: "de_DE.utf8" => "de"
 *                              If ($displayFlags == true) and no entry is found, no icon is shown.
 *
 * @param $params Array of params described in function description or help file
 * @param $smarty Smarty reference to the smarty instance
 * @return String The result of execution of this block
 */
function smarty_function_printLanguageSelector($params, &$smarty) {
    //Create return String
    $return = "";
    $inputName = (isset($params["inputName"])) ? $params["inputName"] : "languageSelector";

    //Create select box
    $return .= "<form id=\"languageSelectorForm\" action=\"\" method=\"post\">";
    $return .= "<select name=\"".$inputName."\" id=\"".$inputName."\" style=\"width:300px;\">";
        if (isset($params['languageList']) && is_array($params['languageList'])) {
            foreach ($params['languageList'] AS $value => $display) {
                $return .= "<option value='".$value."' data-image=\"components/msdropdown/images/msdropdown/icons/blank.gif\" data-imagecss=\"flag ".$params['languageFlagMap'][$value]."\" data-title=\"".$display."\">".$display."</option>";
            }
        } else {
            $return .= "<option value='' data-image=\"components/msdropdown/images/msdropdown/icons/blank.gif\">No Languages</option>";
        }
    $return .= "</select>";
    $return .= "</form>";

    //Add JS Code
    $return .= "
        <script>
            $(document).ready(function() {
                $(\"#".$inputName."\").msDropdown();
            });

            $(\"#".$inputName."\").change(function() {
                $(\"#languageSelectorForm\").submit();
            });
        </script>
    ";

    //Display DropDown box
    return $return;
}