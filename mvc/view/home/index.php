<?php
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
