<?php 
require_once "config.php";
require_once "function.php";
$accessToken = isset($_GET['access_token'])?$_GET['access_token']:header("Location: index.php");
$userName = $_SESSION['userName'];
$albums = $FB->get('/me?fields=albums{id}',$accessToken)->getGraphNode()->asArray();
	$album = $albums['albums'];
	$allalbumid = array();
	foreach ($album as $data) {
		$albmid = isset($data['id'])?$data['id']:'';
		array_push($allalbumid, $albmid);
	}
	multiple_downloads($allalbumid,$accessToken,$userName,$FB);


	