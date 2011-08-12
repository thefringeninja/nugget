<?php
$steps->Given('/^a nugget "([^"]*)"$/', function($world, $class) {
    @include_once dirname(dirname(__FILE__)) . '/support/' . strtolower($class) . '_nugget_controller.php';
    $class = $class . 'NuggetController';
    $world->sut = new $class;
});
$steps->And('/^the nugget is using component "([^"]*)"$/', function($world, $component) {
    $class = $component . 'Component';
    $world->sut->{$component} = new $class;
    $world->sut->{$component}->initialize($world->sut);
});
$steps->Then('/^the module path should equal "([^"]*)"$/', function($world, $module_path) {
    Assert::Equals($module_path, $world->sut->module_path);
});

$steps->And('/^it should register routes$/', function($world) {
    $route = Router::parse($world->sut->module_path . '/some-resource');
    Assert::Equals('testnugget', $route['controller']);
    Assert::Equals('invoke', $route['action']);
});

$steps->And('/^it should register routes with parameters$/', function($world) {
    $route = Router::parse($world->sut->module_path . '/what/some-resource');
    Assert::Equals('testnugget', $route['controller']);
    Assert::Equals('invoke', $route['action']);
});

$steps->And('/^it should route the action$/', function($world) {
    $_SERVER['REQUEST_URI'] = $world->sut->module_path . '/what/some-resource';
    $_SERVER['REQUEST_METHOD'] = 'GET';

    $dispatcher = new Dispatcher();
    $result = $dispatcher->dispatch();
    Assert::Equals('what', $result->model);
});
$steps->And('/^it should route the action based on the verb$/', function($world) {
    $_SERVER['REQUEST_URI'] = $world->sut->module_path . '/what/some-resource';
    $_SERVER['REQUEST_METHOD'] = 'POST';

    $dispatcher = new Dispatcher();
    $result = $dispatcher->dispatch();
    Assert::Equals('what was posted', $result->model);
});
$steps->Then('/^it should inherit helpers from its parent class$/', function($world) {
    Assert::array_has_key('Time', $world->sut->helpers);
    Assert::array_has_key('Text', $world->sut->helpers);
});

$steps->And('/^it should inherit components from its parent class$/', function($world) {
    Assert::array_has_key('RequestHandler', $world->sut->components);
    Assert::array_has_key('Email', $world->sut->components);
});
?>
