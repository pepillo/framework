<?php
class model_client_log extends storage {
    protected $dbTable    = "client_log";
    protected $primaryKey = "id";
    protected $timestamps = ['stamp'];

    protected $dbFields   = [
        'id'         => ['int'],
        'uid'        => ['text'],
        'user_uid'   => ['text'],
        'client_uid' => ['text'],
        'comment'    => ['text'],
        'visible'    => ['bool'],
        'stamp'      => ['datetime'],
    ];

    public static function getFields(){
        $object = new model_client_log();
        return $object->dbFields;
    }

}
?>
