<?php
require_once(DB_MYSQL.'initialize_db.php');
require_once(MVC_CONTROLLER.'client.php');
require_once(SPREADSHEET);

function app_start($template, $values){
    global $pueblos;

    $template->menu->addMenuElement('Dashboard', 'dashboard', 'r=home&a=dashboard', null);
    $template->menu->addMenuHeader('Client Manager');
    $template->menu->addMenuElement('My Clients', 'user', 'r=client&a=client_show', null);
}

function app_event_client_show($template, $values){
    global $user_login;

    $template->setTitle('Client Manager');
    $template->setHeader('Client Manager', 'Manage you clients data');
    $template->setBreadcrumb(['Clients'=>null]);

    $table = ui_table::newTable('table1');

    $table->addHeader('count','#');
    $table->addHeader('name', 'Name');
    $table->addHeader('email','Email');
    $table->addHeader('phone','Phone');
    $table->addHeader('search_location','Location Interest');

    $table->addAction('address-card-o', 'r=client&a=client_view&uid=uid%');
    $table->addAction('pencil',         'r=client&a=client_edit&uid=uid%');
    $table->addAction('trash',          'r=client&a=client_remove&uid=uid%');

    $clients = controller_client::getUserClients($user_login['uid']);
    foreach ($clients as $index => $client){
        $client['count'] = ($index+1);
        $table->addRow($client);
    }

    $container = ui_container::newContainer();

    $item = new ctr_hidden('r', 'client');
    $container->appendItem($item);

    $item = new ctr_hidden('a', 'client_edit');
    $container->appendItem($item);

    $container->setTitle('Client List');
    $container->addSubmitBtn('Add Client');
    $container->appendItem($table);

    $container->addLinkBtn('Download Excel', 'r=client&a=client_csv', 'right-float');

    $template->write($container);
}

function app_event_client_save($template, $values){
    global $user_login;

    $data = [
        'id'                  => $values['id'],
        'uid'                 => $values['uid'],
        'user_uid'            => $user_login['uid'],
        'name'                => $values['name'],
        'email'               => $values['email'],
        'phone'               => $values['phone'],
        'current_location'    => $values['current_location'],
        'search_location'     => (isset($values['search_location'])) ? implode(",", $values['search_location']) : '',
        'income'              => $values['income'],
        'debt'                => $values['debt'],
        'credit_score'        => $values['credit_score'],
        'note'                => (isset($values['note'])) ? $values['note'] : '',
        'marriage_contract'   => (isset($values['marriage_contract'])) ? 1 : 0,
        'spouse_name'         => $values['spouse_name'],
        'spouse_income'       => $values['spouse_income'],
        'spouse_credit_score' => $values['spouse_credit_score'],
    ];

    if($data['id'] > 0){
        #TODO: Should check if valid record in DB first
        controller_client::updateEntry($data);
    } else {
        $data['uid']   = uniqid();
        $data['stamp'] = date('Y-m-d H:i:s');

        controller_client::addEntry($data);
    }

    $template->showSuccess('Client has been '.(($data['id'] > 0) ? 'updated.' : 'saved.'));

    header('location: ?r=client&a=client_show');
}

function app_event_client_view($template, $values){
    global $user_login;

    $client_uid = isset($values['uid']) ? $values['uid'] : null;
    $client = controller_client::getByUID($client_uid);

    if(is_null($client)){
        $template->setBreadcrumb(['Error'=>null]);
        $callout = new ctr_callout('Error', 'Client not found.');

        $template->write($callout->error());
        return;
    }

    $template->setTitle('Client Manager');
    $template->setHeader('Client - '.$client['name'], 'View clients data');
    $template->setBreadcrumb(['Clients'=>'r=client&a=client_show', $client['name']=>null]);

    $container_multi = ui_container_multi::newContainerMulti(6);

    #CLIENT INFO
    $container = ui_container::newContainer();
    $container->setTitle('Client Information', 'address-card-o');

    $item = new ctr_label('Name', $client['name']);
    $container->appendItem($item);

    $item = new ctr_label('Email', $client['email']);
    $container->appendItem($item);

    $item = new ctr_label('Phone', $client['phone']);
    $container->appendItem($item);

    $item = new ctr_label('Marriage Contract', $client['marriage_contract_display']);
    $container->appendItem($item);

    $item = new ctr_label('Location', $client['current_location']);
    $container->appendItem($item);

    $item = new ctr_label('Search Locations', $client['search_location_display']);
    $container->appendItem($item);

    $item = new ctr_label('Note', $client['note']);
    $container->appendItem($item);

    $container_multi->appendItem($container);

    ####################################################################################

    #CLIENT FINANCE INFO
    $container = ui_container::newContainer();
    $container->setTitle('Client Finance Information', 'money');

    $item = new ctr_label('Income', '$'.$client['income']);
    $container->appendItem($item);

    $item = new ctr_label('Debt', '$'.$client['debt']);
    $container->appendItem($item);

    $item = new ctr_slider('Credit Score', 'credit_score', $client['credit_score'], [300,850]);
    $container->appendItem($item);

    $container_multi->appendItem($container);

    ####################################################################################

    #CLIENT SPOUSE FINANCE INFO
    $container = ui_container::newContainer();
    $container->setTitle('Spouse Information', 'street-view');

    $item = new ctr_label('Name', $client['spouse_name']);
    $container->appendItem($item);

    $item = new ctr_label('Income', '$'.$client['spouse_income']);
    $container->appendItem($item);

    $item = new ctr_slider('Credit Score', 'credit_score', $client['spouse_credit_score'], [300,850]);
    $container->appendItem($item);

    $container_multi->appendItem($container);

    $template->write($container_multi);

    ####################################################################################

    #ADD CLIENT COMMENT LOG
    $container = ui_container::newContainer();
    $container->setTitle('Add Client Comments', 'plus-square');

    $item = new ctr_hidden('r', 'client');
    $container->appendItem($item);

    $item = new ctr_hidden('a', 'client_add_client_log');
    $container->appendItem($item);

    $item = new ctr_hidden('client_uid', $client['uid']);
    $container->appendItem($item);

    $item = new ctr_text_box('Comment', 'comment', '', 'Enter a comment for this client...', 2);
    $container->appendItem($item);

    $container->addSubmitBtn('Add Comment');

    $template->write($container);

    ####################################################################################

    #CLIENT COMMENT LOG
    $container = ui_container::newContainer();
    $container->setTitle('Client Comments', 'calendar');

    $table = ui_table_list::newTable('table_log');

    $table->addHeader('stamp_display', 'Date', '200');
    $table->addHeader('comment','Comment');

    $client_logs = controller_client::getClientLogs($user_login['uid'], $client['uid']);

    foreach($client_logs as $log){
        $table->addRow($log);
    }

    $container->appendItem($table);

    $template->write($container);
}

function app_event_client_edit($template, $values){
    global $pueblos, $user_login;

    $client_uid = isset($values['uid']) ? $values['uid'] : null;

    if(!is_null($client_uid)){
        $client = controller_client::getByUID($client_uid);
    } else {
        $client = controller_client::newEntry();
    }

    if(is_null($client)){
        $template->setBreadcrumb(['Error'=>null]);
        $callout = new ctr_callout('Error', 'Client not found.');

        $template->write($callout->error());
        return;
    }

    $name = 'New Client';

    if(!empty($client['name'])){
        $name = $client['name'];
    }

    $template->setTitle('Client Manager');
    $template->setHeader('Client - '.$name, 'Manage you clients data');
    $template->setBreadcrumb(['Clients'=>'r=client&a=client_show', $name=>null]);

    $container = ui_container::newContainer();
    $container->setTitle('Client Information');

    $item = new ctr_hidden('r', 'client');
    $container->appendItem($item);

    $item = new ctr_hidden('a', 'client_save');
    $container->appendItem($item);

    $item = new ctr_hidden('id', $client['id']);
    $container->appendItem($item);

    $item = new ctr_hidden('uid', $client['uid']);
    $container->appendItem($item);

    $item = new ctr_text('Name', 'name', $client['name'], 'Input Name...');
    $container->appendItem($item);

    $item = new ctr_text_icon('at', 'email', 'Email', $client['email'], 'Input Email...');
    $container->appendItem($item);

    $item = new ctr_text_icon('phone', 'phone', 'Phone', $client['phone'], 'Input Phone...', '(999) 999-9999');
    $container->appendItem($item);

    $item = new ctr_dropdown('Location', 'current_location', $client['current_location'], $pueblos);
    $container->appendItem($item);

    $item = new ctr_multibox('Search Location', 'search_location', $client['search_location'], $pueblos);
    $container->appendItem($item);

    $item = new ctr_currency('Income', 'income', $client['income'], 'width:100px;');
    $container->appendItem($item);

    $item = new ctr_currency('Debt', 'debt', $client['debt'], 'width:100px;');
    $container->appendItem($item);

    $item = new ctr_slider('Credit Score', 'credit_score', $client['credit_score'], [300,850]);
    $container->appendItem($item);

    $item = new ctr_text_box('Note', 'note', $client['note'], 'Enter a description...');
    $container->appendItem($item);

    $item = new ctr_bool('Marriage Contract', 'marriage_contract', $client['marriage_contract']);
    $container->appendItem($item);

    $item = new ctr_text('Spouse Name', 'spouse_name', $client['spouse_name'], 'Input Spouse Name...');
    $container->appendItem($item);

    $item = new ctr_currency('Spouse Income', 'spouse_income', $client['spouse_income'], 'width:100px;');
    $container->appendItem($item);

    $item = new ctr_slider('Spouse Credit', 'spouse_credit_score', $client['spouse_credit_score'], [300,850]);
    $container->appendItem($item);

    $container->addSubmitBtn(($client['id']==-1) ? 'Add Client' : 'Update Client');
    $template->write($container);
}

function app_event_client_remove($template, $values){
    if(!isset($values['uid'])){
        $template->setBreadcrumb(['Error'=>null]);
        $callout = new ctr_callout('Error', 'Client not found.');

        $template->write($callout->error());
        return;
    }

    controller_client::remove($values['uid']);

    $template->showInfo('Client has been removed');

    header('location: ?r=client&a=client_show');
}

function app_event_client_add_client_log($template, $values){
    global $user_login;

    $data = [
        'uid'        => uniqid(),
        'user_uid'   => $user_login['uid'],
        'client_uid' => $values['client_uid'],
        'comment'    => $values['comment'],
        'stamp'      => date('Y-m-d H:i:s'),
    ];

    $rs = new model_client_log($data);
    $rs->save();

    $template->showSuccess('Client comment has been added.');

    header('location: ?r=client&a=client_view&uid='.$values['client_uid']);
}

function app_event_client_csv($template, $values){
    global $user_login;

    $clients = controller_client::getUserClients($user_login['uid']);
    $clients = controller_client::getFormat($clients);

    $header = array_keys($clients[0]);
    $header = array_map('strtolower', $header);
    $header = array_map('ucwords', $header);
    $header = str_replace('_', ' ', $header);

    $encode = ['name', 'current_location', 'search_location', 'spouse_name'];

    //$template->write($header, true);
    //return;

    spreadsheet::out('clients_'.date('d_M_Y').'.csv', $clients, $header, $encode);
}

function app_event_default($template, $values){

}

function app_event_test($template, $values){
    $template->write('IN TEMPLATE');
}

function app_end(){

}

function initialize_application(&$properties){
    //$properties->name = 'dashboard';
    //$properties->uid = 'rh_dashboard';
    //$properties->use_view_helpers = 'scr_helper_*.php';
    $properties['use_auth'] = true;

    return true;
}
?>
