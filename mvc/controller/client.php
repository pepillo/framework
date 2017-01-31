<?php
require_once(MVC_MODEL.'client.php');

class controller_client extends controller_main{
    public static $table = 'client';
    public static $model = 'model_client';

    public function __construct(){

    }

    public static function getUserClients($user_uid=null, $return_obj=false){
        $clients = model_client::where("user_uid", $user_uid)->get();

        if(is_null($clients)) return [];

        $clients_array = [];

        foreach ($clients as $client) {
            $clients_array[] = $client->data;
        }

        return $clients_array;
    }
}
?>
