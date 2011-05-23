<?php
App::import('Libs', 'NuggetResponse');
class CakeViewNuggetResponse extends NuggetResponse {
    function  __construct(NuggetController $nugget, $view, $layout = 'default') {
        parent::__construct($nugget);
        $this->renderCallback = function($model) use($nugget, $view, $layout) {
            $cake_view = new View($nugget);
            $cake_view->viewVars['model'] = $model;
            $cake_view->viewPath = null;
            echo $cake_view->render($view, $layout);
        };
    }
}
?>
