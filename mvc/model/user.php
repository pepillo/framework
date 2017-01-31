<?php
class model_user extends storage {
    protected $dbTable    = "user";
    protected $primaryKey = "id";
    protected $timestamps = ['stamp'];

    static $dbFields   = [
        'id'       => ['int'],
        'uid'      => ['text'],
        'name'     => ['text'],
        'email'    => ['text'],
        'password' => ['text'],
        'stamp'    => ['datetime'],
    ];
}
?>
