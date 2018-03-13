<?php
require_once(MVC_MODEL.'user.php');
require_once(PHPMAILER);

class controller_user extends controller_main{
    public static $table = 'user';
    public static $model = 'model_user';

    private static $new_account_require = [
        'name' => [
            'key'     => 'name',
            'caption' => 'Full Name',
            'require' => true,
            'regex'   => "/^[a-zA-Z ]*$/",
            'regex_error' => 'Full name is not valid! It must not contain numbers or special characters.',
        ],
        'email' => [
            'key'     => 'email',
            'caption' => 'Email',
            'require' => true,
            'regex'   => null,
        ],
        'password' => [
            'key'     => 'password',
            'caption' => 'Password',
            'require' => true,
            'regex'   => null,
            'regex'   => "/^[0-9a-zA-Z]{8,32}$/",
            'regex_error' => 'Password is not valid! Password is alphanumeric, length 8-32.',
        ],
        'password_confirm' => [
            'key'     => 'password_confirm',
            'caption' => 'Retype password',
            'require' => true,
            'regex'   => null,
        ],
    ];

    public function __construct(){

    }

    public static function validUserData($params=null){
        if(!is_array($params)) return 'No params available.';

        $account_data  = [];
        $error_string  = '';

        foreach (self::$new_account_require as $key => $validate_data) {
            if($validate_data['require'] == true && empty($params[$key])){
                $error_string .= '&#9679; Missing parameter "'.$validate_data['caption'].'"<br>';
                continue;
            }

            if($validate_data['regex'] != null && !preg_match($validate_data['regex'], $params[$key])){
                $error_string .= '&#9679; '.$validate_data['regex_error'].'<br>';
                continue;
            }

            $account_data[$key] = $params[$key];
        }

        if((!empty($account_data['password']) && !empty($account_data['password_confirm'])) && $account_data['password'] != $account_data['password_confirm']){
            $error_string .= '&#9679; Password does not match the confirm password.<br>';
        }

        #Verify if missing parameters and formar of account data also if password match
        if(!empty($error_string)){
            return $error_string;
        }

        $user_account = self::$model::where('email', $account_data['email'])->getOne();

        #Verify if account already exist
        if(!is_null($user_account)){
            return '&#9679; Email address is already registered.<br>';
        }

        return true;
    }

    public static function insertUserTempAccount($params=null){
        $is_valid_account_data = self::validUserData($params);

        if($is_valid_account_data !== true){
            return $is_valid_account_data;
        }

        #LOGIC INSERT IN ACCOUNT_TEMP
        controller_user_temp::insertToTemp($params);

        return true;
    }
}

class controller_user_temp extends controller_main{
    public static $table = 'user_temp';
    public static $model = 'model_user_temp';

    public function __construct(){

    }

    public static function insertToTemp(array $params){
        #TODO: Run cron to expire record by set status = 2
        $temp = self::$model::where('email', $params['email'])
                            ->where('status', 0)
                            ->getOne();

        $data = [
            'name'           => $params['name'],
            'email'          => $params['email'],
            'password'       => $params['password'],
            'status'         => 0,
            'validation_key' => uniqid('KEY'),
            'stamp'          => date('Y-m-d H:i:s'),
        ];

        #New Temp User
        if(is_null($temp)){
            $data['uid'] = uniqid();

            self::addEntry($data);
        }
        #Update User Temp Record
        else {
            $data['uid'] = $temp->uid;
            self::updateEntry($data, false, false);
        }

        return self::validationEmail($data);
    }

    private static function validationEmail($user_temp_data){
        $body_part = 'email.html';
        $body_variable = [
            'logo'               => 'http://realtorheart.com/_theme/_img/logo.png',
            'address'            => 'http://realtorheart.com',
            'href_email_confirm' => "http://realtorheart.com/?r=auth_user&a=validate_email&email={$user_temp_data['email']}&key={$user_temp_data['validation_key']}",
        ];

        #DEV
        if(in_array($_SERVER["SERVER_ADDR"], ["127.0.0.1","::1"])){
            $body_variable = [
                'logo'               => 'http://realtorheart.com/_theme/_img/logo.png',//'./_theme/_img/logo.png',
                'address'            => 'http://localhost:8888/GitHub/framework/',
                'href_email_confirm' => "http://localhost:8888/GitHub/framework/?r=auth_user&a=validate_email&email={$user_temp_data['email']}&key={$user_temp_data['validation_key']}",
            ];
        }

        $body_part_obj = body_part::newBodyPart($body_part, $body_variable);
        $html = $body_part_obj->getHTML();

        if(!php_mail::send('jose.delgado12@upr.edu', 'Verify your RealtorHeart.com Account', $html)){
            return true;
        }

        return false;
    }
}
?>
