<?php
	session_start();

	require_once "Facebook/autoload.php";

	$FB = new \Facebook\Facebook([
		'app_id' => '452802058881452',
		'app_secret' => '248c96544fc465a30d16cbe4a0ec49ea',
		// 'default_graph_version' => 'v2.10'
		'default_graph_version' => 'v3.2'
	]);

	$helper = $FB->getRedirectLoginHelper();
?>
