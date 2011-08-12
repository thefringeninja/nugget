<?php
require_once 'PHPUnit/Autoload.php';

class Assert extends PHPUnit_Framework_Assert {
    static function  __callStatic($name, $arguments) {
        $name = Inflector::camelize($name);
        $method = 'assert' . $name;
        call_user_func_array(array('PHPUnit_Framework_Assert', $method), $arguments);
    }
}
?>
