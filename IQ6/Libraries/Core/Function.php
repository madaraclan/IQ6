<?php
if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');

function &LoadClass($class, $file_location = false)
{
    static $_classes = array();
    if(isset($_classes[$class]))
        return $_classes[$class];
    if($file_location)
    {
        if(file_exists($file_location))
        {
            require($file_location);
        }
    }
    else
    {
        if(file_exists($class.".php"))
        {
            require_once($class.".php");
        }
    }
    if(class_exists($class))
    {
        $_classes[$class] = new $class;
        return $_classes[$class];
    }
    else
        exit('Unable to locate the specified class: '.$class);
}

function redirect($url = '') {
	header('location:'.$url);
}

function _ExceptionHandler($severity, $message, $filePath, $line)
{
    $exception = &LoadClass("CustomException");
    $exception->showPHPError($severity,$message,$filePath,$line);
    exit();
}

/**
 * Text Filter
 *
 * filtering text from html
 * 
 * @param  string
 * @return mixed|string
 */
function TextFilter($str) {
    $text = preg_replace( "'<script[^>]*>.*?</script>'si", '', $str );
    $text = preg_replace( '/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is', '\2 (\1)', $text );
    $text = preg_replace( '/<!--.+?-->/', '', $text );
    $text = preg_replace( '/{.+?}/', '', $text );
    $text = preg_replace( '/&nbsp;/', ' ', $text );
    $text = preg_replace( '/&amp;/', ' ', $text );
    $text = preg_replace( '/&quot;/', ' ', $text );
    /*$text = preg_replace( '/[^\w\d_ -]/si', '', $text);*/
    //$text = str_replace( 'ՎsH', '', $text );
    $text = strip_tags( $text );
    $text = htmlspecialchars( $text );
    return $text;
}

/**
 * Integer Filter
 *
 * filtering integer
 * 
 * @param  int
 * @return int
 */
function IntFilter($int) {
    if (is_numeric ($int))
        return (int)preg_replace ( '/\D/i', '', $int);
    else {
        $int = ltrim($int, ';');
        $int = explode (';', $int);
        return (int)preg_replace ( '/\D/i', '', $int[0]);
    }
}

function GetPropertyName($object, $var) {
    $object = get_object_vars($object);
    foreach($object as $var_name => $value) {
        if ($value === $var) {
            return $var_name;
        }
    }

    return false;
}
