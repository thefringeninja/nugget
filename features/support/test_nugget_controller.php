<?php
App::import('Controller', 'Nugget');
class TestNuggetController extends NuggetController {
    public static $_components = array('RequestHandler');
    public static $_helpers = array('Time');
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
            return new CakeViewNuggetResponse(array(
                    'view' => 'test/view',
                    'model' => array('parameter' => 'what'),
                    'nugget' => $request->nugget
                                                   ));
        };

        $this->get['/returns/request'] = function($request) {
            return new NuggetResponse(array('model' => $request));
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

class TestSubclassNuggetController extends TestNuggetController {
    public static $_components = array('Email');
    public static $_helpers = array('Text');
}
?>
