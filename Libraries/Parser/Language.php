<?php
class Language {
    protected function SettingLanguage($lang) {
        setcookie("ActiveLanguage", $lang, time()+3600*24*30*12);
	    //header("location:access.sec?".$_SERVER['QUERY_STRING']);
    }
    
    protected function LoadLanguage() {
        $ActiveLanguage	= ( ! isset($_COOKIE['ActiveLanguage']) || empty($_COOKIE['ActiveLanguage'])) ? Config::Instance(SETTING_USE)->defaultLanguage : $_COOKIE['ActiveLanguage'];

        if ( ! file_exists(PATH_BASE . DS . "Languages". DS. $ActiveLanguage . ".php")) {
            $ActiveLanguage = Config::Instance(SETTING_USE)->defaultLanguage;
        }

        try {
            $filepath = PATH_BASE . DS . "Languages" . DS . $ActiveLanguage. ".php";

            if (is_readable($filepath)) {
                require_once($filepath);
            }
            else {
                throw new CustomException();
            }
        }
        catch(CustomException $e) {
            $e->ShowError('Language Not Found', 'The Language : <b>' . $ActiveLanguage . '</b> Not Found.', 404);
        }
    }

    public static function WriteLanguage($str = '') {
        if (empty($str)) {
            return FALSE;
        }

        $partsReplace   = func_get_args();
        for ($i = 1; $i < count($partsReplace); $i++) {
            $str = str_replace('{'.($i-1).'}', $partsReplace[$i], $str);
        }

        echo $str;
    }
}
