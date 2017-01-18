<?php
#TODO When load data if remove a tag it removes all tags
class ctr_multibox{
    public $label = '';
    public $name  = '';
    public $value = '';
    public $style = '';
    public $list  = '';
    public $place_holder  = 'Select...';

    public function __construct($label, $name, $value='', $list=[], $style='width: 100%;'){
        $this->name  = $name;
        $this->label = $label;
        $this->value = $value;
        $this->style = $style;
        $this->list  = $list;
    }

    public function setPlaceHolder($holder){
        $this->place_holder = $holder;
    }

    public function setOptionList($list){
        $return_list = [];

        if(is_string($list)){
            foreach($list as $key => $value) {
                $return_list[$value] = $value;
            }
        } else {
            $return_list = $list;
        }

        $this->list = $return_list;
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

    private function get_init_selection(){
        $selected_value = [];
        $selected_json  = '';

        if(is_array($this->value)){
            $selected_value = $this->value;
        } elseif(is_string($this->value) && !empty($this->value)){
            $selected_value = explode(',', $this->value);
        }

        foreach($selected_value as $key => $value){
            $selected_json .= "'{$value}', ";
        }

        return $selected_json;
    }

    public function getHTML(){
        global $framework;

        $id = 'multi_uid_'.uniqid();

        $js1 = "$('#{$id}').select2({
                  placeholder: '{$this->place_holder}',
                  multiple: true,
                  allowClear: true,
                  triggerChange: true,
                });";

        $framework->template->js_script->addCode($js1);

        $init_selection = $this->get_init_selection();

        if(!empty($init_selection)){
            $js2 = "$('#{$id}').select2().val([{$init_selection}]).trigger('change');";

            $framework->template->js_script->addCode($js2);
        }

        $html = "<div class='form-group row'>
                    <label for='{$id}' class='col-sm-2 control-label' style='text-align: right;'>{$this->label}: </label>
                    <div class='col-sm-10'>
                        <select id='{$id}' name='{$this->name}[]' multiple='multiple' style='{$this->style}'>
                          {$this->getOptionList()}
                        </select>
                    </div>
                 </div>";

         return $html;
    }
}

?>
