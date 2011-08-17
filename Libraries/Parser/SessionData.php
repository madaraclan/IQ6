<?php
if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');
// SESSION MULAI
session_start();
/**
 * InTechPHP Framework
 *
 * Session to save data in application.
 *
 * @package		InTechPHP
 * @author		Iqbal Maulana
 * @copyright	Copyright (c) 2011, Intelligence Tech, Inc.
 * @license
 * @link		http://intelligencetech.com
 * @since		Version 1.0
 */


class SessionData {
    private $sessionData;
    private $sessionName;
    /**
     * Constructor
     *
     * Constructor function
     *
     * @access public
     * @param  [string], [numeric], [string], [string]
     * @return void
     */
    public function __construct($sessionName = FALSE)
    {
        if($sessionName)
            $this->sessionName = $sessionName;
        else
            $this->sessionName = Config::Instance(SETTING_USE)->sessionName;

        if(isset($_SESSION[$this->sessionName]))
            $this->sessionData = unserialize($_SESSION[$this->sessionName]);
        else
            $this->sessionData = array();
    }

    /**
     * Set Name
     *
     * Set Name for session data
     *
     * @access public
     * @param  string
     * @return void
     */
    public function SetSessionName($sessionName)
    {
        $this->sessionName = $sessionName;
        if(isset($_SESSION[$this->sessionName]))
            $this->sessionData = unserialize($_SESSION[$this->sessionName]);
        else
            $this->sessionData = array();
    }

    /**
     * Set Value
     *
     * Set Value for a session name
     *
     * @access public
     * @param  string, mixed
     * @return void
     */
    public function SetValue($variableName, $variableValue)
    {
        $this->sessionData[$variableName] = $variableValue;
        $_SESSION[$this->sessionName] = serialize($this->sessionData);
    }


    /**
     * Get Value
     *
     * Get Value for a certain session name
     *
     * @access public
     * @param  string
     * @return mixed
     */
    public function GetValue($variableName)
    {
        try{
            if(isset($this->sessionData[$variableName]))
                return $this->sessionData[$variableName];
            else
                return NULL;
        }catch(CustomException $e)
        {
            $e->ShowError('Get session data Error','Data is unavailable');
        }
    }


    /**
     * Delete Value
     *
     * Delete value for a certain session name
     *
     * @access public
     * @param  string
     * @return void
     */
    public function DeleteValue($variableName)
    {
		unset($this->sessionData[$variableName]);
		$_SESSION[$this->sessionName] = serialize($this->sessionData);
    }


    /**
     * Delete All Value
     *
     * Delete All Value that stored in session
     *
     * @access public
     * @param  void
     * @return void
     */
    public function DeleteAllValue()
    {
        $this->sessionData = array();
        $_SESSION[$this->sessionName] = serialize($this->sessionData);
    }
}
