<?php
class model_user extends storage {
    protected $dbTable    = "user";
    protected $primaryKey = "id";
    protected $timestamps = ['stamp'];

    protected $dbFields   = [
        'id'       => ['int'],
        'uid'      => ['text'],
        'name'     => ['text'],
        'email'    => ['text'],
        'password' => ['text'],
        'stamp'    => ['datetime'],
    ];
}

class model_user_temp extends storage {
    protected $dbTable    = "user_temp";
    protected $primaryKey = "id";
    protected $timestamps = ['stamp'];

    protected $dbFields = [
        'id'             => ['int'],
        'uid'            => ['text'],
        'name'           => ['text'],
        'email'          => ['text'],
        'password'       => ['text'],
        'validation_key' => ['text'],
        'status'         => ['bool'],
        'stamp'          => ['datetime'],
    ];
}
?>
