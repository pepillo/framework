<?php
class ctr_text{
    public $label = '';
    public $name = '';
    public $holder = '';
    public $value = '';
    public $style = '';
    public $max_length = '';
    public $mask = '';


    public function __construct($label, $name, $value='', $holder='', $mask=''){
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->holder = $holder;
        $this->mask = $mask;
    }

    public function getHTML(){#set to add in container a encapsulation box so that i dont need this here style='padding-bottom:40px;'
        $id = uniqid();

        $html = "<div class='form-group row'>
                    <label for='{$id}' class='col-sm-2 control-label' style='text-align: right;'>{$this->label}: </label>
                    <div class='col-sm-10'>
                        <input id='{$id}' style='{$this->style}'  name='{$this->name}' type='text' class='form-control' maxlength='{$this->max_length}' value='{$this->value}' placeholder='{$this->holder}' data-inputmask='&quot;mask&quot;: &quot;{$this->mask}&quot;' data-mask=''>
                    </div>
                 </div>";

        return $html;
    }
}

class ctr_text_box{
    public $label = '';
    public $name = '';
    public $holder = '';
    public $value = '';
    public $style = '';
    public $rows = '';


    public function __construct($label, $name, $value='', $holder='', $rows=4, $style=''){
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->holder = $holder;
        $this->style = $style;
        $this->rows = $rows;
    }

    public function getHTML(){
        $html = "<div class='form-group row'>
                    <label class='col-sm-2 control-label' style='text-align: right;'>{$this->label}: </label>
                    <div class='col-sm-10'>
                        <textarea class='form-control' name='{$this->name}' rows='{$this->rows}' placeholder='{$this->holder}'>{$this->value}</textarea>
                    </div>
                 </div>";

        return $html;
    }
}

class ctr_text_icon{
    public $label = '';
    public $name = '';
    public $holder = '';
    public $value = '';
    public $style = '';
    public $max_length = '';
    public $mask = '';


    public function __construct($icon, $name, $label, $value='', $holder='', $mask=''){
        $this->icon = $icon;
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->holder = $holder;
        $this->mask = $mask;
    }

    public function getHTML(){
        $id = 'text_field_id_'.uniqid();

        $html = "<div class='form-group row'>
                    <label for='{$id}' class='col-sm-2 control-label' style='text-align: right;'>{$this->label}: </label>
                    <div class='col-sm-10'>
	                    <div class='input-group'>
	                        <span class='input-group-addon'><i class='fa fa-{$this->icon}'></i></span>
	                        <input id='{$id}' style='{$this->style}'  name='{$this->name}' type='text' class='form-control' maxlength='{$this->max_length}' value='{$this->value}' placeholder='{$this->holder}' data-inputmask='&quot;mask&quot;: &quot;{$this->mask}&quot;' data-mask=''>
	                    </div>
                    </div>
                </div>";

        return $html;
    }
}

?>
