<?php
class Nugget {
    private $nuggets = array();

    function &getInstance() {
            static $instance = array();
            if (!$instance) {
                    $instance[0] =& new Nugget();
            }
            return $instance[0];
    }

    function load($nugget) {
        $_this = &Nugget::getInstance();
        if (false == isset($_this->nuggets[$nugget])) {
            if (false == App::import('Controller', $nugget . 'Nugget')) {
                return false;
            }
            $class = $nugget . 'NuggetController';
            $_this->nuggets[$nugget] = new $class;
        }
        return $_this->nuggets[$nugget];
    }
}
?>
