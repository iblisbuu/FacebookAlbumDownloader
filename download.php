<?php 
require_once "config.php";
$album_id = isset($_GET['album_id'])?$_GET['album_id']:header("Location: index.php");
$album_name = isset($_GET['album_name'])?$_GET['album_name']:header("Location: index.php");
$userName = $_SESSION['userName'];
	$accessToken = $_SESSION['fbaccess_token'];
// 	$fields = "id,source,images,name";
// 	$graphPhoLink = "https://graph.facebook.com/v2.10/{$album_id}/photos?fields={$fields}&limit=500&access_token={$accessToken}";
// 	$jsonData = file_get_contents($graphPhoLink);
// 	$fbPhotoObj = json_decode($jsonData, true, 512, JSON_BIGINT_AS_STRING);
// 	$fbPhotoData = $fbPhotoObj['data'];
$response = $FB->get("/{$album_id}/photos?fields=source&limit=100", $accessToken);
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
	$photosUrl = array();
foreach($finalData as $data){
    //$imageData = end($data['images']);
    //$imgId = isset($data['id'])?$data['id']:'';
    $imgSource = isset($data['source'])?$data['source']:'';
    //$name = isset($data['name'])?$data['name']:'';
    array_push($photosUrl, $imgSource);
}
	$zip = new zipArchive;
	$filename = $userName.$album_name.'.zip';
	$zip->open($filename,zipArchive::CREATE);
	$i = 1;
	foreach ($photosUrl as $file) {
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