<?php
if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');
/**
 * InTechPHP Framework
 *
 * Parses URIs and determines routing support with default, encryption and friendly url
 *
 * @package		InTechPHP
 * @author		Iqbal Maulana
 * @copyright	Copyright (c) 2011, Intelligence Tech, Inc.
 * @license
 * @link		http://intelligencetech.com
 * @since		Version 1.0
 */

// ------------------------------------------------------------------------

Import::Library('Parser.URI');
Import::Library('Parser.Input');
Import::Library('Parser.Path');
Import::Library('Db.Database');
Import::Library('Core.Model');
Import::Library('Core.Controller');

// ------------------------------------------------------------------------

/**
* Router Class
*
* @package		InTechPHP
* @subpackage	Core
* @category		Libraries
* @author		Iqbal Maulana
*/
class Router extends URI {
    private static $instance;
    private $uri;
    private $controller;
    private $action;

    private $URI;
    private $Input;

    /**
     * Instance Router
     *
     * get instance of router (singleton pattern)
     *
     * @static
     * @access public
     * @return Router
     */
    public static function Instance() {
        if( !isset(self::$instance) ) {
            $c  = __CLASS__;
            self::$instance = new $c;
        }

        self::$instance->URI    = new URI();
        self::$instance->Input  = new Input();
        
        return self::$instance;
    }

    /**
     * Start Router
     *
     * start router for work
     *
     * @access public
     * @return void
     */
    public function Start() {
        if (isset($_POST[Config::Instance('default')->paramLanguage])) {
            $this->SettingLanguage($_POST[Config::Instance('default')->paramLanguage]);
        }
        
        $this->LoadLanguage();
        $this->uri  = $this->FetchURI();
        $this->InitController();

        $this->InitAction();

        call_user_func(array($this->controller, $this->action), $this->URI, $this->Input);
    }

    /**
     * Initialization Controller
     *
     * run application and controller
     *
     * @access private
     * @throws CustomException
     * @return void
     */
    private function InitController() {
        $applicationName = (isset($this->uri[Config::Instance(SETTING_USE)->appLink]) && ! empty($this->uri[Config::Instance(SETTING_USE)->appLink]))
                ? $this->uri[Config::Instance(SETTING_USE)->appLink]
                : Config::Instance(SETTING_USE)->defaultApplication;

        $controllerName = (isset($this->uri[Config::Instance(SETTING_USE)->comLink]) && ! empty($this->uri[Config::Instance(SETTING_USE)->comLink]))
                ? $this->uri[Config::Instance(SETTING_USE)->comLink]
                : Config::Instance(SETTING_USE)->defaultController;
        
        $filePath       = PATH_BASE . DS . Config::Instance(SETTING_USE)->applicationPath . DS . $applicationName .
                          DS . 'Controllers' . DS . ucfirst($controllerName) . '.cs.php';
        try {
            if (file_exists($filePath)) {
                require_once( $filePath );

                try {
                    if (class_exists("_".$controllerName)) {
                        $controllerName = "_".$controllerName;
                        $this->controller = new $controllerName($this->URI, $this->Input);
                    }
                    else
                        throw new CustomException();
                }
                catch(CustomException $e) {
                    $e->ShowError('404 Controller Not Found', 'The application doesn\'t have controller that you requested.', 404);
                }
            }
            else
                throw new CustomException();
        }
        catch(CustomException $e) {
            $e->ShowError('404 Page Not Found', 'The page you requested was not found.', 404);
        }
    }

    /**
     * Initialization Action
     *
     * run method (action) in controller
     *
     * @access public
     * @throws CustomException
     * @return void
     */
    private function InitAction() {
        $componentName  = (isset($this->uri[Config::Instance(SETTING_USE)->actLink]) && ! empty($this->uri[Config::Instance(SETTING_USE)->actLink]))
                ? $this->uri[Config::Instance(SETTING_USE)->actLink]
                : Config::Instance(SETTING_USE)->defaultAction;
        $componentName  = $componentName."Load";

        try {
            if (method_exists($this->controller, $componentName)) {
                $this->action = $componentName;
            }
            else
                throw new CustomException();
        }
        catch(CustomException $e) {
            $e->ShowError('404 Action Not Found', 'The action you requested not found.', 404);
        }
    }
}
