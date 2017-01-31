<?php
require_once(DB_MYSQL.'initialize_db.php');
require_once(MVC_CONTROLLER.'user.php');

function app_start($template, $values){
    global $user_login;

    $template->setTitle('RealtorHeart - Login');
    $template->setTemplateSource('empty.html');
}

function app_event_default($template, $values){
    if(isset($_SESSION['user_session'])){
        header('location: ?r=home&a=dashboard');
    }

    $body_variable = [
        'error' => '',
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
