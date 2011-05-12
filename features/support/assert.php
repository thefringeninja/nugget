<?php
require_once 'PHPUnit/Assert.php';

class Assert  extends PHPUnit_Assert {
    function & getInstance() {
        static $instance = array();
            if (!$instance) {
                    $instance[0] = new Assert();
            }
            return $instance[0];
    }
    static function  __callStatic($name, $arguments) {
        $_this = &Assert::getInstance();
        $method = 'assert' . $name;
        call_user_func_array(array($_this, $method), $arguments);
    }

    function fail($message = '') {
        throw new Exception($message);
    }
}
?>
