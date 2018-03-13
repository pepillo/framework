<?php
require_once(DB_MYSQL.'initialize_db.php');
require_once(MVC_CONTROLLER.'user.php');

function app_start($template, $values){
    global $user_login;

    $template->setTitle('RealtorHeart - Login');
    $template->setTemplateSource('empty.html');

    if(isset($_SESSION['user_session'])){
        header('location: ?r=home&a=dashboard');
    }
}

function app_event_default($template, $values){
    $body_variable = [
        'success'       => '',
        'error'         => '',
        'href_forgot'   => '?r=auth_user&a=forgot_email',
        'href_register' => '?r=auth_user&a=register_account',
    ];

    if(isset($values['email']) && isset($values['password'])){
        $user = model_user::where('email',    $values['email'])
                          ->where('password', $values['password'])
                          ->getOne();

        if(!is_null($user)){
            activateLoginSeccion($user);
        } else {
            $body_variable['error'] = '<i class="fa fa-times-circle-o"></i> Invalid login credentials.';
        }
    }

    $body_part_obj = body_part::newBodyPart('login.html', $body_variable);

    $body = $body_part_obj->getHTML();

    $template->addVariable('%BODY%', $body);
}

function app_event_register_account($template, $values){
    $body_part     = 'register.html';
    $body_variable = [
        'error'        => '',
        'success'      => '',
        'href_sign_in' => '?r=auth_user',

        'name'             => isset($values['name'])             ? $values['name']             : '',
        'email'            => isset($values['email'])            ? $values['email']            : '',
        'password'         => isset($values['password'])         ? $values['password']         : '',
        'password_confirm' => isset($values['password_confirm']) ? $values['password_confirm'] : '',
    ];

    if(isset($values['submit'])){
        $insert = controller_user::insertUserTempAccount($values);

        if($insert === true){
            $body_part = 'login.html';
            $body_variable['success'] = '<h4>Thank You!</h4><p>Please check your email ('.$values['email'].') to activate your account.</p>';
        } else {
            $body_variable['error'] = $insert;
        }
    }

    $body_part_obj = body_part::newBodyPart($body_part, $body_variable);

    $body = $body_part_obj->getHTML();

    $template->addVariable('%BODY%', $body);
}

function app_event_validate_email($template, $values){
    if(!isset($values['email']) || !isset($values['key'])){
        app_event_logout($template, $values);
        return;
    }

    $user_temp = model_user_temp::where('email',          $values['email'])
                                ->where('validation_key', $values['key'])
                                //->where('status',         0)
                                ->getOne();

    if($user_temp->status == 1){
        #TODO
        #Account has already been validates
        return;
    }

    if(is_null($user_temp)){
        #TODO
        #ERROR, not found in db
        return;
    }

    $user_new = new model_user([
        'uid'      => strtoupper(uniqid('UID')),
        'name'     => $user_temp->name,
        'email'    => $user_temp->email,
        'password' => $user_temp->password,
        'stamp'    => date('Y-m-d H:i:s'),
    ]);

    if($user_new->save() && $user_temp->save(['status'=>1])){
        #TODO::Set messag box indicatind email has been verify
        activateLoginSeccion($user_new);
        return;
    }

    /*
    $out = '<pre>'.print_r($values, true).'</pre>';
    $out .= '<pre>'.print_r($user_temp->data, true).'</pre>';
    $out .= '<pre>'.print_r($user_new, true).'</pre>';

    $template->addVariable('%BODY%', $out);
    */
}

function app_event_forgot_email($template, $values){

}

function app_event_logout($template, $values){
    session_destroy();
    session_unset();

    header('location: ?r=auth_user&a=default');
}

function app_end(){

}

function initialize_application(&$properties){
    //$properties->name = 'dashboard';
    //$properties->uid = 'rh_dashboard';
    //$properties->use_view_helpers = 'scr_helper_*.php';
    $properties['use_auth'] = false;

    return true;
}

function activateLoginSeccion($user){
    $user_login = $user->toArray();
    $user_login['login_stamp'] = time();

    $_SESSION['user_session'] = $user_login;

    header('location: ?r=home&a=dashboard');
}

?>
