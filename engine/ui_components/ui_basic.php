<?php

class ctr_hidden{
    public $name = '';
    public $value = '';


    public function __construct($name, $value){
        $this->name = $name;
        $this->value = $value;
    }

    public function getHTML(){
        $html = "<input type='hidden' name='{$this->name}' value='{$this->value}'>";

        return $html;
    }
}

class ctr_label{
    public $label = '';
    public $value = '';
    public $style = '';


    public function __construct($label, $value, $style=''){
        $this->label = $label;
        $this->value = $value;
        $this->style = $style;
    }

    public function getHTML(){
        $html = "<div class='form-group row'>
                    <label class='col-sm-2 control-label' style='text-align: right;'>{$this->label}: </label>
                    <div class='col-sm-10'>
                        <label style='font-weight: normal;{$this->style}'>{$this->value}</label>
                    </div>
                 </div>";

        return $html;
    }
}

class ctr_bool{
    public $label = '';
    public $name = '';
    public $bool = '';


    public function __construct($label, $name, $bool=null){
        $this->label = $label;
        $this->name = $name;
        $this->bool = $bool;
    }

    public function getHTML(){
        $checked = "checked='1'";

        if(empty($this->bool) || $this->bool == 0){
            $checked = '';
        }

        $html = "<div class='form-group row'>
                    <label class='col-sm-2 control-label' style='text-align: right;'>{$this->label}: </label>
                    <div class='col-sm-10'>
                        <input name='{$this->name}' {$checked} type='checkbox' class='flat-red' style='position: absolute; opacity: 0;'>
                    </div>
                 </div>";

        $html1 = "<div class='form-group row'>
                    <label class='col-sm-2 control-label' style='text-align: right;'>{$this->label}: </label>
                    <div class='col-sm-10'>
                        <textarea class='form-control'</textarea>
                    </div>
                 </div>";

        return $html;
    }
}

?>
