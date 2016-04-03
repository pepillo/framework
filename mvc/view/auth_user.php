<?php
function app_start($template, $values){
    $template->setTitle('RealtorHeart - Login');
    $template->setTemplateSource('empty.html');
}

function app_event_default($template, $values){
    $body_variable = [
        'error' => '',
    ];

    if(isset($values['submit'])){
        if($values['email']=='luisdelgadorealty@gmail.com' && $values['password']=='123Delgado#'){
            activateLoginSeccion();
        } elseif ($values['email']=='admin' && $values['password']=='admin') {
            activateLoginSeccion();
        }else {
            $body_variable['error'] = '<i class="fa fa-times-circle-o"></i> Invalid login credentials.';
        }
    }

    $body_part_obj = body_part::newBodyPart('login.html', $body_variable);

    $body = '';
    //$body .= '<pre>'.print_r($values, true).'</pre>';
    //$body .= '<pre>'.print_r($_SESSION, true).'</pre>';
    $body .= $body_part_obj->getHTML();

    $template->addVariable('%BODY%', $body);
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

function activateLoginSeccion(){
    $user = [
        'id' => 1,
        'uid' => 'luisdelgadorealty',
        'email' => 'luisdelgadorealty@gmail.com',
        'name' => 'Jose L Delgado',
        'login_stamp' => time(),
    ];

    $_SESSION['user_session'] = $user;

    header('location: ?r=home&a=dashboard');
}

?>
