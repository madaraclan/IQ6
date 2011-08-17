<?php
if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');
/**
 * InTechPHP Framework
 *
 * Input Framework (Post, Session, Cookies, MD5)
 *
 * @package		InTechPHP
 * @author		Iqbal Maulana
 * @copyright	Copyright (c) 2011, Intelligence Tech, Inc.
 * @license
 * @link		http://intelligencetech.com
 * @since		Version 1.0
 */

// ------------------------------------------------------------------------
Import::Library('Parser.Filter');
Import::Library('Parser.SessionData');
Import::Library('Parser.CookieData');
// ------------------------------------------------------------------------

/**
* Input Class
*
* @package		InTechPHP
* @subpackage	Parser
* @category		Libraries
* @author		Iqbal Maulana
*/
class Input {
    private $postVar;
    private $instanceSession;
    private $instanceCookie;

    const INT   = 'INT';
    const TEXT  = 'TEXT';
    const XSS   = 'XSS';

    /**
     * Consturctor
     *
     * reset $_POST
     */
    public function __construct() {
        $this->postVar = $_POST;
        $_POST = array();
    }

    /**
     * Get Array Post
     *
     * get array post support with filtering
     *
     * @param null|string
     * @param bool|string
     * @return array|bool|int|mixed|string
     */
    public function Post($index = NULL, $filter = FALSE) {

        if ($index === NULL && ! empty($this->postVar)) {
            $post = array();

            foreach (array_keys($this->postVar) as $key) {
                $post[$key] = $this->FetchFromArray($this->postVar, $key, $filter);
            }
            return $post;
        }

        return $this->FetchFromArray($this->postVar, $index, $filter);
    }

    /**
     * Cookie Handler
     *
     * get and set value for cookie
     *
     * @param bool
     * @param bool
     * @param bool
     * @param bool
     * @return
     */
    public function Cookie($cookieName = FALSE, $cookieTime = FALSE, $cookiePath = FALSE, $cookieDomain = FALSE) {
        if ( ! isset($this->instanceCookie)) {
            $this->instanceCookie = new CookieData($cookieName, $cookieTime, $cookiePath, $cookieDomain);
        }

        return $this->instanceCookie;
    }

    /**
     * Session Handler
     *
     * get and set value for session
     *
     * @param string
     *
     */
    public function Session($sessionName = FALSE) {
        if ( ! isset($this->instanceSession)) {
            $this->instanceSession = new SessionData($sessionName);
        }

        return $this->instanceSession;
    }

    /**
     * Custom MD5 Encryption
     *
     * Encryption MD5 1024
     * @param string
     * @return bool|string
     */
    public function MD5($str) {
        if (empty($str)) {
            return FALSE;
        }

        for ($i = 0; $i < 1023; $i++) {
            $str = md5($str, TRUE);
        }
        return md5($str);
    }

    /**
     * Fetch From Array
     *
     * fetch array to string
     *
     * @param  array
     * @param string
     * @param bool
     * @return bool|int|mixed|string
     */
    private function FetchFromArray($array, $index = '', $filter = FALSE) {
        if ( ! isset($array[$index])) {
            return FALSE;
        }

        if ($filter === FALSE)
            return $array[$index];

        switch($filter) {
            case self::INT :
                return Filter::IntFilter($array[$index]);
                break;

            case self::TEXT :
                return Filter::TextFilter($array[$index]);
                break;

            case self::XSS :
                return Filter::XSSFilter($array[$index]);
                break;

            default:
                $e  = new CustomException();
                $e->ShowError('Filter Error', 'Filter : <b>' . $filter . '</b> Not Found!!');
        }
    }
}
