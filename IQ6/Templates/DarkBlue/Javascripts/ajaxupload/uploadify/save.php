<?php
		
		$name = $_POST['imageData'];
		$tmp = $_POST['filename'];
	
		$token=md5(substr(md5($_SERVER['REMOTE_ADDR'].microtime().rand(1,100000)),0,6));
		
		
		$filterData = substr($name, strpos($name, ",") + 1);
		$unEncodedData = base64_decode($filterData);
		
		$fp = fopen('../uploads/edit_img_'.$token.'.jpg', 'wb');
		fwrite($fp, $unEncodedData);
		fclose($fp);
		
		echo json_encode(array(
			'status' => 1,
			'url' => 'http://localhost/vintage/v2/u/uploads/edit_img_'.$token.'.jpg'
		));
		
?>