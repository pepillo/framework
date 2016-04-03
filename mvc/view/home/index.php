<?php
require_once(THIRD_PARTY_DIR.'dompdf/autoload.inc.php');
use Dompdf\Dompdf;

function app_start($template, $values){
    $template->menu->addMenuHeader('MAIN NAVIGATION');
    $template->menu->addMenuElement('Dashboard', 'dashboard', 'r=home&a=dashboard', null);
    /*
    $template->menu->addMenuElement('Test', 'book', [
        ['label' => 'Default','href' => 'r=home&a=default'],
    ]);
    */
}

function app_event_dashboard($template, $values){
    $template->setTitle('Dashboard');
    $template->collapseMenu();
    $template->setHeader('Dashboard', 'Preview page');
    $template->setBreadcrumb(['Dashboard'=>null]);

    $content = '<section class="content">
                <div class="row">
                <div class="col-lg-3 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-red">
                    <div class="inner">
                      <font class="dashboard-header">Clients</font>
                      <p>Client Manager</p>
                      <br/>
                    </div>
                    <div class="icon">
                      <i class="ion ion-person-add"></i>
                    </div>
                    <a href="?r=client&a=client_show" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                 </div>
                </section>';

    $template->write($content);
}

function app_event_default($template, $values){
    $template->write('<b>HELLO MOTO</b>');
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

function app_event_pdf($template, $values){
    $content = $values['content'];
    header('Cache-Control: public'); 
    header('Content-Type: application/pdf');
    header('filename="some-file.pdf"');
    //header('Content-Length: '.filesize($content));

    echo $content;
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
