<?php
$steps->Then('/^the "([^"]*)" response header should be "([^"]*)"$/', function($world, $key, $value) {
    Assert::equals($value, $world->response->get_header($key));
});
$steps->And('/^the response body should be json$/', function($world) {
    $result = json_decode($world->output);
    Assert::Equals('stdClass', get_class($result));
});
?>
