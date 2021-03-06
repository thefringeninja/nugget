<?php
class Nugget {
    public static $nuggets = array();

    public static function load($nuggets) {
        if (false === is_array($nuggets)) {
            $nuggets = array($nuggets);
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

    public static function url() {
	    $segments = func_get_args();
	    if (is_array($segments[0] ?: false)) {
		    $segments = $segments[0];
	    }
        //to do: do we want to check current nuggets for a route match?
        return preg_replace('/^(\\/+)/', '/',  '/' . implode('/', $segments));
    }
}
?>
