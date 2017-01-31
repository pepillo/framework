<?php
class controller_main{
    public static function getByID(){

    }

    public static function getByUID($uid='', $validate_user=true){
        global $user_login;

        $model = self::getModel();

        $rs = $model::where("uid", $uid);

        if($validate_user){
            $rs->where("user_uid", $user_login['uid']);
        }

        $rs->getOne();

        if(!is_null($rs)){
            return $rs->toArray();
        } else {
            return null;
        }
    }

    public static function newEntry(){
        $model = self::getModel();

        $rs = $model::getArrayFields($has_uid);
        $rs['id']  = -1;

        if(isset($rs['uid'])){
            $rs['uid'] = -1;
        }

        return $rs;
    }

    public static function addEntry($data){
        $model = self::getModel();

        unset($data['id']);

        $rs = new $model($data);
        $id = $rs->save();

        if($id == null) {
            //print_r($client->errors);
            //echo $db->getLastError;
            return false;
        } else {
            //echo "user created with id = " . $id;
            return true;
        }
    }

    public static function updateEntry($data, $validate_user=true){
        global $user_login;

        $model = self::getModel();

        $rs = $model::where("uid", $data['uid']);

        if($validate_user){
            $rs->where("user_uid", $user_login['uid']);
        }

        $rs->getOne();

        $rs->update($data);
    }

    public static function remove($uid, $validate_user=true){
        global $db, $user_login;;

        $table = self::getTable();

        $db->where('uid', $uid);

        if($validate_user){
            $db->where('user_uid', $user_login['uid']);
        }

        $db->delete($table);
    }

    private static function getModel(){
        $class_call = get_called_class();
        return $class_call::$model;
    }

    private static function getTable(){
        $class_call = get_called_class();
        return $class_call::$table;
    }
}
?>
