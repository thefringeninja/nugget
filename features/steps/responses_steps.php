<?php

$steps->When('/^I request "([^"]*)"$/', function($world, $url) {
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = $url;
    $world->sut->params = Router::parse($url);
    $world->response = $world->sut->invoke();
    ob_start();
    $world->response->render();
    $world->output = ob_get_contents();
    ob_end_clean();

});

$steps->When('/^I make a HEAD request to "([^"]*)"$/', function($world, $url) {
    $_SERVER['REQUEST_METHOD'] = 'HEAD';
    $_SERVER['REQUEST_URI'] = $url;
    $world->sut->params = Router::parse($url);
    $world->response = $world->sut->invoke();
    ob_start();
    $world->response->render();
    $world->output = ob_get_contents();
    ob_end_clean();

});

$steps->Then('/^the response code should be (\d+)$/', function($world, $code) {
    Assert::Equals($code, $world->response->code);
});

$steps->Then('/^the response model should not be null$/', function($world) {
    Assert::NotNull($world->response->model);
});

$steps->Then('/^it should render the view$/', function($world) {
    Assert::equals('what', $world->output);
});

$steps->Then('/^the body of the response should be empty$/', function($world) {
    Assert::equals(0, strlen($world->output));
});
?>
