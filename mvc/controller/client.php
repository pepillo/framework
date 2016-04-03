<?php
require_once(MVC_MODEL.'client.php');

class controller_client{

    public function __construct(){

    }

    public static function getByID(){

    }

    public static function getByUID($uid=''){
        $client = model_client::where("uid", $uid)->get();

        if(count($client) > 0){
            return $client[0]->data;
        } else {
            return null;
        }
    }

    public static function newClient(){
        $newClients = model_client::getArrayFields();
        $newClients['id'] = -1;

        return $newClients;
    }

    public static function addClient($data){
        unset($data['id']);
        $client = new model_client($data);
        $id = $client->save();

        if ($id == null) {
            //print_r($client->errors);
            //echo $db->getLastError;
        } //else
            //echo "user created with id = " . $id;
    }

    public static function updateClient($data){
        $client = model_client::byId($data['id']);
        $client->save($data);
    }

    public static function removeClient($uid){
        //$client = model_client::byId($uid);
        //$client->save($data);
        global $db;
        
        $db->where('uid', $uid);
        $db->delete('client');
    }

    public static function getUserClients($user_id=null, $return_obj=false){
        $clients = model_client::where("user_id", $user_id)->get();

        $clients_array = [];

        foreach ($clients as $client) {
            $clients_array[] = $client->data;
        }

        return $clients_array;
    }
}
?>
