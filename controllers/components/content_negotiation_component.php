<?php
App::import('Controller', 'Nugget.Nugget');
class ContentNegotiationComponent extends Object {
    private $nugget;

    function initialize(NuggetController &$nugget, $settings = array()) {
        $this->nugget = $nugget;
    }

    
}
?>
