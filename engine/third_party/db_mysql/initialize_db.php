<?php
	require_once('MysqliDb.php');
	require_once("dbObject.php");

	global $db;

	$db = new MysqliDb (Array (
        //'host' => 'RealtorHeart.db.10882783.hostedresource.com',
		'host' => '173.201.88.28',
		//'host' => '72.167.233.37',
        'username' => 'RealtorHeart',
        'password' => 'Re@lt0r1',
        'db'=> 'RealtorHeart',
        'charset' => 'utf8',
		//'port' => 8889,
        //'prefix' => 'my_',
	));
?>
