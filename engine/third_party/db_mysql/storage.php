<?php
class storage extends dbObject {

    public static function getArrayFields(){
        $class_call = get_called_class();

        foreach ($class_call::getFields() as $key => $value) {
            $array[$key] = '';
        }

        return $array;
    }
}
?>
