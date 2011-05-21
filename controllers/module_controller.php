<?php
App::import('Lib', 'Inflector');
class ModuleController extends Controller {
    var $module_path;
    var $uses = null;
    var $pre_request = array();
    var $verbs = array('get', 'post', 'put', 'delete');
    function  __construct() {
        parent::__construct();
        $this->autoRender = false;
        $r = null;
        if (!preg_match('/(.*)Module/i', $this->name, $r)) {
                __("Controller::__construct() : Can not get or parse my own class name, exiting.");
                $this->_stop();
        }
        $this->module_path = '/' . strtolower($r[1]);

        foreach ($this->verbs as $verb) {
            if (false == isset($this->{$verb})) {
                continue;
            }
            foreach ($this->{$verb} as $route => $resource) {
                Router::connect($this->module_path . $route, array(
                    'controller' => strtolower($this->name),
                    'action' => 'invoke',
                    'verb' => $verb,
                    'route' => $route,
                    'return' => true
                ), array('routeClass' => 'ModuleRoute'));
            }
        }
    }

    function invoke() {
        if (false == isset($this->{$this->params['verb']})) {
            return 404;
        }

        $verb = $this->{$this->params['verb']};

        if (false == isset($verb[$this->params['route']])) {
            return 404;
        }

        $callback = $verb[$this->params['route']];
        return $callback($this->params);
    }
}
class ModuleRoute extends CakeRoute {
    function  parse($url) {
        $params = parent::parse($url);
        if (false == $params) {
            return false;
        }
        $verb = $this->getRequestedMethod();
        
        if ($this->defaults['verb'] == $verb) {
            return $params;
        }
        return false;
    }

    private function getRequestedMethod() {
        foreach (array('X_HTTP_METHOD_OVERRIDE', 'REQUEST_METHOD') as $key) {
            if (isset($_SERVER[$key])) {
                return strtolower($_SERVER[$key]);
            }
        }
        return 'get';
    }
}
?>
