<?php
class Nugget {
    public static $nuggets = array();

    public static function load($nuggets) {
        if (false === is_array($nuggets)) {
            $nuggets[] = $nuggets;
        }
        foreach ($nuggets as $nugget) {
            self::load_nugget($nugget);
        }
    }

    private static function load_nugget($nugget) {
        if (false === isset(Nugget::$nuggets[$nugget])) {
            if (false == App::import('Controller', $nugget . 'Nugget')) {
                return false;
            }
            $class = $nugget . 'NuggetController';
            Nugget::$nuggets[$nugget] = new $class;
        }
        return Nugget::$nuggets[$nugget];
    }

    public static function url(array $segments = array()) {
        //to do: do we want to check current nuggets for a route match?
        return '/' . implode('/', $segments);
    }
}
?>
