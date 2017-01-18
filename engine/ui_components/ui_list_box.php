<?php

class ctr_dropdown{
    public $label = '';
    public $name = '';
    public $value = '';
    public $style = '';
    public $list = '';

    public function __construct($label, $name, $value='', $list=[], $place_holder='Select...', $style='width: 100%;'){
        $this->name         = $name;
        $this->label        = $label;
        $this->value        = $value;
        $this->style        = $style;
        $this->list         = $list;
        $this->place_holder = $place_holder;
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
        $id = 'select_uid_'.uniqid();

        $html = "<div class='form-group row'>
                    <label for='{$id}' class='col-sm-2 control-label' style='text-align: right;'>{$this->label}: </label>
                    <div class='col-sm-10'>
                        <select id='{$id}' name='{$this->name}' class='form-control select2' style='{$this->style}'>
                              <option value=''>{$this->place_holder}</option>
                              {$this->getOptionList()}
                        </select>
                    </div>
                 </div>";

        return $html;
    }
}

?>
