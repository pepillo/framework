<?php
require_once(DB_MYSQL.'initialize_db.php');
require_once(MVC_CONTROLLER.'client.php');

function app_start($template, $values){
    global $pueblos;

    $template->menu->addMenuElement('Dashboard', 'dashboard', 'r=home&a=dashboard', null);
    $template->menu->addMenuHeader('Client Manager');
    $template->menu->addMenuElement('My Clients', 'user', 'r=client&a=client_show', null);

    $pueblos = [
        'Adjuntas'      => 'Adjuntas',
        'Aguada'        => 'Aguada',
        'Aguadilla'     => 'Aguadilla',
        'Aguas Buenas'  => 'Aguas Buenas',
        'Aibonito'      => 'Aibonito',
        'Añasco'        => 'Añasco',
        'Arecibo'       => 'Arecibo',
        'Arroyo'        => 'Arroyo',
        'Barceloneta'   => 'Barceloneta',
        'Barranquitas'  => 'Barranquitas',
        'Bayamón'       => 'Bayamón',
        'Cabo Rojo'     => 'Cabo Rojo',
        'Caguas'        => 'Caguas',
        'Camuy'         => 'Camuy',
        'Canóvanas'     => 'Canóvanas',
        'Carolina'      => 'Carolina',
        'Cataño'        => 'Cataño',
        'Cayey'         => 'Cayey',
        'Ceiba'         => 'Ceiba',
        'Ciales'        => 'Ciales',
        'Cidra'         => 'Cidra',
        'Coamo'         => 'Coamo',
        'Comerí'        => 'Comerí',
        'Corozal'       => 'Corozal',
        'Culebra'       => 'Culebra (Isla municipio)',
        'Dorado'        => 'Dorado',
        'Fajardo'       => 'Fajardo',
        'Florida'       => 'Florida',
        'Guánica'       => 'Guánica',
        'Guayama'       => 'Guayama',
        'Guayanilla'    => 'Guayanilla',
        'Guaynabo'      => 'Guaynabo',
        'Gurabo'        => 'Gurabo',
        'Hatillo'       => 'Hatillo',
        'Hormigueros'   => 'Hormigueros',
        'Humacao'       => 'Humacao',
        'Isabela'       => 'Isabela',
        'Jayuya'        => 'Jayuya',
        'Juana Díaz'    => 'Juana Díaz',
        'Juncos'        => 'Juncos',
        'Lajas'         => 'Lajas',
        'Lares'         => 'Lares',
        'Las Marías'    => 'Las Marías',
        'Las Piedras'   => 'Las Piedras',
        'Loíza'         => 'Loíza',
        'Luquill'       => 'Luquill',
        'Manatí'        => 'Manatí',
        'Maricao'       => 'Maricao',
        'Maunabo'       => 'Maunabo',
        'Mayagüez'      => 'Mayagüez',
        'Moca'          => 'Moca',
        'Morovis'       => 'Morovis',
        'Naguabo'       => 'Naguabo',
        'Naranjito'     => 'Naranjito',
        'Orocovis'      => 'Orocovis',
        'Patillas'      => 'Patillas',
        'Peñuelas'      => 'Peñuelas',
        'Ponce'         => 'Ponce',
        'Quebradillas'  => 'Quebradillas',
        'Rincón'        => 'Rincón',
        'Río Grande'    => 'Río Grande',
        'Sabana Grande' => 'Sabana Grande',
        'Salinas'       => 'Salinas',
        'San Germán'    => 'San Germán',
        'San Juan'      => 'San Juan',
        'San Lorenzo'   => 'San Lorenzo',
        'San Sebastián' => 'San Sebastián',
        'Santa Isabel'  => 'Santa Isabel',
        'Toa Alt'       => 'Toa Alt',
        'Toa Baja'      => 'Toa Baja',
        'Trujillo Alto' => 'Trujillo Alto',
        'Utuado'        => 'Utuado',
        'Vega Alta'     => 'Vega Alta',
        'Vega Baja'     => 'Vega Baja',
        'Vieques'       => 'Vieques (Isla municipio)',
        'Villalba'      => 'Villalba',
        'Yabucoa'       => 'Yabucoa',
        'Yauco'         => 'Yauco',
    ];
}

function app_event_client_show($template, $values){
    $template->setTitle('Client Manager');
    $template->setHeader('Client Manager', 'Manage you clients data');
    $template->setBreadcrumb(['Clients'=>null]);

    $table = ui_table::newTable('table1');

    $table->addHeader('name', 'Name');
    $table->addHeader('email','Email');
    $table->addHeader('phone','Phone');
    $table->addHeader('search_location','Location Interest');

    //$table->addAction('eye',    'r=client&a=client_view&uid=uid%');
    $table->addAction('pencil', 'r=client&a=client_edit&uid=uid%');
    $table->addAction('trash',  'r=client&a=client_remove&uid=uid%');

    $clients = controller_client::getUserClients(1);
    foreach ($clients as $client) {
        $table->addRow($client);
    }

    $container = ui_container::newContainer();

    $item = new ctr_hidden('r', 'client');
    $container->appendItem($item);

    $item = new ctr_hidden('a', 'client_edit');
    $container->appendItem($item);

    $container->setTitle('Client List');
    //$container->addLinkBtn('Add Client', 'r=client&a=client_add');
    $container->addSubmitBtn('Add Client');
    $container->appendItem($table);

    //$container->appendItem("<a href='?r=client&a=client_add'>Add Client</a>");

    $template->write($container);
    //$template->write($clients, true);
    //
    $responsive =
    '<!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>ID</th>
                  <th>User</th>
                  <th>Date</th>
                  <th>Status</th>
                  <th>Reason</th>
                </tr>
                <tr>
                  <td>183</td>
                  <td>John Doe</td>
                  <td>11-7-2014</td>
                  <td><span class="label label-success">Approved</span></td>
                  <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                </tr>
                <tr>
                  <td>219</td>
                  <td>Alexander Pierce</td>
                  <td>11-7-2014</td>
                  <td><span class="label label-warning">Pending</span></td>
                  <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                </tr>
                <tr>
                  <td>657</td>
                  <td>Bob Doe</td>
                  <td>11-7-2014</td>
                  <td><span class="label label-primary">Approved</span></td>
                  <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                </tr>
                <tr>
                  <td>175</td>
                  <td>Mike Doe</td>
                  <td>11-7-2014</td>
                  <td><span class="label label-danger">Denied</span></td>
                  <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                </tr>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->';

      //$template->write($responsive);
}

function app_event_client_save($template, $values){
    //echo "<pre>".print_r($values,true)."</pre>";exit;
    $data = [
        'id' => $values['id'],
        'user_id' => 1,
        'uid' => uniqid(),
        'name' => $values['name'],
        'email' => $values['email'],
        'phone' => $values['phone'],
        'current_location' => $values['current_location'],
        'search_location' => (isset($values['search_location'])) ? implode(",", $values['search_location']) : '',
        'income' => $values['income'],
        'debt' => $values['debt'],
        'credit_score' => $values['credit_score'],
        'note' => (isset($values['note'])) ? $values['note'] : '',
        'marriage_contract' => (isset($values['marriage_contract'])) ? 1 : 0,
        'spouse_name' => $values['spouse_name'],
        'spouse_income' => $values['spouse_income'],
        'spouse_credit_score' => $values['spouse_credit_score'],
    ];

    //echo "<pre>".print_r($data,true)."</pre>";exit;

    if($data['id'] > 0){
        //update
        controller_client::updateClient($data);
    } else {
        //add
        controller_client::addClient($data);
    }

    header('location: ?r=client&a=client_show');
}

function app_event_client_view($template, $values){
    $template->write($values, true);
    //$template->write(get_all_client(), true);
}

function app_event_client_edit($template, $values){
    global $pueblos;

    if(isset($values['uid'])){
        $client = controller_client::getByUID($values['uid']);
    } else {
        $client = controller_client::newClient();
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
    controller_client::removeClient($values['uid']);
    header('location: ?r=client&a=client_show');
}

function app_event_default($template, $values){

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
