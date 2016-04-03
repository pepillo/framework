<?php
/**
 * To make IDEs autocomplete happy
 *
 * @property int id
 * @property string login
 * @property bool active
 * @property string customerId
 * @property string firstName
 * @property string lastName
 * @property string password
 * @property string createdAt
 * @property string updatedAt
 * @property string expires
 * @property int loginCount
 */
class user extends dbObject {
    protected $dbTable = "user";
    protected $primaryKey = "id";
    protected $dbFields = Array (
        'name' => Array('text', 'required'),
        'age' => Array ('text', 'required'),
    );
    /*
    protected $timestamps = Array ('createdAt', 'updatedAt');
    protected $relations = Array (
        'products' => Array ("hasMany", "product", 'userid')
    );
    */
}
?>
