<?php
App::import('Controller', 'Nugget.Nugget');
App::import('Component', 'Nugget.ConentNegotiationComponent');
class ConnegNuggetController extends NuggetController {
    function  __construct() {
        $this->get['/simple'] = function($request) {
            return array('hello' => 'world');
        };
        parent::__construct();
    }
}
?>
