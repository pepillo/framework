<?php

class ui_table{
    public $id = '';
    public $header = [];
    public $table_row = [];
    public $actions = [];

    public function __construct(){

    }

    public static function newTable($id='table'){
        $table = new ui_table();
        $table->id = $id;

        return $table;
    }

    public function addHeader($key='', $value=''){
        $this->header[$key] = $value;
    }

    public function addRow($data=[]){
        if(empty($data)) return;

        $this->table_row[] = $data;
    }

    public function addAction($icon_or_text='square', $href='', $type='icon'){
        if($type == 'icon'){
            $this->actions[] = [
                'type' => 'icon',
                'href' => $href,
                'icon' => $icon_or_text,
            ];
        } elseif ($type == 'text') {
            $this->actions[] = [
                'type' => 'text',
                'href' => $href,
                'text' => $icon_or_text,
            ];
        } else {

        }
    }

    private function getHeader(){
        $header = '';

        foreach ($this->header as $header_name) {
            $header .= "<th>{$header_name}</th>";
        }

        if(!empty($this->actions)){
            $header .= "<th style='width:".(35*count($this->actions))."px;'>Actions</th>";
        }

        return $header;
    }

    private function getTableRow(){
        $row = '';

        foreach ($this->table_row as $tr) {
            $td = '';
            foreach ($this->header as $key => $header_name) {
                if(isset($tr[$key])){
                    $td .= "<td>{$tr[$key]}</td>";
                } else {
                    $td .= "<td></td>";
                }
            }
            $td .= $this->getActions($tr);
            $row .= "<tr>{$td}</tr>";
        }

        return $row;
    }

    private function getActionLink($data=[], $href=''){
        $return_href = $href;

        $matches = array();
        $regex = "/=([a-zA-Z0-9_]*)%/";#Get str between = & %
        preg_match_all($regex, $href, $matches);

        foreach ($matches[1] as $element) {
            if(!isset($data[$element])) continue;

            $return_href = str_replace($element.'%', $data[$element], $return_href);
        }

        return $return_href;
    }

    private function getActions($data=null){
        $action_html = '';

        if(is_null($data)) return $action_html;
        if(empty($this->actions)) return $action_html;

        foreach($this->actions as $action){
            $href = $this->getActionLink($data, $action['href']);

            if($action['type'] == 'icon'){
                $action_html .= "<a href='?{$href}' style='text-decoration: none;'>
                                    <button type='button' class='btn btn-default'>
                                        <i class='fa fa-{$action['icon']}'></i>
                                    </button>
                                </a> ";
            } elseif ($action['type'] == 'text') {
                #TODO If text and not icon program it here
                $action_html .= "";
            }
        }

        return "<td>{$action_html}</td>";
    }

    public function getHTML(){
        $html = " <div class='row'>
                    <div class='col-xs-12'>
                        <div class='box-body table-responsive no-padding'>
                        <table id='{$this->id}' class='table table-bordered table-striped dataTable'>
                            <thead>
                                <tr>{$this->getHeader()}</tr>
                            </thead>
                            <tbody>{$this->getTableRow()}</tbody>
                         </table>
                      </div>
                    </div>
                 </div>";

        $js = "<script>
                $('#{$this->id}').DataTable
                ({
                    'paging': true,
                    'lengthChange': true,
                    'searching': true,
                    'ordering': true,
                    'info': true,
                    'autoWidth': true
                });
                </script>";

        return $html.$js;
    }
}

?>
