<?php
require_once(MVC_MODEL.'client.php');
require_once(MVC_MODEL.'client_log.php');

class controller_client extends controller_main{
    public static $table = 'client';
    public static $model = 'model_client';

    public function __construct(){

    }

    public static function getByUID($uid='', $validate_user=true, $validate_visible=true){
        $array = parent::getByUID($uid, $validate_user, $validate_visible);

        if(!is_null($array)){
            $array['marriage_contract_display'] = ($array['marriage_contract']) ? 'Yes' : 'No';
            $array['search_location_display']   = str_replace(',', ', ', $array['search_location']);
        }

        return $array;
    }

    public static function getUserClients($user_uid=null, $return_obj=false){
        $clients = model_client::where('user_uid', $user_uid)->where('visible', 1)->get();

        if(is_null($clients)) return [];

        $clients_array = [];

        foreach($clients as $client) {
            $clients_array[] = $client->toArray();
        }

        return $clients_array;
    }

    public static function getClientLogs($user_uid=null, $client_uid=null, $return_obj=false){
        $client_logs = model_client_log::where('user_uid',   $user_uid)
                                       ->where('client_uid', $client_uid)
                                       ->where('visible',    1)
                                       ->orderBy("stamp", "desc")
                                       ->get();

        if(is_null($client_logs)) return [];

        $client_logs_array = [];

        foreach($client_logs as $log){
            $array = $log->toArray();;
            $array['stamp_display'] = date('d/M/Y h:i A', strtotime($array['stamp']));

            $client_logs_array[] = $array;
        }

        return $client_logs_array;
    }
}
?>
