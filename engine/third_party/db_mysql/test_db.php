<?php
	require_once ('MysqliDb.php');
	require_once("dbObject.php");
?>
<?php
	$db = new MysqliDb (Array (
        'host' => 'RealtorHeart.db.10882783.hostedresource.com',
        'username' => 'RealtorHeart',
        'password' => 'Re@lt0r1',
        //'db'=> 'test',
        //'port' => 8889,
        //'prefix' => 'my_',
        'charset' => 'utf8')
	);
	/*
	$data = Array ("name" => "JOSE DELGADO",
               "age" => "23",
	);
	$id = $db->insert ('user', $data);
	if($id)
	    echo 'user was created. Id=' . $id;
	else
    echo 'insert failed: ' . $db->getLastError();
   	*/
?>
<?php
	dbObject::autoload("./../models");

	//$user = dbObject::table("users");
	//$users = dbObject::table('user')->get();
	//$users = user::get();
	//foreach ($users as $u) {
	//  echo $u->name;
	//}
?>
