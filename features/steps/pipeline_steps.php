<?php
$steps->Given('/^I insert a pre request hook that returns (true|false)$/', function($world, $value) {
    if ($value == 'false') {
        $value = false;
    } else {
        $value = true;
    }
    $world->sut->pre_request->last(function(&$request, &$response) use($value){
        $response = 'intercepted';
        return $value;
    });
});
$steps->Given('/^I insert a post request hook$/', function($world) {
    $world->sut->post_request->last(function(&$request, &$response) {
        $response .= ' after';
    });
});

$steps->When('/^I request a resource$/', function($world) {
    $world->sut->constructClasses();
    $world->sut->startupProcess();

    $_SERVER['REQUEST_METHOD'] = 'GET';
    $world->sut->params = Router::parse('/test/what/some-resource');
    $world->result = $world->sut->invoke();
    $world->sut->shutdownProcess();
});

$steps->Then('/^it should cancel execution of the route$/', function($world) {
    Assert::equals('intercepted', $world->result->model);
});
$steps->Then('/^it should not cancel execution of the route$/', function($world) {
    Assert::equals('what', $world->result->model);
});
$steps->Then('/^it can modify the response$/', function($world) {
    Assert::equals('what after', $world->result->model);
});

?>
