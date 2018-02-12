<?php

class ui_container{
    public $title  = '';
    public $body   = '';
    public $footer = '';
    public $icon   = '';

    public function __construct(){

    }

    public static function newContainer(){
        $container = new ui_container();

        return $container;
    }

    public function setTitle($title='', $icon=''){
        $this->title = $title;

        if(!empty($icon)){
            $this->setIcon($icon);
        }
    }

    public function appendItem($content=''){
        $body = '';

        if(is_string($content)){
            $body .= $content;
        } elseif (is_object($content) && method_exists($content,'getHTML')) {
            $body .= $content->getHTML();
        }

        $this->body .= $body;
    }

    public function addSubmitBtn($tag='Submit'){
        $this->footer .= "<button type='submit' class='btn btn-primary'>{$tag}</button>\n";
    }

    public function addLinkBtn($tag='Submit', $href='#', $class='', $css=''){
        $this->footer .= "<a href='?{$href}' class='btn {$class}' style='{$css}'>{$tag}</a>\n";
    }

    public function setIcon($icon){
        $this->icon = "<span class='label label-primary pull-right'><i class='fa fa-{$icon}'></i></span>";
    }

    public function getBoxHTML(){
        $html = "<div class='box box-primary'>
                    <div class='box-header with-border'>
                        <h3 class='box-title'>
                            {$this->title}
                        </h3>
                        $this->icon
                    </div>
                    <form role='form' action='index.php'>
                        <div class='box-body'>
                            {$this->body}
                        </div>
                        <div class='box-footer'>
                            {$this->footer}
                        </div>
                    </form>
                </div>";

        return $html;
    }

    public function getHTML(){
        $html = "<div class='row'>
                    <div class='col-md-12'>
                        {$this->getBoxHTML()}
                    </div>
                  </div>";

        return $html;
    }
}

class ui_container_multi{
    public $elements = [];
    public $size = 12;

    public function __construct($size){
        $this->size = $size;
    }

    public static function newContainerMulti($size=12){
        $container = new ui_container_multi($size);

        return $container;
    }

    public function appendItem($item){
        $this->elements[] = $item;
    }

    public function setSize($size){
        $this->size = $size;
    }

    public function getHTML(){
        $html = '';

        foreach($this->elements as $element){
            $temp_html = '';

            if(is_string($element)){
                $temp_html = $element;
            } elseif (is_object($element) && method_exists($element,'getBoxHTML')) {
                $temp_html = $element->getBoxHTML();
            } elseif (is_object($element) && method_exists($element,'getHTML')) {
                $temp_html = $element->getHTML();
            }

            if(empty($temp_html)) contiune;

            $html .= "<div class='col-md-{$this->size}'>{$temp_html}</div>";
        }

        $html = "<div class='row'>
                    {$html}
                  </div>";

        return $html;
    }
}
?>
