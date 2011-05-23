<?php
App::import('Controller', 'Nugget');
class TestNuggetController extends NuggetController {
    var $components = null;
    function  __construct() {
        $this->get['/some-resource'] = function ($request) {
            return null;
        };

        $this->get['/returns/code/:code'] = function($request) {
            return (int)$request->route['code'];
        };
        $this->get['/returns/model'] = function($request) {
            return array();
        };
        $this->get['/returns/view'] = function($request) {
            $response = new CakeViewNuggetResponse($request->nugget, 'test/view');
            $response->model = array('parameter' => 'what');
            return $response;
        };

        $this->get['/:parameter/some-resource'] = function ($request) {
            return $request->route['parameter'];
        };

        $this->post['/:parameter/some-resource'] = function($request) {
            return $request->route['parameter'] . ' was posted';
        };

        parent::__construct();
    }
}
?>
