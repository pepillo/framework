<?php

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
        $html = "<div class='form-group row'>
                    <label class='col-sm-2 control-label' style='text-align: right;'>{$this->label}: </label>
                    <div class='col-sm-10'>
                        <select name='{$this->name}' class='form-control select2' style='{$this->style}'>
                              <option value=''>Select...</option>
                              {$this->getOptionList()}
                        </select>
                    </div>
                 </div>";

        return $html;
    }
}

?>