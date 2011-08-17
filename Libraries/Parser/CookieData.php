<?php
if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');
/**
 * InTechPHP Framework
 *
 * Cookie to save data in application.
 *
 * @package		InTechPHP
 * @author		Iqbal Maulana
 * @copyright	Copyright (c) 2011, Intelligence Tech, Inc.
 * @license
 * @link		http://intelligencetech.com
 * @since		Version 1.0
 */


class CookieData {
    private $cookieData;
    public $cookieTime;
    private $cookieName;
    private $cookiePath;
    private $cookieDomain;

    /**
     * Constructor
     *
     * Constructor function
     *
     * @access public
     * @param  [string], [numeric], [string], [string]
     * @return void
     */
    public function __construct($cookieName = FALSE, $cookieTime = FALSE, $cookiePath = FALSE, $cookieDomain = FALSE)
    {
        if($cookieName)
            $this->cookieName = $cookieName;
        else
            $this->cookieName = Config::Instance(SETTING_USE)->cookieName;
        if($cookieTime)
            $this->cookieTime = $cookieTime*60;
        else
            $this->cookieTime = Config::Instance(SETTING_USE)->cookieTime*60;
        if($cookiePath)
            $this->cookiePath = $cookiePath;
        else
            $this->cookiePath = Config::Instance(SETTING_USE)->cookiePath;
        if($cookieDomain)
            $this->cookieDomain = $cookieDomain;
        else
            $this->cookieDomain = Config::Instance(SETTING_USE)->cookieDomain;


        if(isset($_COOKIE[$this->cookieName]))
            $this->cookieData = unserialize($_COOKIE[$this->cookieName]);
        else
            $this->cookieData = array();
    }


    /**
     * Set Time Out
     *
     * Set Time out function
     *
     * @access public
     * @param  [numeric]
     * @return void
     */
    public function SetTime($cookietime = FALSE)
    {
        try{
            if($cookietime == NULL)
            {
                $this->cookieTime = NULL;
                setcookie($this->cookieName, serialize($this->cookieData),0,$this->cookiePath,$this->cookieDomain);
            }
            else if(is_numeric($cookietime))
            {
                $this->cookieTime = $cookietime*60;
                setcookie($this->cookieName, serialize($this->cookieData),time() + $this->cookieTime,$this->cookiePath,$this->cookieDomain);
            }
            else
                throw new CustomException();
        }catch(CustomException $e)
        {
            $e->ShowError('Set Time Error','cookie time must be numeric');
        }
    }


    /**
     * Set Name
     *
     * Set Name for cookie data
     *
     * @access public
     * @param  string
     * @return void
     */
    public function SetCookieName($cookieName)
    {
        $this->cookieName = $cookieName;
        if(isset($_COOKIE[$this->cookieName]))
            $this->cookieData = unserialize($_COOKIE[$this->cookieName]);
        else
            $this->cookieData = array();
    }


    /**
     * Set Path
     *
     * Set Path to save cookie
     *
     * @access public
     * @param  string
     * @return void
     */
    public function SetPath($cookiePath)
    {
        $this->cookiePath = $cookiePath;
        $time = time() + $this->cookieTime;
        if($this->cookieTime == NULL)
            $time = 0;
        setcookie($this->cookieName, serialize($this->cookieData),$time,$this->cookiePath,$this->cookieDomain);
    }


    /**
     * Set Domain
     *
     * Set Domain for cookie
     *
     * @access public
     * @param  string
     * @return void
     */
    public function SetDomain($cookieDomain)
    {
        $this->cookieDomain = $cookieDomain;
        $time = time() + $this->cookieTime;
        if($this->cookieTime == NULL)
            $time = 0;
        setcookie($this->cookieName, serialize($this->cookieData),$time,$this->cookiePath,$this->cookieDomain);
    }


    /**
     * Set Value
     *
     * Set Value for a cookie name
     *
     * @access public
     * @param  string, mixed
     * @return void
     */
    public function SetValue($variableName, $variableValue)
    {
        $this->cookieData[$variableName] = $variableValue;
        $time = time() + $this->cookieTime;
        if($this->cookieTime == NULL)
            $time = 0;
        setcookie($this->cookieName, serialize($this->cookieData),$time,$this->cookiePath,$this->cookieDomain);
    }


    /**
     * Get Value
     *
     * Get Value for a certain cookie name
     *
     * @access public
     * @param  string
     * @return mixed
     */
    public function GetValue($variableName)
    {
        try{
            if(isset($this->cookieData[$variableName]))
                return $this->cookieData[$variableName];
            else
                return NULL;
        }catch(CustomException $e)
        {
            $e->ShowError('Get cookie data Error','Data is unavailable');
        }
    }


    /**
     * Delete Value
     *
     * Delete value for a certain cookie name
     *
     * @access public
     * @param  string
     * @return void
     */
    public function DeleteValue($variableName)
    {
		unset($this->cookieData[$variableName]);
		$time = time() + $this->cookieTime;
		if($this->cookieTime == NULL)
			$time = 0;
		setcookie($this->cookieName, serialize($this->cookieData),$time,$this->cookiePath,$this->cookieDomain);
    }


    /**
     * Delete All Value
     *
     * Delete All Value that stored in cookie
     *
     * @access public
     * @param  void
     * @return void
     */
    public function DeleteAllValue()
    {
        $this->cookieData = array();
        $time = time() + $this->cookieTime;
        if($this->cookieTime == NULL)
            $time = 0;
        setcookie($this->cookieName, serialize($this->cookieData),$time,$this->cookiePath,$this->cookieDomain);
    }
}
