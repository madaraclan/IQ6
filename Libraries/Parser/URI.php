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

Import::Library('Parser.Encryption');
Import::Library('Parser.Language');

// ------------------------------------------------------------------------

/**
* Router Class
*
* @package		InTechPHP
* @subpackage	Parser
* @category		Libraries
* @author		Iqbal Maulana
*/
class URI extends Language {
    private $uri;
    public function __construct() {
        $this->uri = $this->DetectURI();
    }
    /**
     * Fetch URI
     *
     * fetch query string url
     *
     * @access protected
     * @return array|string
     */
    protected function FetchURI() {
        $uri    = $this->uri;

        if (!$uri) return '';
        $url    = array();
        switch (Config::Instance(SETTING_USE)->URLMethod) {
            case 'friendly':
                    $uri    = str_replace(array('//', '../'), '/', trim($this->uri, '/'));
                    $uri    = $this->FilterURI($uri);
                    $url    = explode("/", $uri);
                    if(isset($url[0]) && ! empty($url[0])) $url[Config::Instance(SETTING_USE)->appLink] = $url[0];
                    if(isset($url[1]) && ! empty($url[1])) $url[Config::Instance(SETTING_USE)->comLink] = $url[1];
                    if(isset($url[2]) && ! empty($url[2])) $url[Config::Instance(SETTING_USE)->actLink] = $url[2];
                break;
            case 'encryption':
                    $uri = $this->uri;
                    if($uri == '/') $uri = '';
                    $uri    = $this->FilterURI($uri);
                    $parts  = $this->URIDecode($uri);
                    $url    = $parts;
                        
                    if (is_array($parts) && count($parts) > 0) {
                        foreach($parts as $part) {
                            if (isset($part) && ! empty($part)) {
                                array_push($url, $part);
                            }
                        }
                    }
                break;
            default:
                $uri    = str_replace(array('//', '../'), '/', trim($this->uri, '/'));
                $uri    = $this->FilterURI($uri);
                parse_str($uri, $url);
                $parts  = explode("&", $uri);

                if (count($parts) > 0) {
                    foreach ($parts as $part) {
                        $part = explode("=", $part);
                        if (isset($part[1]) && ! empty($part[1])) {
                            array_push($url, $part[1]);
                        }
                    }
                }

        }
        return $url;
    }

    /**
     * Query String
     *
     * get query string
     *
     * @access public
     * @return array|string
     */
    public function QueryString() {
        return $this->uri;
    }

    /**
     * Get URI
     *
     * get fetched query string url
     *
     * @access public
     * @return array|string
     */
    public function GetURI($name = '', $filter='text') {

        if ( ! $name ) {
            $uri        = array();
            $fetchedURI = $this->FetchURI();
            if (is_array($fetchedURI) && count($fetchedURI) > 0) {
                foreach($fetchedURI as $var=>$value) {
                    array_push($uri, TextFilter($value));
                    $uri[$var] = $value;
                }
            }
            return $uri;
        }

        $uri = $this->FetchURI();

        if ( ! isset($uri[$name]) && empty($uri[$name]) ) return '';
        switch ($filter) {
            case 'text':
                return TextFilter($uri[$name]);
                break;
            case 'int':
                return IntFilter($uri[$name]);
                break;
        }

    }

    /**
     * URI Decode
     *
     * decrypt encoded query string
     *
     * @access private
     * @return array
     */
    private function URIDecode($uri) {
        if (!$uri) return '';
        $param = explode('&', Encryption::Decrypt($uri));
        
        for ($i=0; $i <= count($param)-1; $i++)
        {
            $decode = explode('=', $param[$i]);
            $var[$decode[0]] = $decode[1];
        }

        return $var;
    }

    /**
     * Detect URI
     *
     * detect and clean query string
     *
     * @access private
     * @return mixed|string
     */
    private function DetectURI() {
        if ( ! isset($_SERVER['REQUEST_URI']) )
            return '';

        $uri    = $_SERVER['REQUEST_URI'];
        if (strpos($uri, $_SERVER['SCRIPT_NAME']) === 0) {
			$uri = substr($uri, strlen($_SERVER['SCRIPT_NAME']));
		}
		elseif (strpos($uri, dirname($_SERVER['SCRIPT_NAME'])) === 0) {
			$uri = substr($uri, strlen(dirname($_SERVER['SCRIPT_NAME'])));
		}

        if (strncmp($uri, '?', 1) === 0) {
            $uri = substr($uri, 1);
        }
        $parts  = preg_split('#\?#i', $uri, 1);
        $uri    = $parts[0];

        if (isset($parts[1])) {
            $_SERVER['QUERY_STRING'] = $parts[1];
            parse_str($_SERVER['QUERY_STRING'], $_GET);
        }
        else {
            $_SERVER['QUERY_STRING'] = '';
            $_GET = array();
        }

        $uri = parse_url($uri, PHP_URL_PATH);
        return $uri;
    }

    /**
     * Filter URI
     *
     * filtering disallowed characters in url
     *
     * @access private
     * @param  string
     * @return mixed
     */
    private function FilterURI($str) {
        if($str != '' && in_array(Config::Instance(SETTING_USE)->URLMethod, array("friendly", "default", "encryption"))) {
            switch(Config::Instance(SETTING_USE)->URLMethod) {
                case 'friendly':
                    $param  = '\/';
                    break;
                default:
                    $param  = '\&\=';
            }

            if ( Config::Instance(SETTING_USE)->URLMethod == 'encryption' ) {
                if ( ! preg_match("/^([a-zA-Z0-9]*)$/", $str) ) {
                    $e = new CustomException();
                    $e->ShowError('URI Error', 'The URI you submitted has disallowed characters.', 400);
                }
            }
            else {
                if ( ! preg_match("/^([".str_replace(array('\\-', '\-'), '-', preg_quote(Config::Instance(SETTING_USE)->permittedURIChars, '-')).$param."]*)$/", $str) ) {
                    $e = new CustomException();
                    $e->ShowError('URI Error', 'The URI you submitted has disallowed characters.', 400);
                }
            }
        }
        $bad	= array('$',		'(',		')',		'%28',		'%29');
		$good	= array('&#36;',	'&#40;',	'&#41;',	'&#40;',	'&#41;');

        return str_replace($bad, $good, $str);
    }

    public static function WriteURI($href, $https = FALSE) {
        $generateURI = self::Generate($href);

        if ($https === TRUE)
            $generateURI = str_replace('http', 'https', $generateURI);

        echo $generateURI;
    }

    public static function ReturnURI($href) {
        return self::Generate($href);
    }

    public static function WriteLink($href = NULL, $label = '', $title = '', $class = '', $id = '') {
        if ($href === NULL) {
            return FALSE;
        }
        
        $title  = ( ! empty($title))    ? ' title="' . $title . '"' : '';
        $class  = ( ! empty($class))    ? ' class="' . $class . '"' : '';
        $id     = ( ! empty($id))       ? ' id="' . $id . '"' : '';
        $label  = ( ! empty($label))    ? $label : self::Generate($href);

        echo '<a href="' . self::Generate($href) . '"'.$title.$class.$id.'>' . $label . '</a>';
    }
    
    private static function Generate($href) {
        switch(Config::Instance(SETTING_USE)->URLMethod) {
            case "friendly":
                $str        = "";
                $uriParts   = explode("&", $href);
                for ($i = 0; $i < count($uriParts); $i++) {
                    $parts  = explode("=", $uriParts[$i]);
                    if ( ! empty($parts[1])) {
                        $str   .= $parts[1]."/";
                    }
                }

                $return = (empty(Config::Instance(SETTING_USE)->baseFile)) ? Config::Instance(SETTING_USE)->baseUrl.Config::Instance(SETTING_USE)->baseFile . $str :
                          Config::Instance(SETTING_USE)->baseUrl.Config::Instance(SETTING_USE)->baseFile.'/'.$str;

                return $return;
                break;
            
            case "encryption":
                return Config::Instance(SETTING_USE)->baseUrl.Config::Instance(SETTING_USE)->baseFile.'?'.Encryption::Encrypt($href);
                break;

            default:
                return Config::Instance(SETTING_USE)->baseUrl.Config::Instance(SETTING_USE)->baseFile.'?'.$href;
        }
    }
    
}
