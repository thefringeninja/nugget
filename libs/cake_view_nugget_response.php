<?php
App::import('Libs', 'NuggetResponse');
class CakeViewNuggetResponse extends NuggetResponse {
    function  __construct(ModuleController $moduleController, $view, $layout = 'default') {
        parent::__construct($moduleController);
        $this->renderCallback = function($model) use($moduleController, $view, $layout) {
            $cake_view = new View($moduleController);
            $cake_view->viewVars['model'] = $model;
            $cake_view->viewPath = null;
            echo $cake_view->render($view, $layout);
        };
    }
}
?>
