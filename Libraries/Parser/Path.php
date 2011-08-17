<?php
if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');

class Path {
    public static function Root($path = '') {
        $path   = PATH_ROOT . DS . $path;
        $path   = str_replace('/', DS, $path);

        return $path;
    }

    public static function ConvertToURL($path = '') {
        $path = str_replace(PATH_ROOT, Config::Instance(SETTING_USE)->baseUrl, $path);
        $path = str_replace(DS, '/', $path);
        return $path;
    }

    public static function Template($path = '') {
        $baseTemplate   = Config::Instance(SETTING_USE)->baseUrl . 'Templates/' . Config::Instance(SETTING_USE)->template . '/';

        if ( ! empty($path))
            $baseTemplate .= $path;
        return $baseTemplate;
    }

    public static function View($path = '', $appPath = NULL) {
        $URI    = new URI();
        if ($appPath === NULL)
            $baseAppPath = $URI->GetURI('App');
        else
            $baseAppPath = $appPath;

        $fileName   = Config::Instance(SETTING_USE)->baseUrl . 'Applications/' . $baseAppPath . '/Views/' . $path;
        return $fileName;
    }
}
