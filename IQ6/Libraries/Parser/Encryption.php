<?php
if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');
/**
 * InTechPHP Framework
 *
 * Encrypt and decrypt support AES 128, 192 and 256
 *
 * @package		InTechPHP
 * @author		Iqbal Maulana
 * @copyright	Copyright (c) 2011, Intelligence Tech, Inc.
 * @license
 * @link		http://intelligencetech.com
 * @since		Version 1.0
 */

// ------------------------------------------------------------------------

Import::Library('Parser.AES');

// ------------------------------------------------------------------------

/**
* Encrypter Class
*
* @package		InTechPHP
* @subpackage	Parser
* @category		Libraries
* @author		Iqbal Maulana
*/
class Encryption {
    private static $instance;

    public static function Encrypt($str) {
        if ( ! isset(self::$instance) ) {
            self::$instance = new AES();
        }
        
        $n          = ceil( strlen($str)/16 );
        $encrypt    = '';

        for ($i = 0; $i <= $n-1; $i++) {
            $crypText    = self::$instance->Encrypt(self::$instance->stringToHex(substr($str, $i*16, 16)), Config::Instance(SETTING_USE)->encryptionKey);
            $encrypt    .= $crypText;
        }

        return $encrypt;
    }

    public static function Decrypt($encryptedStr) {
        if ( ! isset(self::$instance) ) {
            self::$instance = new AES();
        }

        $n          = ceil(strlen($encryptedStr)/32);
        $decrypt    = '';

        for ($i = 0; $i <= $n-1; $i++) {
            $result      = self::$instance->Decrypt(substr($encryptedStr, $i*32, 32), Config::Instance(SETTING_USE)->encryptionKey);
            $decrypt    .= self::$instance->hexToString($result);
        }

        return $decrypt;
    }
}
