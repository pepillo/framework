<?php
class template{
    public $title = null;
    public $template_source = null;
	public $properties = null;
    public $stylesheet = null;
	public $js_script = null;
    public $left_sidebar = [];
    public $menu = null;
	public $variable_replace = [];

	public function __construct(){

	}

	public static function newTemplate(){
		$template_obj = new template();

        $template_obj->title            = 'RealtorHeart';
        $template_obj->template_source  = THEME_HTML.'default.html';
        $template_obj->menu             = template_menu::newMenu();
		$template_obj->stylesheet       = template_stylesheet::newStylesheet();
		$template_obj->js_script        = template_javascript::newJavascript();

        $template_obj->require_file(UI_COMPONENTS, '.php');

		return $template_obj;
	}

    public function setTitle($title = 'RealtorHeart'){
        $this->title = $title;
    }

    public function setTemplateSource($source = null){
        if(is_null($source)) return;

        $this->template_source = THEME_HTML.$source;
    }

    public function setHeader($header='', $sub_header=''){
        $this->variable_replace['%HEADER%'] = $header;
        $this->variable_replace['%SUB_HEADER%'] = $sub_header;
    }

    public function setBreadcrumb($array=[]){
        $breadcrumb = '';

        foreach($array as $name => $link){
            if(!is_null($link)){
                $breadcrumb .= "<li><a href='?{$link}'>{$name}</a></li>";
            } else {
                $breadcrumb .= "<li class='active'>{$name}</li>";
            }
        }

        $this->variable_replace['%BREADCRUMB%'] = $breadcrumb;
    }

    public function addVariable($key, $value){
        $this->variable_replace[$key] = $value;
    }

    private function getTemplateSource(){
        $contents = null;

        ob_start();
        #TODO Validate dir exist for template_source
        include_once($this->template_source);
        $contents = ob_get_contents();
        ob_end_clean();

        return $contents;
    }

    public function write($content = '', $debug=false){
        $template_content = '';

        if(isset($this->variable_replace['%CONTENT%'])){
            $template_content .= $this->variable_replace['%CONTENT%'];
        }

        if($debug == true){
            $template_content .= '<pre>'.print_r($content,true).'</pre><hr>';
        } elseif(is_string($content)) {
            $template_content .= $content;
        } elseif (is_object($content) && method_exists($content,'getHTML')) {
            $template_content .= $content->getHTML();
        }

        $this->addVariable('%CONTENT%', $template_content);
    }

    public function collapseMenu(){
        $this->addVariable('%COLLAPSE%', 'sidebar-collapse');
    }

    public function getViewPath($path){
        return MVC_VIEW.$path;
    }

    public function authValidation($use_auth = null){
        if($use_auth != true) return;

        #TODO se if can change header to a redirect inside owne class,
        #     Change r= and a=

        $idletime = 60*60;//after 1 hr the user gets logged out
        $redirect_to_login = true;

        if(isset($_SESSION['user_session'])){
            if($_SESSION['user_session']['login_stamp'] + $idletime > time()){
                $_SESSION['user_session']['login_stamp'] = time();
                $redirect_to_login = false;
            }
        }

        if($redirect_to_login == true){
            if(isset($_SESSION)){
                session_destroy();
                session_unset();
            }

            header('location: ?r=auth_user&a=default');
        }
    }

    private function setActiveMenu(){
        global $ARGUMENT_VALUES;

        if(empty($ARGUMENT_VALUES)){
            $ARGUMENT_VALUES=['r'=>'home', 'a'=>'dashboard'];
        }

        foreach ($this->left_sidebar as &$element) {
            if($element['type'] == 'href'){
                $href_values = [];
                parse_str($element['href'], $href_values);

                if($ARGUMENT_VALUES['r'] != $href_values['r']) continue;
                if($ARGUMENT_VALUES['a'] != $href_values['a']) continue;

                $element['active'] = 'active';
            } elseif ($element['type'] == 'list') {
                foreach ($element['list'] as &$dropdown_element) {
                    $href_values = [];
                    parse_str($dropdown_element['href'], $href_values);

                    if($ARGUMENT_VALUES['r'] != $href_values['r']) continue;
                    if($ARGUMENT_VALUES['a'] != $href_values['a']) continue;

                    $element['active'] = 'active';
                    $dropdown_element['active'] = 'active';
                }
            }
        }
    }

    public function addMenuElement($label='', $icon='fa-circle', $href_or_list='#', $box=null){
        $type = (is_string($href_or_list)) ? 'href' : 'list';

        $sidebar_element = [
            'label' => $label,
            'icon' => $icon,
            'type' => $type,
            'box' => $box,
            $type => $href_or_list,
        ];

        $this->left_sidebar[] = $sidebar_element;
    }

    private function buildLeftSidebarMenu(){
        $menu_html = '';

        $this->setActiveMenu();

        foreach ($this->left_sidebar as $element) {
            switch ($element['type']) {
                case 'header':
                    $header_str = strtoupper($element['label']);
                    $menu_html .= "<li class='header'>{$header_str}</li>\n";
                    break;

                case 'href':
                    $active_class = (isset($element['active'])) ? $element['active']: '';
                    $menu_box = (is_null($element['box'])) ? '' : "<span class='label label-primary pull-right'>{$element['box']}</span>";

                    $menu_html .= "<li class='{$active_class}'>
                                    <a href='?{$element['href']}'>
                                        <i class='fa fa-{$element['icon']}'></i> <span>{$element['label']}</span>
                                        {$menu_box}
                                    </a>
                                   </li>\n";
                    break;

                case 'list':
                    $active_class = (isset($element['active'])) ? $element['active']: '';

                    $menu_box = (is_null($element['box'])) ?
                        "<i class='fa fa-angle-left pull-right'></i>" :
                        "<span class='label label-primary pull-right'>{$element['box']}</span>";

                    $dropdown = "";

                    foreach ($element['list'] as $dropdown_element) {
                        $active_dropdown = (isset($dropdown_element['active'])) ? $dropdown_element['active']: '';
                        $dropdown .= "<li class='{$active_dropdown}'>
                                        <a href='?{$dropdown_element['href']}'>
                                            <i class='fa fa-circle-o'></i>
                                            {$dropdown_element['label']}
                                        </a>
                                      </li>";
                    }

                    $menu_html .= "<li class='treeview {$active_class}'>
                                     <a href='#'>
                                       <i class='fa fa-{$element['icon']}'></i>
                                       <span>{$element['label']}</span>
                                       {$menu_box}
                                     </a>
                                     <ul class='treeview-menu'>
                                       {$dropdown}
                                     </ul>
                                   </li>\n";

                    break;
                default:
                    # code...
                    break;
            }
        }

        return $menu_html;
    }

    public function proccessInitializeApplication(){
        $properties = null;
        $initialize_function = 'initialize_application';

        if(function_exists($initialize_function)){
            $initialize_function($properties);
        }

        if(!is_null($properties)){
            $auth_bool = (isset($properties['use_auth'])) ? $properties['use_auth'] : null;
            $this->authValidation($auth_bool);
        }
    }

    public function proccessAppStart($template, $values){
        $app_start_function = 'app_start';

        if(function_exists($app_start_function)){
            $app_start_function($template, $values);
        }
    }

    public function proccessAppEnd(){

    }

    public function proccessAppEvent($values=null){
        if(!isset($values['r']) || !isset($values['a'])){
            #Default view/action
            $values['r'] = 'home';
            $values['a'] = 'dashboard';
        }

        $file_exist = false;
        $event_exist = false;
        $event = 'app_event_'.$values['a'];
        $filename = $this->getViewPath($values['r']);

        if(file_exists($filename.'.php')){
            $file_exist = true;
            $filename .= '.php';
        } else if(file_exists($filename) && file_exists($filename.'/index.php')){
            $file_exist = true;
            $filename .= '/index.php';
        }

        if($file_exist == false){
            //$this->write('This file dose not exist');
            $this->template_source  = THEME_HTML.'404.html';
            return;
        }

        require_once($filename);

        if(function_exists($event)){
            $event_exist = true;
        }

        if($event_exist == true){
            #Initialize Header
            if($this->template_source == THEME_HTML.'default.html'){
                $this->variable_replace['%HEADER%'] = '';
                $this->variable_replace['%SUB_HEADER%'] = '';
                $this->variable_replace['%BREADCRUMB%'] = '';
                $this->variable_replace['%LEFT_SIDEBAR%'] = '';
                $this->variable_replace['%CONTENT%'] = '';
            }

            $this->proccessInitializeApplication();
            $this->proccessAppStart($this, $values);

            $event($this, $values);
        } else {
            //$this->write('This event dose not exist');
            $this->template_source  = THEME_HTML.'404.html';
            return;
        }

        $this->proccessAppEnd();
    }

    public function render(){
        $this->stylesheet->loadStylesheet();
        $this->js_script->loadJavascript();

        $contents = $this->getTemplateSource();

        $contents = str_replace("%TITLE%",        $this->title,                  $contents);
        $contents = str_replace("%STYLESHEET%",   $this->stylesheet->getHTML(),  $contents);
        $contents = str_replace("%JAVASCRIPT%",   $this->js_script->getHTML(),   $contents);
        $contents = str_replace("%LEFT_SIDEBAR%", $this->menu->buildLeftSidebarMenu(), $contents);
        //$contents = str_replace("%COLLAPSE%",   "sidebar-collapse",         $contents);

        foreach($this->variable_replace as $variable => $value){
            $contents = str_replace($variable, $value, $contents);
        }

        echo $contents;
    }

    public function require_file($path=UI_COMPONENTS, $ext='.php'){
        $files = glob($path."*".$ext);

		foreach ($files as $dir) {
			require_once($path.basename($dir));
		}
    }
}

class template_menu{
    public $left_sidebar = [];

    public function __construct(){

    }

    public static function newMenu(){
        $menu_obj = new template_menu();

        return $menu_obj;
    }

    public function addMenuHeader($str=''){
        $this->left_sidebar[] = [
            'type' => 'header',
            'label' => $str,
        ];
    }

    private function setActiveMenu(){
        global $ARGUMENT_VALUES;

        #TODO this verification should be somewere else
        if(!isset($ARGUMENT_VALUES['r']) || !isset($ARGUMENT_VALUES['a'])){
            return;
        }

        if(empty($ARGUMENT_VALUES)){
            $ARGUMENT_VALUES=['r'=>'home', 'a'=>'dashboard'];
        }

        foreach ($this->left_sidebar as &$element) {
            if($element['type'] == 'href'){
                $href_values = [];
                parse_str($element['href'], $href_values);

                if($ARGUMENT_VALUES['r'] != $href_values['r']) continue;
                if($ARGUMENT_VALUES['a'] != $href_values['a']) continue;

                $element['active'] = 'active';
            } elseif ($element['type'] == 'list') {
                foreach ($element['list'] as &$dropdown_element) {
                    $href_values = [];
                    parse_str($dropdown_element['href'], $href_values);

                    if($ARGUMENT_VALUES['r'] != $href_values['r']) continue;
                    if($ARGUMENT_VALUES['a'] != $href_values['a']) continue;

                    $element['active'] = 'active';
                    $dropdown_element['active'] = 'active';
                }
            }
        }
    }

    public function addMenuElement($label='', $icon='fa-circle', $href_or_list='#', $box=null){
        $type = (is_string($href_or_list)) ? 'href' : 'list';

        $sidebar_element = [
            'label' => $label,
            'icon' => $icon,
            'type' => $type,
            'box' => $box,
            $type => $href_or_list,
        ];

        $this->left_sidebar[] = $sidebar_element;
    }

    public function buildLeftSidebarMenu(){
        $menu_html = '';

        $this->setActiveMenu();

        foreach ($this->left_sidebar as $element) {
            switch ($element['type']) {
                case 'header':
                    $header_str = strtoupper($element['label']);
                    $menu_html .= "<li class='header'>{$header_str}</li>\n";
                    break;

                case 'href':
                    $active_class = (isset($element['active'])) ? $element['active']: '';
                    $menu_box = (is_null($element['box'])) ? '' : "<span class='label label-primary pull-right'>{$element['box']}</span>";

                    $menu_html .= "<li class='{$active_class}'>
                                    <a href='?{$element['href']}'>
                                        <i class='fa fa-{$element['icon']}'></i> <span>{$element['label']}</span>
                                        {$menu_box}
                                    </a>
                                   </li>\n";
                    break;

                case 'list':
                    $active_class = (isset($element['active'])) ? $element['active']: '';

                    $menu_box = (is_null($element['box'])) ?
                        "<i class='fa fa-angle-left pull-right'></i>" :
                        "<span class='label label-primary pull-right'>{$element['box']}</span>";

                    $dropdown = "";

                    foreach ($element['list'] as $dropdown_element) {
                        $active_dropdown = (isset($dropdown_element['active'])) ? $dropdown_element['active']: '';
                        $dropdown .= "<li class='{$active_dropdown}'>
                                        <a href='?{$dropdown_element['href']}'>
                                            <i class='fa fa-circle-o'></i>
                                            {$dropdown_element['label']}
                                        </a>
                                      </li>";
                    }

                    $menu_html .= "<li class='treeview {$active_class}'>
                                     <a href='#'>
                                       <i class='fa fa-{$element['icon']}'></i>
                                       <span>{$element['label']}</span>
                                       {$menu_box}
                                     </a>
                                     <ul class='treeview-menu'>
                                       {$dropdown}
                                     </ul>
                                   </li>\n";

                    break;
                default:
                    # code...
                    break;
            }
        }

        return $menu_html;
    }

}

class body_part{
    public $body_source = null;
    public $body_content = null;

    public function __construct(){

    }

    public static function newBodyPart($source='', $variables=[]){
        $body_obj = new body_part();
        $body_obj->body_source = THEME_BODY_PART.$source;

        if($body_obj->loadBody() == true){
            $body_obj->setVariables($variables);
        }

        return $body_obj;
    }

    public function loadBody(){
        if(file_exists($this->body_source)){
            ob_start();
            include_once($this->body_source);
            $this->body_content = ob_get_contents();
            ob_end_clean();

            return true;
        }

        return false;
    }

    public function setVariables($array=[]){
        foreach ($array as $key => $value) {
            $variable_name = strtoupper("%{$key}%");
            $this->body_content = str_replace($variable_name, $value, $this->body_content);
        }
    }

    public function getHTML(){
        return $this->body_content;
    }
}

class template_stylesheet{
	public $stylesheet = [];

	public function __construct(){

	}

	public static function newStylesheet(){
		$stylesheet_obj = new template_stylesheet();
		//$stylesheet_obj->loadStylesheet();

		$stylesheet_obj->addFile(THEME_PLUGINS.'datatables/dataTables.bootstrap.css');
        $stylesheet_obj->addFile(THEME_PLUGINS.'iCheck/all.css');
        $stylesheet_obj->addFile(THEME_PLUGINS.'select2/select2.min.css');

        $stylesheet_obj->addFile(THEME_PLUGINS.'ionslider/ion.rangeSlider.css');
        $stylesheet_obj->addFile(THEME_PLUGINS.'ionslider/ion.rangeSlider.skinNice.css');
        $stylesheet_obj->addFile(THEME_PLUGINS.'bootstrap-slider/slider.css');

		return $stylesheet_obj;
	}

	public function loadStylesheet($dir = THEME_CSS){
		$css_files = glob($dir."*.css");

		foreach ($css_files as $css_dir) {
			//echo "<pre>".print_r($css_dir ,true)."</pre>";
			$css_path = $dir.basename($css_dir);
		    $this->addFile($css_path);
		}
	}

	public function addFile($dir = null){
		#TODO Validate if file exist
		$this->stylesheet[] = [
			'type' => 'file',
			'location' => $dir,
			//'tag' => "<link rel='stylesheet' href='{$dir}'>\n",
		];
	}

	public function addLink($link = null){
		$this->stylesheet[] = [
			'type' => 'link',
			'location' => $link,
			//'tag' => "<link rel='stylesheet' href='{$link}'>\n",
		];
	}

	public function getHTML(){
		$html = '';

		foreach ($this->stylesheet as $element) {
			$html .= "<link rel='stylesheet' href='{$element['location']}'>\n";
		}

		return $html;
	}
}

class template_javascript{
	public $js = [];

	public function __construct(){

	}

	public static function newJavascript(){
		$js_obj = new template_javascript();

		$js_obj->addFile(THEME_PLUGINS.'jQuery/jQuery-2.1.4.min.js');
		$js_obj->addFile(THEME_PLUGINS.'slimScroll/jquery.slimscroll.min.js');
		$js_obj->addFile(THEME_PLUGINS.'fastclick/fastclick.js');

        $js_obj->addFile(THEME_PLUGINS.'select2/select2.full.min.js');

        $js_obj->addFile(THEME_PLUGINS.'datatables/jquery.dataTables.min.js');
        $js_obj->addFile(THEME_PLUGINS.'datatables/dataTables.bootstrap.js');

        $js_obj->addFile(THEME_PLUGINS.'input-mask/jquery.inputmask.js');
        $js_obj->addFile(THEME_PLUGINS.'input-mask/jquery.inputmask.date.extensions.js');
        $js_obj->addFile(THEME_PLUGINS.'input-mask/jquery.inputmask.extensions.js');

        $js_obj->addFile(THEME_PLUGINS.'iCheck/icheck.min.js');

        $js_obj->addFile(THEME_PLUGINS.'ionslider/ion.rangeSlider.min.js');
        $js_obj->addFile(THEME_PLUGINS.'bootstrap-slider/bootstrap-slider.js');

        $js_obj->addCode('$("[data-mask]").inputmask();');
        $js_obj->addCode('$(".select2").select2();');
        $js_obj->addCode("$('input[type=\"checkbox\"].flat-red, input[type=\"radio\"].flat-red').iCheck({
                             checkboxClass: 'icheckbox_flat-green',
                             radioClass: 'iradio_flat-green'
                          });");

		//$js_obj->loadJavascript();

		return $js_obj;
	}

	public function loadJavascript($dir = THEME_JS){
		$js_files = glob($dir."*.js");

		foreach ($js_files as $js_dir) {
			$js_path = './_theme/_js/'.basename($js_dir);
		    $this->addFile($js_path);
		}
	}

	public function addFile($dir = null){
		#TODO Validate if file exist
		$this->js[] = [
			'type' => 'file',
			'location' => $dir,
		];
	}

	public function addLink($link = null){
		$this->js[] = [
			'type' => 'link',
			'location' => $link,
		];
	}

    public function addCode($code = null){
		$this->js[] = [
			'type' => 'code',
			'code' => $code,
		];
	}

	public function getHTML(){
		$html = '';
        $code = '';

		foreach ($this->js as $element) {
            if($element['type'] == 'code'){
                $code .= $element['code'];
                continue;
            }

			$html .= "<script src='{$element['location']}'></script>";
		}

        if(!empty($code)){
            $html .= "<script>
                        $( document ).ready(function() {
                            {$code}
                        });
                     </script>";
        }

		return $html;
	}
}
?>
