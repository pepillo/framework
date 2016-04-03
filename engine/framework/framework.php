<?php
require_once("framework_variables.php");
require_once(FRAMEWORK_TEMPLATE);

function pre($a){
    return '<pre>'.print_r($a, true).'</pre>';
}

class framework{
    public $server_attr = [];
    public $error_log = null;
    public $template = null;
    public $values = null;

    public function __construct(){
        $this->server_attr = [
            'HTTP_REFERER'    => $this->getServerAttr('HTTP_REFERER'),
            'DOCUMENT_ROOT'   => $this->getServerAttr('DOCUMENT_ROOT'),
            'SCRIPT_FILENAME' => $this->getServerAttr('SCRIPT_FILENAME'),
            'REQUEST_METHOD'  => $this->getServerAttr('REQUEST_METHOD'),
            'QUERY_STRING'    => $this->getServerAttr('QUERY_STRING'),
            'REQUEST_URI'     => $this->getServerAttr('REQUEST_URI'),
            'SCRIPT_NAME'     => $this->getServerAttr('SCRIPT_NAME'),
            'PATH_INFO'       => $this->getServerAttr('PATH_INFO'),
            'PATH_TRANSLATED' => $this->getServerAttr('PATH_TRANSLATED'),
            'PHP_SELF'        => $this->getServerAttr('PHP_SELF'),
            'ARGUMENT_VALUES' => [],
        ];

        $this->setArgumentVariables();

        //echo "<pre>".print_r($_SERVER,true)."</pre>";

        $this->error_log = new system_error_log();
        $this->template = template::newTemplate();
    }

    private function getServerAttr($value = null){
        return (isset($_SERVER[$value])) ? $_SERVER[$value] : null;
    }

    private function setArgumentVariables(){
        if(!empty($_POST)){
            $this->values = $_POST;
            $this->server_attr['ARGUMENT_VALUES'] = $_POST;

            return;
        }

        parse_str($this->server_attr['QUERY_STRING'], $this->server_attr['ARGUMENT_VALUES']);
        $this->values = $this->server_attr['ARGUMENT_VALUES'];
    }
}

class system_error_log{
    #TODO if error_lof.log dose not exist create it
    private $log_file = 'error_log.log';

    public function __construct($log_file = null, $log_bool = true){
        if(!is_null($log_file)){
            #TODOValidate if file exist
            $this->log_file = $log_file;
        } else {
            $this->log_file = LOG_DIR.'error_log.log';
        }

        if($log_bool == true){
            $this->trackLog();
        }
    }

    public function displayLog($enable=false){
        if($enable == true){
            #View all errors
            ini_set('display_startup_errors',1);
            ini_set('display_errors',1);
            error_reporting(E_ALL | E_STRICT);
        } else {
            #Disable Error Display
            ini_set('display_errors', 'Off');
            ini_set("log_errors", 1);
        }
    }

    private function trackLog(){
        #Enable Log error for trail
        #tail -f error_log.log
        ini_set("error_log", $this->log_file);
    }
}
?>
