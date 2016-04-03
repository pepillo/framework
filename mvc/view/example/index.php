<?php
//require_once(THIRD_PARTY_DIR.'dompdf/autoload.inc.php');
//use Dompdf\Dompdf;

#This is called at the start (before) the call of any app_event
function app_start($template, $values){
    $template->menu->addMenuHeader('MAIN NAVIGATION');
    $template->menu->addMenuElement('Dashboard', 'dashboard', 'r=home&a=dashboard', null);

    $template->menu->addMenuHeader('EXAMPLE NAVIGATION');
    $template->menu->addMenuElement('Example Landing', 'star', 'r=example&a=default', null);

    $template->menu->addMenuElement('Basic Layout', 'map-o', 'r=example&a=basic_layout', null);
    $template->menu->addMenuElement('Form', 'list-alt', 'r=example&a=form', null);
    $template->menu->addMenuElement('Table', 'table', 'r=example&a=table', null);

    $template->menu->addMenuElement('Dropdown Menu', 'list', [
        ['label' => 'Test Example 1','href' => 'r=example&a=default1'],
        ['label' => 'Test Example 1','href' => 'r=example&a=default2'],
    ]);
}

#If no action found use default
function app_event_default($template, $values){
    $template->write('<b>Example Landing</b>');
}

function app_event_form($template, $values){
    $template->setTitle('Form');
    $template->setHeader('Form Example', 'Yes this is a form');
    $template->setBreadcrumb(['Example'=>'r=example&a=default', 
                              'Form'=>null]);

    if(isset($values['some_id'])){
         $template->write($values, true);#true parameter -> echo debug
         return;
    }

    $data = [
        'some_id' => '12345',
        'name' => 'Jose Delgado',
        'email' => 'jose.delgado@gmail.com',
        'phone' => '5555555555',
        'location' => 'camuy',
        'money' => '9999',
        'slider' => '500;700',
        'note' => 'Some Lorem',
        'bool' => '1',
    ];

    $container = ui_container::newContainer();
    $container->setTitle('This is a Form');

    $item = new ctr_hidden('r', 'example');
    $container->appendItem($item);

    $item = new ctr_hidden('a', 'form');
    $container->appendItem($item);

    $item = new ctr_hidden('some_id', $data['some_id']);
    $container->appendItem($item);

    $item = new ctr_label('ID', $data['some_id']);
    $container->appendItem($item);

    $item = new ctr_text('Name', 'name', $data['name'], 'Input Name...');
    $container->appendItem($item);

    $item = new ctr_text_icon('at', 'email', 'Email', $data['email'], 'Input Email...');
    $container->appendItem($item);

    $item = new ctr_text_icon('phone', 'phone', 'Phone', $data['phone'], 'Input Phone...', '(999) 999-9999');
    $container->appendItem($item);

    $dropdown = ['camuy'=>'Camuy','hatillo'=>'Hatillo','arecibo'=>'Arecibo'];
    $item = new ctr_dropdown('Location', 'location', $data['location'], $dropdown);
    $container->appendItem($item);

    $item = new ctr_currency('Money', 'money', $data['money'], 'width:100px;');
    $container->appendItem($item);

    $item = new ctr_slider('Slider', 'slider', $data['slider'], [300,850]);
    $container->appendItem($item);

    $item = new ctr_text_box('Note', 'note', $data['note'], 'Enter a description...');
    $container->appendItem($item);

    $item = new ctr_bool('Bool', 'bool', $data['bool']);
    $container->appendItem($item);

    $container->addSubmitBtn('Submit Button');

    $template->write($container);
}

function app_event_pdf($template, $values){
    $template->write('<b>Table Landing</b>');
}

function app_event_table($template, $values){
    $template->setTitle('Basic Table');
    $template->setHeader('Table Example', 'Yes this is a table');
    $template->setBreadcrumb(['Example'=>'r=example&a=default', 
                               'Table'=>null]);

    $container = ui_container::newContainer();
    $container->setTitle('This is a Table');

    $table = ui_table::newTable('table1');

    $table->addHeader('name', 'Name');
    $table->addHeader('email','Email');
    $table->addHeader('phone','Phone');

    $table->addAction('pencil', 'r=not_exist&a=not_exist&uid=uid%');
    $table->addAction('trash',  'r=not_exist&a=not_exist&uid=uid%');

    $tr = ['name'=>'Jose Delgado', 'email'=>'jose.delgado@gmail.com', 'phone'=>'555-555-5555'];
    $table->addRow($tr);

    $tr = ['name'=>'John Delgado', 'email'=>'john.delgado@gmail.com', 'phone'=>'555-777-5555'];
    $table->addRow($tr);

    $container->appendItem($table);

    $template->write($container);
}

function app_event_basic_layout($template, $values){
    $template->setTitle('Basic Layout');
    $template->setHeader('Basic Layout Example', 'Yes this is a basic layout');
    $template->setBreadcrumb(['Example'=>'r=example&a=default', 
                               'Layout'=>null]);

    $container = ui_container::newContainer();
    $container->setTitle('This is a container');

    $container->appendItem("<div style='height: 300px;'>Body Content</div>");
    $container->addSubmitBtn('Button Footer');

    $template->write($container);
}

function app_event_test_pdf($template, $values){
    // instantiate and use the dompdf class
    $dompdf = new Dompdf();
    $dompdf->loadHtml('<h1>hello world</h1>');
    // (Optional) Setup the paper size and orientation
    $dompdf->setPaper('A4', 'landscape');
    // Render the HTML as PDF
    $dompdf->render();
    // Output the generated PDF to Browser
    //$dompdf->stream();
    //$dompdf->stream("dompdf_out.pdf", array("Attachment" => false));
    //exit(0);
    //$dompdf->output();
    //$dompdf->outputHtml();
    //$template->write($dompdf->output(),true);
    $x = '<iframe type="application/pdf"
                width="95%"
                height="95%"
                src="data:application/pdf;">
          Oops, you have no support for iframes.
        </iframe></p';

    $y = '<embed width="600" height="450" src="?r=home&a=pdf&content='.urlencode($dompdf->output()).'" type="application/pdf"></embed>';

    #or

    
   
    $template->write($y);
    //$template->write($x);
}

function app_event_pdf2($template, $values){
    $content = $values['content'];
    header('Cache-Control: public'); 
    header('Content-Type: application/pdf');
    header('filename="some-file.pdf"');
    //header('Content-Length: '.filesize($content));

    echo $content;
}

#This is called at the end (after) the call of any app_event
function app_end(){

}

#Template/Framework variable configuration
function initialize_application(&$properties){
    //$properties->name = 'dashboard';
    //$properties->uid = 'rh_dashboard';
    //$properties->use_view_helpers = 'scr_helper_*.php';
    #Require auth (LOGIN)
    $properties['use_auth'] = true;

    return true;
}
?>
