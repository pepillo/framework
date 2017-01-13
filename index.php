<?php
require_once("./engine/framework/framework.php");

session_start();

$framework = new framework();
#TODO catch error and send to error page

#Set to false to hide error display in browser
$framework->error_log->displayLog(false);

global $ARGUMENT_VALUES;
$ARGUMENT_VALUES = $framework->server_attr['ARGUMENT_VALUES'];

$framework->template->proccessAppEvent($ARGUMENT_VALUES);
$framework->template->render();
?>
