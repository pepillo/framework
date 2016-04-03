<?php
class model_client extends dbObject {
    protected $dbTable = "client";
    protected $primaryKey = "id";
    protected $dbFields = Array (
        'id'                  => Array('int'),
        'user_id'             => Array('int'),
        'uid'                 => Array('text'),
        'name'                => Array('text'),
        'email'               => Array('text'),
        'phone'               => Array('text'),
        'current_location'    => Array('text'),
        'search_location'     => Array('text'),
        'income'              => Array('text'),
        'debt'                => Array('text'),
        'credit_score'        => Array('text'),
        'note'                => Array('text'),
        'marriage_contract'   => Array('bool'),
        'spouse_name'         => Array('text'),
        'spouse_income'       => Array('text'),
        'spouse_credit_score' => Array('text'),
        'attr'                => Array('text'),
        'stamp'               => Array('datetime'),
    );
    protected $timestamps = Array ('stamp');
    #TODO relation with user db

    public static function getArrayFields(){
        $client_db = new model_client();
        $array = [];

        foreach ($client_db->dbFields as $key => $value) {
            $array[$key] = '';
        }

        return $array;
    }
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
