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

?>
