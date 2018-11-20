<?php
require_once "config.php";
function multiple_downloads($ids,$accessToken,$userName,$FB){
	$photosdata = array();
	foreach ($ids as $Data) {
		$response = $FB->get("/{$Data}/photos?fields=source&limit=100", $accessToken);
		$userData = $response->getGraphEdge();
		$finalData = array();
		if($FB->next($userData)){
			$dataArray = $userData->asArray();
			$finalData = array_merge($finalData,$dataArray);
			while($userData = $FB->next($userData)){
				$dataArray = $userData->asArray();
				$finalData = array_merge($finalData,$dataArray);
			}
		}else{
			$dataArray = $userData->asArray();
			$finalData = array_merge($finalData,$dataArray);
		}

		foreach ($finalData as $data1) {
		//$imageData = end($Data1['images']);
			$imgSource = isset($data1['source'])?$data1['source']:'';
			array_push($photosdata, $imgSource);
		}
	}
	$zip = new zipArchive;
	$filename = $userName.'allphotos.zip';
	$zip->open($filename,zipArchive::CREATE);
	$i = 1;
	foreach ($photosdata as $file) {
		$zip->addFromString('image'.$i.'.jpg',file_get_contents($file));
		$i = $i + 1;
	}
	$zip->close();
	header('Content-Type: application/zip');
	header('Content-disposition: attachment; filename ='.$filename);
	header('Content-Length: ' . filesize($filename));
	header("Pragma: no-cache"); 
	header("Expires: 0");
	readfile($filename);
	unlink($filename);
	exit();
}
function multiple_uploads($ids,$accessToken,$userName,$FB){
	$photosdata = array();
	foreach ($ids as $Data) {
		$response = $FB->get("/{$Data}/photos?fields=source&limit=100", $accessToken);
		$userData = $response->getGraphEdge();
		$finalData = array();
		if($FB->next($userData)){
			$dataArray = $userData->asArray();
			$finalData = array_merge($finalData,$dataArray);
			while($userData = $FB->next($userData)){
				$dataArray = $userData->asArray();
				$finalData = array_merge($finalData,$dataArray);
			}
		}else{
			$dataArray = $userData->asArray();
			$finalData = array_merge($finalData,$dataArray);
		}

		foreach ($finalData as $data1) {
		//$imageData = end($Data1['images']);
			$imgSource = isset($data1['source'])?$data1['source']:'';
			array_push($photosdata, $imgSource);
		}
	}
	$zip = new zipArchive;
	$filename = $userName.'allphotos.zip';
	$zip->open($filename,zipArchive::CREATE);
	$i = 1;
	foreach ($photosdata as $file) {
		$zip->addFromString('image'.$i.'.jpg',file_get_contents($file));
		$i = $i + 1;
	}
	$zip->close();
	$url_array = explode('?', 'http://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	$url = $url_array[0];
	require_once 'google-api-php-client/src/Google_Client.php';
	require_once 'google-api-php-client/src/contrib/Google_DriveService.php';
	$client = new Google_Client();
	$client->setClientId('844863073500-9ir7a4e9ph63c58n6nv383b8nfc4mp72.apps.googleusercontent.com');
	$client->setClientSecret('2zbgTFTiJhUZdWhNoldJIAE9');
	$client->setRedirectUri($url);
	$client->setScopes(array('https://www.googleapis.com/auth/drive'));
	$service = new Google_DriveService($client);
	if (isset($_GET['code'])) {
		$_SESSION['accessToken'] = $client->authenticate($_GET['code']);
		header('location:'.$url);exit;
	} elseif (!isset($_SESSION['accessToken'])) {
		$client->authenticate();
	}
	$client->setAccessToken($_SESSION['accessToken']);
	$service = new Google_DriveService($client);
	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	$file = new Google_DriveFile();
	$file_path = $filename;
	$file->setTitle('Facebook_'.$userName.'albums.zip');
	$file->setDescription('A test file');
	$file->setMimeType('application/x-rar-compressed');
	$createdFile = $service->files->insert($file, array(
		'data' => file_get_contents($filename),
		'mimeType' => 'application/zip',
	));
	if ($createdFile == TRUE){
		unlink($filename);
		header('Location:index.php');
	}
}
