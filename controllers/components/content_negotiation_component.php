<?php
App::import('Controller', 'Nugget.Nugget');
class ContentNegotiationComponent extends Object {
    private $nugget;
    private $inserted_into_pipeline = false;
    private $responses = array();

    function initialize(NuggetController &$nugget, $settings = array()) {
        $this->nugget = $nugget;
    }

    function respond_as($content_type, $callback) {
        $this->responses[$content_type] = $callback;

        if ($this->inserted_into_pipeline === true) {
            return;
        }

        $responses = $this->responses;

        $this->nugget->post_request->last(function(&$request, &$response) use ($responses){
            while (count($responses) > 0) {
                $callback = array_pop($responses);
                $callback($request, $response);
            }
        });
    }
}
?>
