<?php
App::import('Libs', 'NuggetResponse');
class JsonNuggetResponse extends NuggetResponse {
    function  __construct(NuggetController $nugget) {
        parent::__construct($nugget);
        $this->content_type = 'application/json';
        $this->renderCallback = function($model) use($nugget) {
            echo json_encode($model, true);
        };
    }
}
?>
