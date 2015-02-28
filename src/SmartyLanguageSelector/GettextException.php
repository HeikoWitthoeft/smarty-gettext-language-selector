<?php

namespace SmartyLanguageSelector;

/**
 * Exception to indicate an error with the gettext Library
 *
 * Class GettextException
 * @package SmartyLanguageSelector
 */
class GettextException extends \Exception
{

    /**
     * Call parent constructor
     *
     * @param string $message
     * @param int $code
     */
    public function __construct($message, $code = 0)
    {
        parent::__construct($message, $code);
    }
}
