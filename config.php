<?php
    session_start();
	use Facebook\Facebook;
	require_once "Facebook/autoload.php";
	$FB = new \Facebook\Facebook([
		'app_id' => '523737744738961',
		'app_secret' => 'fbdcf27c78b4f46a1be153b2e86e39d1',
		'default_graph_version' => 'v3.1',
		'default_access_token' => 'APP-ID|APP-SECRET'
	]);
	$helper = $FB->getRedirectLoginHelper();
