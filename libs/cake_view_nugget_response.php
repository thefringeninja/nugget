<?php
App::import('Lib', 'Nugget.NuggetResponse');
class CakeViewNuggetResponse extends NuggetResponse {
    function  __construct(array $params = array()) {
        $params = array_merge(array(
                                   'layout' => 'default',
                                   'content_type' => 'text/html',
	                               'view_class' => 'View'
                              ), $params);
        parent::__construct($params);
        $this->renderCallback = function($model) use($params) {
	        $view_class = $params['view_class'];
            $cake_view = new $view_class($params['nugget']);
            $cake_view->viewVars['model'] = $model;
            $cake_view->viewPath = null;
            echo $cake_view->render($params['view'], $params['layout']);
        };
    }
}
?>
