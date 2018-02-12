<?php
require_once('autoload.php');
use League\Csv\Writer;
use League\Csv\Reader;

class spreadsheet {
    private $object = null;
    private $header = [];
    private $data   = [];
    private $encode = false;
    private $encode_fields = [];

    public static function out($file_name='file.csv', $data=[], $header=null, $encode=false){
        $sheet = new spreadsheet();
        $sheet->header($header);
        $sheet->insertAll($data);

        if(is_array($encode) || $encode == true){
            $sheet->encode($encode);
        }

        //echo '<pre>'.print_r($sheet, true).'</pre>';
        //exit;

        $sheet->output($file_name);
    }

    public function __construct(){

    }

    public function header($data=null){
        if(!is_array($data)) return;

        $this->header = $data;
    }

    public function insert($data=[], $delimiter=','){
        $csv_elm = [];

        if(is_string($data)){
            $str     = str_replace("'", '', $data);
            $csv_elm = explode($delimiter, $data);
        } else if(is_array($data)){
            $csv_elm = $data;
        }

        $this->data[] = $csv_elm;
    }

    public function insertAll($data=[], $delimiter=','){
        if(!is_array($data)) return;

        foreach ($data as $key => $value) {
            if(!is_array($value) && !is_string($value)) continue;

            self::insert($value, $delimiter);
        }
    }

    private function applyEncoding(){
        if($this->encode != true) return;

        if(is_array($this->encode_fields) && !empty($this->encode_fields)) {
            foreach ($this->data as $csv_key => &$csv_record) {
                foreach ($this->encode_fields as $key_encode) {
                    //error_log("{$key_encode}::{$csv_record[$key_encode]}");
                    $csv_record[$key_encode] = mb_convert_encoding($csv_record[$key_encode], 'UTF-16LE', 'UTF-8');
                }
            }

            return;
        }

        foreach ($this->data as &$csv_record) {
            foreach ($csv_record as &$value) {
                $value = mb_convert_encoding($value, 'UTF-16LE', 'UTF-8');
            }
        }
    }

    public function encode($encode_fields=[]){
        $this->encode = true;
        $this->encode_fields = $encode_fields;
    }

    public function output($file_name='file.csv'){
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="'.$file_name.'"');

        $this->applyEncoding();

        $rows = $this->data;

        if(!empty($this->header)){
            array_unshift($rows, $this->header);
        }

        $writer = Writer::createFromFileObject(new SplTempFileObject());
        $writer->insertAll($rows); //using an array
        //$writer->insertAll(new ArrayIterator($rows)); //using a Traversable object
        $writer->output();

        exit;
    }
}
?>
