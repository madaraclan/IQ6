<?php
if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');
/**
 * Created by JetBrains PhpStorm.
 * User: William
 * Date: 7/3/11
 * Time: 9:35 AM
 * To change this template use File | Settings | File Templates.
 */
 
class File {
    public static function DownloadFile($sourceFolder,$fileName,$realName)
    {
        $realName = str_replace(' ','_',$realName);
        header("Content-Type: application/octet-stream");
	    header("Content-Disposition: disposition-type=attachment; filename=".$realName);
	    $file = fopen($sourceFolder.$fileName,"r");
        $data = fread($file,filesize($sourceFolder.$fileName));
        echo $data;
        fclose($file);
    }
}
