<?php
//$web_root = $_SERVER['DOCUMENT_ROOT'].'/framework/';
$web_root = './';

define('WEB_ROOT',             $web_root);
define('LOG_DIR',              $web_root.'log/');

define('THEME_DIR',            $web_root.'_theme/');
define('THEME_CSS',            THEME_DIR.'_css/');
define('THEME_IMG',            THEME_DIR.'_img/');
define('THEME_JS',             THEME_DIR.'_js/');
define('THEME_FONTS',          THEME_DIR.'_fonts/');
define('THEME_PLUGINS',        THEME_DIR.'_plugins/');
define('THEME_HTML',           THEME_DIR.'_html/');
define('THEME_BODY_PART',      THEME_HTML.'_body/');

define('ENGINE_DIR',           $web_root.'engine/');
define('UI_COMPONENTS',        ENGINE_DIR.'ui_components/');
define('THIRD_PARTY_DIR',      ENGINE_DIR.'third_party/');
define('DB_MYSQL',             THIRD_PARTY_DIR.'db_mysql/');

define('FRAMEWORK_DIR',        ENGINE_DIR.'framework/');
define('FRAMEWORK_TEMPLATE',   FRAMEWORK_DIR.'framework_template.php');
define('FRAMEWORK_PROPERTIES', FRAMEWORK_DIR.'framework_properties.php');

define('MVC_DIR',              $web_root.'mvc/');
define('MVC_CONTROLLER',       MVC_DIR.'controller/');
define('MVC_MODEL',            MVC_DIR.'model/');
define('MVC_VIEW',             MVC_DIR.'view/');

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
?>
