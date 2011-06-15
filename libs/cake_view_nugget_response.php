<?php
App::import('Lib', 'Nugget.NuggetResponse');
class CakeViewNuggetResponse extends NuggetResponse {
    function  __construct(array $params = array()) {
        $params = array_merge(array(
                                   'layout' => 'default',
                                   'content_type' => 'text/html'
                              ), $params);
        parent::__construct($params);
        $this->renderCallback = function($model) use($params) {
            $cake_view = new View($params['nugget']);
            $cake_view->viewVars['model'] = $model;
            $cake_view->viewPath = null;
            echo $cake_view->render($params['view'], $params['layout']);
        };
    }
}
?>
