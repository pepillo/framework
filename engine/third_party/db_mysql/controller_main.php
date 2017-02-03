<?php
class controller_main{
    public static function getByID(){

    }

    public static function getByUID($uid='', $validate_user=true, $validate_visible=true){
        global $user_login;

        if(empty($uid)) return null;

        $model = self::getModel();

        $rs = $model::where("uid", $uid);

        if($validate_user){
            $rs->where("user_uid", $user_login['uid']);
        }

        if($validate_visible){
            $rs->where("visible", 1);
        }

        $rs->getOne();

        if($rs->count > 0){
            return $rs->toArray();
        }

        return null;
    }

    public static function newEntry(){
        $model = self::getModel();

        $rs = $model::getArrayFields();
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

    public static function updateEntry($data, $validate_user=true, $validate_visible=true){
        global $user_login;

        $model = self::getModel();

        $rs = $model::where("uid", $data['uid']);

        if($validate_user){
            $rs->where("user_uid", $user_login['uid']);
        }

        if($validate_visible){
            $rs->where("visible", 1);
        }

        $rs->getOne();

        $rs->update($data);
    }

    public static function remove($uid, $validate_user=true, $make_invisible=true){
        global $db, $user_login;;

        $table = self::getTable();

        $db->where('uid', $uid);

        if($validate_user){
            $db->where('user_uid', $user_login['uid']);
        }

        if($make_invisible){
            $db->update($table, ['visible'=>0]);
            return;
        }

        //$db->delete($table);
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
