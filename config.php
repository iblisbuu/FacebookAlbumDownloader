<?php
    session_start();
	use Facebook\Facebook;
	require_once "Facebook/autoload.php";
	$FB = new \Facebook\Facebook([
		'app_id' => '',
		'app_secret' => '',
		'default_graph_version' => 'v3.1',
		'default_access_token' => 'APP-ID|APP-SECRET'
	]);
	$helper = $FB->getRedirectLoginHelper();
