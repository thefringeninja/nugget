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

        $this->nugget->post_request->last(function(NuggetRequest &$request, &$response) use ($responses){
            $accepts = array_map(function($element){
                return trim($element);
            }, explode(',', $request->header("Accept")));

            foreach ($responses as $content_type => $callback ) {
                $pattern = '/^' . str_replace('/', '\\/', $content_type) . '/';
                foreach ($accepts as $accept) {
                    if (false == preg_match($pattern, $accept)) {
                        continue;
                    }
                    $callback($request, $response);
                    $response->content_type = $content_type;
               }
            }
        });
    }

    
}
?>
