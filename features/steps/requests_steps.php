<?php
$steps->And('/^the "([^"]*)" header is "([^"]*)"$/', function($world, $header, $value) {
    $_SERVER['HTTP_' . strtoupper($header)] = $value;
});

$steps->Then('/^the "([^"]*)" header should be "([^"]*)"$/', function($world, $header, $value) {
    Assert::equals($value, $world->response->model->header($header));
});

$steps->And('/^the request method should be "([^"]*)"$/', function($world, $value) {
    Assert::equals($value, $world->response->model->method);
});

$steps->And('/^the request uri path should be "([^"]*)"$/', function($world, $value) {
    Assert::equals($value, $world->response->model->uri['path']);
});

$steps->And('/^the request query string "([^"]*)" should be "([^"]*)"$/', function($world, $key, $value) {
    Assert::equals($value, $world->response->model->query[$key]);
});

?>
