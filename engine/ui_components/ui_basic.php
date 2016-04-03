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
        $html = "<div class='form-group'>
                    <label class='col-sm-2 control-label' style='text-align: right;'>{$this->label}: </label>
                    <div class='input-group'>
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

        $html = "<div class='form-group'>
                    <label class='col-sm-2 control-label' style='text-align: right;'>{$this->label}: </label>
                    <div class='input-group'>
                        <input name='{$this->name}' {$checked} type='checkbox' class='flat-red' style='position: absolute; opacity: 0;'>
                    </div>
                 </div>";

        return $html;
    }
}

class ctr_currency{
    public $label = '';
    public $name = '';
    public $value = '';
    public $style = '';
    public $mask = '';


    public function __construct($label, $name, $value, $style='', $mask='999,999.99'){
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->mask = $mask;
        $this->style = $style;
    }

    public function getHTML(){
        $id = uniqid();

        $html = "<div class='form-group'>
                    <label class='col-sm-2 control-label' style='text-align: right;'>{$this->label}: </label>
                    <div class='input-group'>
                        <span class='input-group-addon'><i class='fa fa-usd'></i></span>
                        <input id='{$id}' style='{$this->style}'  name='{$this->name}' type='text' class='form-control' value='{$this->value}'>
                    </div>
                 </div>";

        $js = "<script>$('#{$id}').inputmask('{$this->mask}', { numericInput: true });</script>";

        return $html.$js;
    }
}

class ctr_dropdown{
    public $label = '';
    public $name = '';
    public $value = '';
    public $style = '';
    public $list = '';

    public function __construct($label, $name, $value='', $list=[], $style=''){
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->style = $style;
        $this->list = $list;
    }

    private function getOptionList(){
        $option_html = '';

        foreach ($this->list as $key => $value) {
            if($key == $this->value){
                $selected = "selected='selected'";
            } else {
                $selected = '';
            }

            $option_html .= "<option value='{$key}' {$selected}>{$value}</option>";
        }

        return $option_html;
    }

    public function getHTML(){
        $html = "<div class='row'>
                    <label class='col-sm-2 control-label' style='text-align: right;'>{$this->label}: </label>
                    <div class='col-sm-6' style='float:left; padding-left:10px;'>
                        <select name='{$this->name}' class='form-control select2' style='{$this->style}'>
                              <option value=''>Select...</option>
                              {$this->getOptionList()}
                        </select>
                    </div>
                 </div>";

        return $html;
    }
}

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

        $html = "<div class='form-group'>
                    <label for='{$id}' class='col-sm-2 control-label' style='text-align: right;'>{$this->label}: </label>
                    <div class='input-group col-sm-10'>
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
        $html = "<div class='form-group'>
                    <label class='col-sm-2 control-label' style='text-align: right;'>{$this->label}: </label>
                    <div class='input-group col-sm-10'>
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

        $html = "<div class='form-group'>
                    <label for='{$id}' class='col-sm-2 control-label' style='text-align: right;'>{$this->label}: </label>
                    <div class='input-group'>
                        <span class='input-group-addon'><i class='fa fa-{$this->icon}'></i></span>
                        <input id='{$id}' style='{$this->style}'  name='{$this->name}' type='text' class='form-control' maxlength='{$this->max_length}' value='{$this->value}' placeholder='{$this->holder}' data-inputmask='&quot;mask&quot;: &quot;{$this->mask}&quot;' data-mask=''>
                    </div>
                 </div>";

        return $html;
    }
}

class ctr_slider{
    public $label = '';
    public $name = '';
    public $value = [];
    public $prefix = '';
    public $min = '';
    public $max = '';


    public function __construct($label, $name, $value='', $min_max=[], $prefix=''){
        $this->name = $name;
        $this->label = $label;
        $this->prefix = $prefix;

        $this->min = $min_max[0];
        $this->max = $min_max[1];

        if(empty($value)){
            $this->value['min'] = $this->min;
            $this->value['max'] = $this->max;
        } else {
            $value_min_max = explode(";", $value);

            $this->value['min'] = $value_min_max[0];
            $this->value['max'] = $value_min_max[1];
        }
    }

    public function getHTML(){
        $id = uniqid();

        $html = "<div class='form-group row'>
                    <label class='col-sm-2 control-label' style='text-align: right;'>{$this->label}: </label>
                    <div class='col-sm-10'>
                        <input id='{$id}' type='text' name='{$this->name}' value=''>
                    </div>
                 </div>";

        $js = "<script>
                $('#{$id}').ionRangeSlider({
                      min: {$this->min},
                      max: {$this->max},
                      from: {$this->value['min']},
                      to: {$this->value['max']},
                      type: 'double',
                      step: 1,
                      prefix: '{$this->prefix}',
                      prettify: false,
                      hasGrid: true
                 });
                </script>";

        return $html.$js;
    }
}

?>
