<?php
App::import('Controller', 'Module');
class TestModuleController extends ModuleController {
    var $components = null;
    function  __construct() {
        $this->get['/some-resource'] = function ($p) {
            return null;
        };

        $this->get['/:parameter/some-resource'] = function ($p) {
            return $p['parameter'];
        };

        $this->post['/:parameter/some-resource'] = function($p) {
            return $p['parameter'] . ' was posted';
        };

        parent::__construct();
    }
}
?>
