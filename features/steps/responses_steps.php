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

?>
