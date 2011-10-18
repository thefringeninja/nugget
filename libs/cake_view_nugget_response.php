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
		$response = $this;
		$this->renderCallback = function($model) use($response) {
			$view_class = $response->view_class;
			$cake_view = new $view_class($response->nugget);
			$cake_view->viewVars['model'] = $model;
			$cake_view->viewPath = null;
			echo $cake_view->render($response->view, $response->layout);
		};
	}
}
?>