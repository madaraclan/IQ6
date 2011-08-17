<?php
if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');
/**
 * InTechPHP Framework
 *
 * Controller Framework for MVC - Controller
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
* Model Class
*
* @package		InTechPHP
* @subpackage	Core
* @category		Libraries
* @author		Iqbal Maulana
*/
abstract class Controller {
    /**
     * Constructor
     *
     * import libraries
     *
     * @access  public
     * @return  void
     */
    public function __construct() {
        $libraries  = Config::Instance(SETTING_USE)->autoLoadLibs;
        if( count( $libraries ) > 0 ) {
            foreach( Config::Instance(SETTING_USE)->autoLoadLibs as $lib ) {
                Import::Library($lib);
            }
        }
    }
    
    //abstract public function MainLoad(URI $URI, Input $Input);
}
