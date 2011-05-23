<?php
class NuggetRequest {
    public $method;
    public $uri;
    public $nugget;
    public $route;
    public $query = array();
    private $headers = array();

    function  __construct(NuggetController $nugget) {
        $this->headers = $this->parse_headers();
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->nugget = $nugget;
        $this->route = $nugget->params;
        $this->uri = parse_url($_SERVER['REQUEST_URI']);
        if (isset($this->uri['query'])) {
            parse_str($this->uri['query'], $this->query);
        }
    }

    function header($key) {
        return $this->headers[strtolower($key)];
    }

    // http://www.bluehostforum.com/showthread.php?1453-request-headers-(php)
    private function parse_headers(){
        $headers = array();
        foreach ($_SERVER as $k => $v)
        {
            if (substr($k, 0, 5) == "HTTP_")
            {
                $k = str_replace('_', ' ', substr($k, 5));
                $k = str_replace(' ', '-', strtolower($k));
                $headers[$k] = $v;
            }
        }
        return $headers;
    }
}
?>
