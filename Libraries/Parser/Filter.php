<?php
if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');
/**
 * InTechPHP Framework
 *
 * Filtering Data (Text, Int, etc)
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
* Filter Class
*
* @package		InTechPHP
* @subpackage	Parser
* @category		Libraries
* @author		Iqbal Maulana
*/
class Filter {

    /**
     * Integer Filtering
     *
     * converting all string to integer
     *
     * @static
     * @param  string | int
     * @return int
     */
    public static function IntFilter($number) {
        if (is_numeric ($number)) {
			return (int)preg_replace ( '/\D/i', '', $number);
        }
        else {
			$number = ltrim($number, ';');
			$number = explode (';', $number);
			return (int)preg_replace ( '/\D/i', '', $number[0]);
        }
    }

    /**
     * Text Filtering
     *
     * remove tag html or xss
     *
     * @static
     * @param  string
     * @return mixed|string
     */
    public static function TextFilter($str) {
        $str = preg_replace( "'<script[^>]*>.*?</script>'si", '', $str );
		$str = preg_replace( '/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is', '\2 (\1)', $str );
		$str = preg_replace( '/<!--.+?-->/', '', $str );
		$str = preg_replace( '/{.+?}/', '', $str );
		$str = preg_replace( '/&nbsp;/', ' ', $str );
		$str = preg_replace( '/&amp;/', ' ', $str );
		$str = preg_replace( '/&quot;/', ' ', $str );
		$str = str_replace( 'ՎsH', '', $str );
		$str = strip_tags( $str );
		$str = htmlspecialchars( $str );
		return $str;
    }

    public static function XSSFilter($str) {
        return nl2br(htmlspecialchars($str));
    }
}
