<?php
if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');
/**
 * InTechPHP Framework
 *
 * Framework Dynamic Configuration
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
* Config Class
*
* @package		InTechPHP
* @subpackage	Core
* @category		Libraries
* @author		Iqbal Maulana
*/
class Config {
    private static $instance;
    private $config;
    private $activeGroup;

    /**
	* Instance Config
	*
	* get instance of Config (singleton pattern)
	*
	* @return   Config
	*/
    public static function Instance($activeGroup) {

        if(!isset(self::$instance)) {
            $class          = __CLASS__;
            self::$instance = new $class;
            self::$instance->config = array();
        }
        
        self::$instance->activeGroup = $activeGroup;
        return self::$instance;

    }

    /**
	* Setter Config
	*
	* set dynamic attribute config
	*
	* @return   void
	*/
    public function __set($name, $value) {
        $this->config[$this->activeGroup][$name]    = $value;
    }

    /**
	* Getter Config
	*
	* get dynamic attribute config
	*
	* @return   mix
	*/
    public function __get($name) {
        return $this->config[$this->activeGroup][$name];
    }
}
?>