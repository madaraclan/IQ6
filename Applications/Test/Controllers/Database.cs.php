<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Iqbal Maulana
 * Date: 5/31/11
 * Time: 6:58 PM
 * To change this template use File | Settings | File Templates.
 */

Import::Model('Test.City');
Import::Library('Plugin.ImageGD');

class _Database extends Controller {

	function testaLoad(URI $URI, Input $Input){
		echo '<pre>';
		print_r($URI->GetURI());
		echo '</pre>';
		echo $URI->GetURI(3);
	}
	
    public function MainLoad(URI $URI, Input $Input) {

        Database::Instance()->SetConfig("localhost", "mastertables");
        Database::Instance()->Connect();

        $stmt  = Database::Instance()->ExecuteQuery("
            SELECT * FROM country
        ");

        $datas = Database::Instance()->Fetch($stmt);
        print_r($datas);
        
    }

    public function ImageOnAirLoad(URI $URI, Input $Input) {
        Import::View('ShowImage');
    }

    public function ImageSavedLoad(URI $URI, Input $Input) {
        $imageDestination  = Path::Root('Photos/thumb.jpg');
        
        if (file_exists($imageDestination)) unlink($imageDestination);
        
        $imageSource    = array(
            "name" => Config::Instance(SETTING_USE)->photos."wizard_profile_picture.gif",
            "type" => "image/gif"
        );
        $image  = new ImageGD($imageSource, 60, 60);

        $prepare = $image->Prepare();

        if ($image->Prepare() === TRUE) {
            $image->Save($imageDestination);
        }
        $imageName = Path::ConvertToURL($imageDestination);
        Import::View('SavedImage', array("imageName"=>$imageName));
    }

    public function CreateImageLoad(URI $URI, Input $Input) {
        $imageSource    = array(
            "name" => Config::Instance(SETTING_USE)->photos."img1.jpg",
            "type" => "image/jpeg"
        );
        $image  = new ImageGD($imageSource, 60, 60);

        $prepare = $image->Prepare();

        if ($image->Prepare() === TRUE) {
            $image->Create();
        }
    }
}
