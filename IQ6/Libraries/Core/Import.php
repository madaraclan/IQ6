<?php
if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');
/**
 * InTechPHP Framework
 *
 * Import Framework For Import Libraries, Views, Etc.
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
* Import Class
*
* @package		InTechPHP
* @subpackage	Core
* @category		Libraries
* @author		Iqbal Maulana
*/
class Import {

    private static $useTemplate = false;
    private static $templateTitle;
    private static $templateData;
    private static $templateFileName;

    /**
     * Import Library
     *
     * Import Existing Library
     *
     * @static
     * @access   public
     * @throws   CustomException
     * @param    string
     * @return   void
     */
    
    public static function Library($path = '') {
        try {
            if($path) {
                $path = str_replace(" ","",$path);
                $path = str_replace(".","/",$path);
                $path_arr = explode("/",$path);
                
                if($path_arr[count($path_arr)-1] == "*")
                {
                    $dir = substr($path, 0, strlen($path)-1);
                    self::InDirectory("Libraries/".$dir);
                }
                else if(file_exists("Libraries/".$path.".php"))
                {
                    
                    require_once("Libraries/".$path.".php");
                }
                    else throw new CustomException();
            }
            else
                throw new CustomException();
        }
        catch(CustomException $e)
        {
            if($path)
            {
                $path = explode("/",$path);
                $path = $path[count($path)-1];
                $path = $path.".php";
            }
            echo $e->ShowError(404,"File :".$path." not found");
        }
    }

    /**
     * Import Entity
     *
     * import existing entity
     *
     * @static
     * @access public
     * @param  string
     * @return void
     */
    public static function Entity($path) {
        $path   = str_replace(" ","",$path);
        $parts  = explode(".", $path);

        if ($parts[1] == '*') {
            self::InDirectory(PATH_BASE . DS . 'Applications' . DS . ucfirst($parts[0]) . DS . 'Entities' . DS);
        }
        else {
            $fileName = PATH_BASE . DS . 'Applications' . DS . ucfirst($parts[0]) . DS . 'Entities' . DS . $parts[1] . '.en.php';

            try {
                if (file_exists($fileName)) {
                    require_once($fileName);
                }
            }
            catch(CustomException $e) {
                $e->ShowError('Entity Not Found', 'File : <strong>'.$fileName.'</strong> not found.', 404);
            }
        }
    }

    /**
     * Import Model
     *
     * import existing model
     *
     * @static
     * @access public
     * @param  string
     * @return void
     */
    public static function Model($path) {
        $path   = str_replace(" ","",$path);
        $parts  = explode(".", $path);

        if ($parts[1] == '*') {
            self::InDirectory(PATH_BASE . DS . 'Applications' . DS . ucfirst($parts[0]) . DS . 'Models' . DS);
        }
        else {
            $fileName = PATH_BASE . DS . 'Applications' . DS . ucfirst($parts[0]) . DS . 'Models' . DS . $parts[1] . '.md.php';
            
            try {
                if (file_exists($fileName)) {
                    require_once($fileName);
                }
            }
            catch(CustomException $e) {
                $e->ShowError('Model Not Found', 'File : <strong>'.$fileName.'</strong> not found.', 404);
            }
        }
    }
    

    /**
     * In Directory
     *
     * Looking Up Library In Directory
     *
     * @static
     * @access   private
     * @param    string
     * @return   void
     */
    private static function InDirectory($dir)
    {
        $myDir 	= opendir($dir);
        while(false !== ($file = readdir($myDir))) {
            if($file != "." && $file != "..") {
                if(is_dir($dir.$file)) {
                    chdir('.');
                    self::InDirectory($dir.$file.'/');
                }
                else {
                    $files = $dir.$file;
                    require_once($files);
                }
            }
        }
        closedir($myDir);
    }

    /**
     * Start Using Template
     *
     * Looking up for template and use template
     *
     * @static
     * @access   public
     * @param    [string],[array],[layout file name]
     * @return   void
     */
    public static function Template($title = '',$arrayData = array(),$layoutFile = 'Layout', $templateName = '')
    {
        $templateName = (empty($templateName)) ? Config::Instance(SETTING_USE)->template : $templateName;
        self::$templateTitle = $title;
        self::$templateData = $arrayData;
        $fileName = PATH_BASE . DS . 'Templates' . DS . ucfirst($templateName) . DS . $layoutFile . '.php';
        self::$templateFileName = $fileName;
        try {
            if (!file_exists($fileName))
                throw new CustomException();
            else
                self::$useTemplate = true;
        }
        catch(CustomException $e) {
            $e->ShowError('Template Not Found', 'File : <strong>'.$fileName.'</strong> not found.', 404);
        }
    }


    /**
     * Define Other Template beside Default Template
     *
     * Looking up for other template and use that template
     *
     * @static
     * @access   public
     * @param    string,[string],[array],[layout file name]
     * @return   void
     */
    public static function DefaultTemplate($templateName,$title = '',$arrayData = array(),$layoutFile = 'layout.php')
    {
        self::$templateTitle = $title;
        self::$templateData = $arrayData;
        $fileName = PATH_BASE . DS . 'Templates' . DS . ucfirst($templateName) . DS . $layoutFile;
        self::$templateFileName = $fileName;
        try {
            if (!file_exists($fileName))
                throw new CustomException();
            else
                self::$useTemplate = true;
        }
        catch(CustomException $e) {
            $e->ShowError('Template Not Found', 'File : <strong>'.$fileName.'</strong> not found.', 404);
        }
    }

    /**
     * Load Template
     *
     * Load Template
     *
     * @static
     * @access   private
     * @param    string
     * @return   string
     */
    private static function LoadTemplate($contentDataLayout)
    {
        $title = self::$templateTitle;
        if(is_array(self::$templateData) && !empty(self::$templateData))
            extract(self::$templateData);
        ob_start();
        include_once(self::$templateFileName);
        $buffer = ob_get_contents();
        ob_end_clean();
        return $buffer;
    }

    /**
     * Load View
     *
     * Load for existing view
     *
     * @static
     * @access   private
     * @param    string,[array]
     * @return   void
     */
    public static function View($viewName, $arrData=array())
    {
        $URI    = new URI();
        $templateName = Config::Instance(SETTING_USE)->template;
        $appURI  = $URI->GetURI(Config::Instance('default')->appLink);
        $appName = ( ! empty($appURI) ) ? $appURI : Config::Instance(SETTING_USE)->defaultApplication;
        
        $fileName = PATH_BASE . DS . 'Templates' . DS . ucfirst($templateName) . DS . 'Views' . DS . $viewName . '.php';
        $fileNameApp = PATH_BASE . DS . 'Applications' . DS . ucfirst($appName) . DS . 'Views' . DS . $viewName . '.php';
        $fileView = str_replace('/', DS, $fileName);

        try {

            if (file_exists($fileName)) {
                $fileView = $fileName;
            }
            else if(file_exists($fileNameApp))
            {
                $fileView = $fileNameApp;
            }
            else
                throw new CustomException();

            extract($arrData);
            ob_start();
            include_once($fileView);
            $contentDataLayout = ob_get_contents();
            ob_end_clean();

            $contentDataLayout = self::CustomTag('View',$contentDataLayout);

            if(self::$useTemplate)
            {
                $buffer = self::LoadTemplate($contentDataLayout);
                $buffer = self::CustomTag('Template',$buffer);
                echo $buffer;
            }
            else
            {
                echo $contentDataLayout;
            }

        }
        catch(CustomException $e) {
            $e->ShowError('Views Not Found', 'File : <strong>'.$fileName.'</strong> not found.', 404);
        }

    }

    private static function CustomTag($caller,$html)
    {
        preg_match_all('/<([^=\s]+):([^=\s]+)([^>]*)\s*\/?>/', $html, $customTags, PREG_SET_ORDER);
        
        foreach ($customTags as $customTag) {
            $originalTag="<".$customTag[1].":".$customTag[2].$customTag[3].">";
            $rawAttributes=$customTag[3];

            preg_match_all('/([^=\s]+)="([^"]+)"/', $rawAttributes, $attributes, PREG_SET_ORDER);

            $formatedAttributes=array();
            
            foreach ($attributes as $attribute) {
                $name=$attribute[1];
                $value=$attribute[2];

                $formatedAttributes[$name]=$value;
            }
            ob_start();
            $fileWidget = PATH_BASE . DS . 'Widgets' . DS . ucfirst($customTag[1]) . DS . $customTag[2] . '.php';
            extract($formatedAttributes);
            include($fileWidget);
            $widget = ob_get_contents();
            ob_end_clean();

            $html=str_replace($originalTag, $widget, $html);
        }
        return $html;
    }
}