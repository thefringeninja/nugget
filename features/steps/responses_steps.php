<?php

$steps->When('/^I request "([^"]*)"$/', function($world, $url) {
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $world->sut->params = Router::parse($url);
    $world->response = $world->sut->invoke();
});

$steps->Then('/^the response code should be (\d+)$/', function($world, $code) {
    Assert::Equals($code, $world->response->code);
});

$steps->Then('/^the response model should not be null$/', function($world) {
    Assert::NotNull($world->response->model);
});

$steps->Then('/^it should render the view$/', function($world) {
    ob_start();
    $world->response->render();
    $result = ob_get_contents();
    ob_end_clean();
    Assert::equals('what', $result);
});
?>
