<?php
App::import('Controller', 'Nugget.Nugget');
App::import('Component', 'Nugget.ConentNegotiationComponent');
class ConnegNuggetController extends NuggetController {
    function  __construct() {
        $this->get['/simple'] = function($request) {
            $cn = $request->nugget->ContentNegotiation;
            $cn->respond_as('text/html', function(&$request, &$response) {
                // this should be a no op since by default we are using the cake view
            });
            $cn->respond_as('application/json', function(&$request, &$response) {
                $json = new JsonNuggetResponse($request->nugget);
                $json->model = $response->model;
                $json->code = $response->code;
                $response = $json;
            });
            return array('hello' => 'world');
        };
        parent::__construct();
    }
}
?>
