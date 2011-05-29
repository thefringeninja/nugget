<?php
class NuggetResponse extends Object {
    // http status code. should be an integer.
    public $code = 200;
    // associative array of response headers
    public $headers = array();
    // hyper media type
    public $content_type = 'text/plain';
    // the model. Can be a string, array, anything
    public $model;
    
    private $httpCodes;
    protected $renderCallback;

    function  __construct(NuggetController $nugget) {
        parent::__construct();
        $this->httpCodes = $nugget->httpCodes();
        $this->renderCallback = function($model) {
            if (is_object($model) || is_array($model)) {
                echo print_r($model, true);
            } else {
                echo $model;
            }
        };
    }

    final public function set_header($key, $value) {
        $key = strtolower($key);
        $this->headers[$key] = $value;
    }

    final public function get_header($key) {
        $key = strtolower($key);
        return array_key_exists($key, $this->headers)
                ? $this->headers[$key]
                : null;
    }

    // sets the headers, http response code, etc
    protected function beforeRender() {
        $message = $this->httpCodes[$this->code];
        // to do: send status or whatever depending on the webserver
        header("HTTP/1.1 " . $this->code . ' ' . $message);

        $this->set_header('Content-Type', $this->content_type);
        foreach ($this->headers as $key => $value) {
            header("$key: $value");
        }
    }

    public final function render() {
        $this->beforeRender();
        $callback = $this->renderCallback;
        $callback($this->model);
    }
}
?>
