<?php
#View all errors
// ini_set('display_startup_errors',1);
// ini_set('display_errors',1);
// error_reporting(E_ALL | E_STRICT);

#Disable Error Display
ini_set('display_errors', 'Off');

#Enable Log error for trail
#trail -f error_log.log
ini_set("log_errors", 1);
ini_set("error_log", "/log/error_log.log");

########################################################################
#Test Echo
//echo 'Work True!!';

########################################################################
#Test DOMPDF
require_once './engine/third_party/dompdf/autoload.inc.php';

$test_a = [
	'wwefwe'    => 'wefwefw',
	'wefwe'     => 'werwer',
	'werwerwer' => 'werwer',
];
// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$dompdf->loadHtml('hello world');

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
//$dompdf->stream();

########################################################################

?>
