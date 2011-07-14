<?php
App::import('Libs', 'NuggetResponse');
class JsonNuggetResponse extends NuggetResponse {
    function  __construct(array $params = array()) {
        parent::__construct(array_merge($params, array('content_type' => 'application/json')));
        $this->renderCallback = function($model) {
            echo json_encode($model, true);
        };
    }
}
?>
