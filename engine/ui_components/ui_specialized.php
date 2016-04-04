<?php
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

        $html = "<div class='form-group row'>
                    <label class='col-sm-2 control-label' style='text-align: right;'>{$this->label}: </label>
                    <div class='col-sm-10'>
                        <div class='input-group'>
                            <span class='input-group-addon'><i class='fa fa-usd'></i></span>
                            <input id='{$id}' style='{$this->style}'  name='{$this->name}' type='text' class='form-control' value='{$this->value}'>
                        </div>
                    </div>
                 </div>";

        $js = "<script>$('#{$id}').inputmask('{$this->mask}', { numericInput: true });</script>";

        return $html.$js;
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
                    <div class='col-sm-9'>
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