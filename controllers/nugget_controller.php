<?php
App::import('Lib', 'Inflector');
App::import('Lib', 'NuggetResponse');
App::import('Lib', 'NuggetRequest');
App::import('Lib', 'NuggetPipeline');
class NuggetController extends Controller {
    var $module_path;
    var $uses = null;
    var $pre_request;
    var $post_request;
    var $verbs = array('get', 'post', 'put', 'delete');
    function  __construct() {
        parent::__construct();
        $this->autoRender = false;
        $r = null;
        if (!preg_match('/(.*)Nugget/i', $this->name, $r)) {
                __("Controller::__construct() : Can not get or parse my own class name, exiting.");
                $this->_stop();
        }
        $this->module_path = '/' . strtolower($r[1]);

        $this->pre_request = new NuggetPipeline();
        $this->post_request = new NuggetPipeline();

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
                ), array('routeClass' => 'NuggetRoute'));
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

        // the last item in the pipeline should be the rendering step
        $controller = &$this;
        $this->post_request->last(function(&$request, &$response) use ($controller) {
            $output = $response;

            if (is_integer($output)) {
                $response = new NuggetResponse(array(
                        'code' => $output,
                        'model' => ''));
            } elseif ($output instanceof NuggetResponse) {
                $response = $output;
            } else {
                $response = new NuggetResponse(array('model' => $output));
            }
        });

        $callback = $verb[$this->params['route']];

        $request = new NuggetRequest($this);

        return $this->execute_pipeline($request, $callback);
    }

    private function execute_pipeline(NuggetRequest $request, $callback) {
        if ($this->execute_pre_request_hooks($request, $response)) {
            $response = $callback($request);
        }

        $this->execute_post_request_hooks($request, $response);

        return $response;
    }

    private function execute_pre_request_hooks(NuggetRequest &$request, &$response) {
        foreach ($this->pre_request->enumerate() as $hook) {
            if (false === $hook($request, $response)) {
                return false;
            }
        }
        return true;
    }

    private function execute_post_request_hooks(NuggetRequest &$request, &$response) {
        foreach ($this->post_request->enumerate() as $hook) {
            $hook($request, $response);
        }
    }
}
class NuggetRoute extends CakeRoute {
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
