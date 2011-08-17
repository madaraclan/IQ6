<?php
 if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');
/**
 * InTechPHP Framework
 *
 * Framework Dynamic Configuration
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
* Archive Class
*
* @package		InTechPHP
* @subpackage	Archive
* @category		Libraries
* @author		Iqbal Maulana
*/
class Archive {
    private $errorData;

    public function GenerateArchive($files = array(),$filename = '',$comment = '',$overwrite = false)
    {
        $destination   = PATH_BASE . DS . Config::Instance(SETTING_USE)->tempDirectory . DS . $filename;
        try{
            //if the zip file already exists and overwrite is false, return false
            if(file_exists($destination) && !$overwrite) {
                $this->errorData = "File is not Overwritable";
                throw new CustomException();
            }
                //vars
            $valid_files = array();
            //if files were passed in...
            if(is_array($files)) {
                //cycle through each file
                foreach($files as $file)     {
                    //make sure the file exists
                    if(file_exists($file)) {
                        $valid_files[] = $file;
                    }
                }
            }
            else
                $valid_files[] = $files;
            //if we have good files...
            if(count($valid_files)) {
                //create the archive
                $zip = new ZipArchive();
                if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
                    return false;
                }
                //add the files
                foreach($valid_files as $file) {
                    if(is_dir($file))
                    {
                        $this->InDirectory($file,$zip);
                    }
                    else
                        $zip->addFile($file);
                }
                $zip->setArchiveComment($comment);
            //debug
            //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;

            //close the zip -- done!
                
                $zip->close();
                header("Cache-Control: public");
                header("Content-Description: File Transfer");
                header("Content-Disposition: attachment; filename=$filename");
                header("Content-Type: application/zip");
                header("Content-Transfer-Encoding: binary");

                readfile($destination);
                @unlink($destination);
            //check to make sure the file exists
                //return file_exists($destination);
            }
            else
            {
                $this->errorData = "No File is archived";
                throw new CustomException();
            }
        }
        catch(CustomException $e)
        {
            $e->ShowError('Error create Archive', $this->errorData);
        }
    }

    /**
     * In Directory
     *
     * Looking Up File In Directory to Archive
     *
     * @static
     * @access   private
     * @param    string
     * @return   void
     */
    private function InDirectory($dir,$zip)
    {
        $myDir 	= opendir($dir);
        while(false !== ($file = readdir($myDir))) {
            if($file != "." && $file != "..") {
                if(is_dir($dir."/".$file)) {
                    chdir('.');
                    $this->InDirectory($dir."/".$file,$zip);
                }
                else {
                    $files = $dir."/".$file;
                    $zip->addFile($files);
                }
            }
        }
        closedir($myDir);
    }

    public function ExtractArchive($zipFile,$destination = '')
    {
        try{
            $zip = new ZipArchive();

            //Opens a Zip archive
            $extract = $zip->open($zipFile);

            if ($extract === TRUE) {

            //Extract the archive contents
            $zip->extractTo($destination);

            //Close a Zip archive
            $zip->close();

            } else {
                throw new CustomException();
            }
        }
        catch(CustomException $e)
        {
            $e->ShowError('Error extract Archive', "Extraction of ".$zipFile." failed");
        }
    }
}