<?php
/**
 * InTechPHP Framework
 *
 * Exception Framework For Error Handler
 *
 * @package		InTechPHP
 * @author		Iqbal Maulana
 * @copyright	Copyright (c) 2011, Intelligence Tech, Inc.
 * @license
 * @link		http://intelligencetech.com
 * @since		Version 1.0
 */

// ------------------------------------------------------------------------

/**
* Custom Exception Class
*
* @package		InTechPHP
* @subpackage	Error
* @category		Libraries
* @author		Iqbal Maulana
*/
class CustomException extends Exception
{
    private $levels = array(
            E_ERROR				=>	'Error',
            E_WARNING			=>	'Warning',
            E_PARSE				=>	'Parsing Error',
            E_NOTICE			=>	'Notice',
            E_CORE_ERROR		=>	'Core Error',
            E_CORE_WARNING		=>	'Core Warning',
            E_COMPILE_ERROR		=>	'Compile Error',
            E_COMPILE_WARNING	=>	'Compile Warning',
            E_USER_ERROR		=>	'User Error',
            E_USER_WARNING		=>	'User Warning',
            E_USER_NOTICE		=>	'User Notice',
            E_STRICT			=>	'Runtime Notice'
        );

    public function ShowPHPError($severity, $message, $filePath, $line) {
		ob_start();
		include('TemplatePHPError.html');
		$buffer = ob_get_contents();
		ob_end_clean();
        $buffer = str_replace( "{code}", $this->levels[$severity], $buffer );
        $buffer = str_replace( "{message}", $message, $buffer );
        $buffer = str_replace( "{file}", $filePath, $buffer );
        $buffer = str_replace( "{line}", $line, $buffer );
        echo $buffer;
    }

    public function ShowError($heading, $message, $statusCode = 500, $die = TRUE) {
		$message = implode('', ( ! is_array($message)) ? array($message) : $message);
     	ob_start();
		include('TemplateError.html');
		$buffer = ob_get_contents();
		ob_end_clean();
        $buffer = str_replace( "{code}", $heading, $buffer );
        $buffer = str_replace( "{message}", $message, $buffer );
        echo $buffer;

        if ($die === TRUE)
            exit();
	}
}
