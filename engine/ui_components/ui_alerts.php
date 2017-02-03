<?php
class ctr_alert{
    public $header = '';
    public $text   = '';
    public $icon   = '';
    public $class  = '';


    public function __construct($header, $text, $icon='', $class='callout-danger'){
        $this->header = $header;
        $this->text   = $text;
        $this->class  = $class;
        $this->icon   = $icon;

        return $this;
    }

    public function setClass($class){
        $class_list = [
            'red'    => 'callout-danger',
            'blue'   => 'callout-info',
            'yellow' => 'callout-warning',
            'green'  => 'callout-success',
        ];

        if(!isset($class_list[$class])) return;

        $this->class = $class_list[$class];

        return $this;
    }

    public function error(){
        $this->class = 'alert-danger';
        $this->icon  = 'exclamation-triangle';

        return $this;
    }

    public function info(){
        $this->class = 'alert-info';
        $this->icon  = 'info-circle';

        return $this;
    }

    public function warning(){
        $this->class = 'alert-warning';
        $this->icon  = 'exclamation-circle';

        return $this;
    }

    public function success(){
        $this->class = 'alert-success';
        $this->icon  = 'check';

        return $this;
    }

    private function getIcon(){
        if(empty($this->icon)){
            return '';
        }

        return "<i class='icon fa fa-{$this->icon}'></i>";
    }

    public function getHTML(){
        $html = "<div class='alert {$this->class} alert-dismissible'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <h4>
                        {$this->getIcon()}
                        {$this->header}
                    </h4>
                    <p>{$this->text}</p>
                 </div>";
        return $html;
    }
}

class ctr_callout{
    public $header = '';
    public $text   = '';
    public $icon   = '';
    public $class  = '';


    public function __construct($header, $text, $icon='', $class='callout-danger'){
        $this->header = $header;
        $this->text   = $text;
        $this->class  = $class;
        $this->icon   = $icon;

        return $this;
    }

    public function setClass($class){
        $class_list = [
            'red'    => 'callout-danger',
            'blue'   => 'callout-info',
            'yellow' => 'callout-warning',
            'green'  => 'callout-success',
        ];

        if(!isset($class_list[$class])) return;

        $this->class = $class_list[$class];

        return $this;
    }

    public function error(){
        $this->class = 'callout-danger';
        $this->icon  = 'exclamation-triangle';

        return $this;
    }

    public function info(){
        $this->class = 'callout-info';
        $this->icon  = 'info-circle';

        return $this;
    }

    public function warning(){
        $this->class = 'callout-warning';
        $this->icon  = 'exclamation-circle';

        return $this;
    }

    public function success(){
        $this->class = 'callout-success';
        $this->icon  = 'check';

        return $this;
    }

    private function getIcon(){
        if(empty($this->icon)){
            return '';
        }

        return "<i class='icon fa fa-{$this->icon}'></i>";
    }

    public function getHTML(){
        $html = "<div class='callout {$this->class} lead'>
                     <h4>
                         {$this->getIcon()}
                         {$this->header}
                     </h4>
                     <p>{$this->text}</p>
                 </div>";

        return $html;
    }
}
?>
