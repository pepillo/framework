<?php

class ui_container{
    public $title = '';
    public $body = '';
    public $footer = '';

    public function __construct(){

    }

    public static function newContainer(){
        $container = new ui_container();

        return $container;
    }

    public function setTitle($title=''){
        $this->title = $title;
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

    public function addLinkBtn($tag='Submit', $href='#'){
        $this->footer .= "<a href='?{$href}'><button class='btn btn-primary'>{$tag}</button></a>\n";
    }

    public function getHTML(){
        $html = "<div class='row'>
                    <div class='col-md-12'>
                        <div class='box box-primary'>
                            <div class='box-header with-border'>
                                <h3 class='box-title'>
                                    {$this->title}
                                </h3>
                            </div>
                            <form role='form' action='index.php'>
                                <div class='box-body'>
                                    {$this->body}
                                </div>
                                <div class='box-footer'>
                                    {$this->footer}
                                </div>
                            </form>
                        </div>
                    </div>
                  </div>";

        return $html;
    }
}

?>
