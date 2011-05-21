<?php
$steps->Given('/^I insert a pre request hook that returns (true|false)$/', function($world, $value) {
    if ($value == 'false') {
        $value = false;
    } else {
        $value = true;
    }
    $world->sut->pre_request[] = function(&$request, &$response) use($value){
        $response = 'intercepted';
        return $value;
    };
});
$steps->Given('/^I insert a post request hook$/', function($world) {
    $world->sut->post_request[] = function(&$request, &$response) {
        $response .= ' after';
    };
});

$steps->When('/^I request a resource$/', function($world) {
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $world->sut->params = Router::parse('/test/what/some-resource');
    $world->result = $world->sut->invoke();
});

$steps->Then('/^it should cancel execution of the route$/', function($world) {
    Assert::equals('intercepted', $world->result);
});
$steps->Then('/^it should not cancel execution of the route$/', function($world) {
    Assert::equals('what', $world->result);
});
$steps->Then('/^it can modify the response$/', function($world) {
    Assert::equals('what after', $world->result);
});

?>
