<?php
class Nugget {
    private static $nuggets = array();

    public static function load($nugget) {
        if (false === isset(Nugget::$nuggets[$nugget])) {
            if (false == App::import('Controller', $nugget . 'Nugget')) {
                return false;
            }
            $class = $nugget . 'NuggetController';
            Nugget::$nuggets[$nugget] = new $class;
        }
        return Nugget::$nuggets[$nugget];
    }
}
?>
