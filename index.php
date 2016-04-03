<?php
require_once("./engine/framework/framework.php");

session_start();

$framework = new framework();
#TODO catch error and send to error page

$framework->error_log->displayLog(true);

global $ARGUMENT_VALUES;
$ARGUMENT_VALUES = $framework->server_attr['ARGUMENT_VALUES'];

$framework->template->proccessAppEvent($ARGUMENT_VALUES);
$framework->template->render();
?>
