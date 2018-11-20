<?php  
require_once "config.php";
require_once "function.php";
$accessToken = $_SESSION['fbaccess_token'];
$userName = $_SESSION['userName'];
//downloading multiple albums in single zip file
if (isset($_REQUEST['multiple_down'])) {
	if($ids = $_REQUEST['select']){
	multiple_downloads($ids,$accessToken,$userName,$FB);
	}
else {
	echo '<script>alert("no album selected.");</script>';
	header("Location: index.php");
}
}
//uploading multiple albums into drive in single zip file.
if (isset($_REQUEST['multiple_upload'])) {
	if($ids = $_REQUEST['select'])
	{
	multiple_uploads($ids,$accessToken,$userName,$FB);
}
else {
	echo '<script>alert("no album selected.");</script>';
	header("Location: index.php");
}
}

