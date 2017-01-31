<?php
	require_once('MysqliDb.php');
	require_once('dbObject.php');
	require_once('storage.php');
	require_once('controller_main.php');

	global $db;

	$db_local = [
		'host'     => '127.0.0.1',
        'username' => 'root',
        'password' => 'root',
        'db'	   => 'RealtorHeart',
        'charset'  => 'utf8',
		'port'     => 8889,
        //'prefix' => 'my_',
	];

	$db_server = [
		//'host'   => 'RealtorHeart.db.10882783.hostedresource.com',
		'host' 	   => '173.201.88.28',
		//'host'   => '72.167.233.37',
        'username' => 'RealtorHeart',
        'password' => 'Re@lt0r1',
        'db'	   => 'RealtorHeart',
        'charset'  => 'utf8',
		//'port'   => 8889,
        //'prefix' => 'my_',
	];

	$db_config = in_array($_SERVER["SERVER_ADDR"], ["127.0.0.1","::1"]) ? $db_local : $db_server;

	$db = new MysqliDb ($db_config);
?>
