<?php
class model_client extends storage {
    protected $dbTable    = "client";
    protected $primaryKey = "id";
    protected $timestamps = ['stamp'];

    protected $dbFields   = [
        'id'                  => ['int'],
        'user_uid'            => ['text'],
        'uid'                 => ['text'],
        'name'                => ['text'],
        'email'               => ['text'],
        'phone'               => ['text'],
        'current_location'    => ['text'],
        'search_location'     => ['text'],
        'income'              => ['text'],
        'debt'                => ['text'],
        'credit_score'        => ['text'],
        'note'                => ['text'],
        'marriage_contract'   => ['bool'],
        'spouse_name'         => ['text'],
        'spouse_income'       => ['text'],
        'spouse_credit_score' => ['text'],
        'attr'                => ['text'],
        'visible'             => ['bool'],
        'stamp'               => ['datetime'],
    ];

    public static function getFields(){
        $object = new model_client();
        return $object->dbFields;
    }

    #TODO relation with user db
}
?>
<?php
/*
class user extends dbObject {
    protected $dbTable = "users";
    protected $dbFields = Array (
        'login' => Array ('text', 'required'),
        'active' => Array ('bool'),
        'customerId' => Array ('int'),
        'firstName' => Array ('/[a-zA-Z0-9 ]+/'),
        'lastName' => Array ('text'),
        'password' => Array ('text'),
        'createdAt' => Array ('datetime'),
        'updatedAt' => Array ('datetime'),
        'expires' => Array ('datetime'),
        'loginCount' => Array ('int')
    );
    protected $timestamps = Array ('createdAt', 'updatedAt');
    protected $relations = Array (
        'products' => Array ("hasMany", "product", 'userid')
    );
}
*/
?>
