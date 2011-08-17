<?php
if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');
/**
 * InTechPHP Framework
 *
 * Define And Initializing Default Setting
 *
 * @package		InTechPHP
 * @author		Iqbal Maulana
 * @copyright	Copyright (c) 2011, Intelligence Tech, Inc.
 * @license
 * @link		http://intelligencetech.com
 * @since		Version 1.0
 */


require_once( PATH_LIBRARIES.DS.'Error'.DS.'CustomException.php' );
require_once( PATH_LIBRARIES.DS.'Core'.DS.'Function.php' );
require_once( PATH_LIBRARIES.DS.'Core'.DS.'Import.php' );

Import::Library('Core.Config');
Import::Library('Core.Router');

require_once( PATH_ROOT.DS.'config.php' );

switch(Config::Instance(SETTING_USE)->environment) {
    case 'development':
        error_reporting(E_ALL | E_STRICT);
        break;

    case 'publish':
        error_reporting(0);
        break;
    
    case 'offline':
        $e = new CustomException();
        $e->ShowError('Website Offline', 'This website is currently offline. Please come back later.');
        break;

    default:
        $e  = new CustomException();
        $e->ShowError('Environment Error', 'The application environment is not set correctly.');
        break;
}

set_error_handler("_ExceptionHandler");
Router::Instance()->Start();
