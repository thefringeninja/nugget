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

        foreach ($this->responses as $content_type => $callback) {
            $pattern = '/^' . str_replace('/', '\\/', $content_type) . '/';
            $responses[$pattern] = array('content_type' => $content_type, 'callback' => $callback);
        }

        $this->nugget->post_request->last(function(NuggetRequest &$request, &$response) use ($responses){
            $accepts = array_map(function($element){
                return trim($element);
            }, explode(',', $request->header("Accept")));

            usort($accepts, function($a, $b){
                $a = explode(';', $a);
                $b = explode(';', $b);

                $q_a = array_key_exists('q', $a)
                        ? (float)$a['q']
                        : 0.0;

                $q_b = array_key_exists('q', $b)
                        ? (float)$b['q']
                        : 0.0;

                if ($q_a == $q_b)
                    return 0;

                return $q_a < $q_b ? -1 : 1;
            });

            foreach ($accepts as $accept) {
                foreach ($responses as $pattern => $value) {
                    if (false == preg_match($pattern, $accept)) {
                        continue;
                    }
                    $callback = $value['callback'];
                    $callback($request, $response);
                    $response->content_type = $value['content_type'];

                    return;
               }
            }
        });
    }
}
?>
