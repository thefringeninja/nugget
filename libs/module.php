<?php
class Module {
    private $modules = array();

    function &getInstance() {
            static $instance = array();
            if (!$instance) {
                    $instance[0] =& new Module();
            }
            return $instance[0];
    }

    function load($module) {
        $_this = &Module::getInstance();
        if (false == isset($_this->modules[$module])) {
            if (false == App::import('Controller', $module . 'Module')) {
                return false;
            }
            $class = $module . 'ModuleController';
            $_this->modules[$module] = new $class;
        }
        return $_this->modules[$module];
    }
}
?>
