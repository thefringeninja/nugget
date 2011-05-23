# Introducing Nugget

## What is the point?

As someone who is primarily a dotnet developer, I _love_ the simplicity and elegance of [Nancy](http://github.com/NancyFx/Nancy). I needed something similar for a [CakePHP](http://www.cakephp.org) project I was working on. CakePHP has some great conventions around wiring things up without a DI container. However trying to implement a REST-ful API on top of that is not frictionless by any means. So, nugget was born.

## How to run the tests

Get [Behat](http://www.behat.org)
Get [PhpUnit](http://phpunit.de)
Run behat from project root

## How to use?

In your bootstrap.php:

    App::import('Lib', 'Nugget');

In your router.php:

    Nugget::load('My');

In my_nugget_controller.php:

    class MyNuggetController extends NuggetController {
        var uses = array('SomeModel');
        function __construct() {
            $this->get['/'] = function($request) {
                return 'Hello World!'
            };
            $this->get['/model/:id'] = function($request) {
                return $request->nugget->SomeModel->findById($request->route['id']);
            };
            $this->get['/not-found'] = function($request) {
                return 404;
            };
            $this->get['/view/:id'] = function($request) {
                $response = new CakeViewNuggetResponse($request->nugget, 'my/index');
                $response->model = $request->nugget->SomeModel->findById($request->route['id']);
                return $response;
            };
            parent::__construct();
        }
    }

## Why Nugget?

(http://en.wikipedia.org/wiki/Fashion_Nugget#Track_listing)