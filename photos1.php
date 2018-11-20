<?php 
require_once "config.php";
$album_id = isset($_GET['album_id'])?$_GET['album_id']:header("Location: index.php");
$accessToken = isset($_GET['access_token'])?$_GET['access_token']:header("Location: index.php");