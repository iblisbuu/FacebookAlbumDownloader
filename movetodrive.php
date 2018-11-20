<?php
require_once "config.php";
$album_id = isset($_GET['album_id'])?$_GET['album_id']:header("Location: index.php");
$album_name = isset($_GET['album_name'])?$_GET['album_name']:header("Location: index.php");
$accessToken = isset($_GET['access_token'])?$_GET['access_token']:header("Location: index.php");
$userName = $_SESSION['userName'];
$error = "$userName. Your album has been moved to drive. ";
$fields = "id,source,images,name";
$graphPhoLink = "https://graph.facebook.com/v2.10/{$album_id}/photos?fields={$fields}&limit=200&access_token={$accessToken}";
$jsonData = file_get_contents($graphPhoLink);
$fbPhotoObj = json_decode($jsonData, true, 512, JSON_BIGINT_AS_STRING);
$fbPhotoData = $fbPhotoObj['data'];
$photosUrl = array();
foreach($fbPhotoData as $data){
    $imageData = end($data['images']);
    $imgId = isset($data['id'])?$data['id']:'';
    $imgSource = isset($imageData['source'])?$imageData['source']:'';
    $name = isset($data['name'])?$data['name']:'';
    array_push($photosUrl, $imgSource);
}
	$zip = new zipArchive;
	$filename = $album_name.'.zip';
	$zip->open($filename,zipArchive::CREATE);
	$i = 1;
	foreach ($photosUrl as $file) {
		$zip->addFromString('image'.$i.'.jpg',file_get_contents($file));
		$i = $i + 1;
	}
	$zip->close();
$url_array = explode('?', 'https://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
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
      'mimeType' => 'text/plain',
	));
	if ($createdFile == TRUE) {
		unlink($filename);
		header('Location:index.php');
		echo "<script type='text/javascript'>alert(<?php echo $error; ?>);</script>";
	}exit;
