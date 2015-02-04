# Zero Test App
============
Based on **[Zero Framework](https://github.com/ivanets/Zero)**.

Strongly recommended to read base manual **[Zero Framework Homepage](http://zero.phpcode.in.ua/)**.

Also read [How to use](#how-to-use).


Basic rules
> Zero is a framework based on [Scaffold](http://en.wikipedia.org/wiki/Scaffold_(programming))
> with a custom syntax.
>
> System architector just need to write rules
> Then programmer got semi-empty models, controllers and routes for actions ready to go.


How to use
------------

You need to do next steps:

1. Clone Test app git repo to your web server
~~~
git clone https://github.com/ivanets/ZeroTestApp.git .
~~~

2. Open the app/config/architecture/main.plan (Main.plan example)
~~~
# Define model. Start line with "!" and define model dependencies in "<>"
!App\IndexModel <Zero\DB\MySQL$db> <Zero\Config\Ini$ACLConfig>
*App\IndexController <App\IndexModel$acl> <Zero\HTTP\Request$request>

GET / App\IndexController

ROUTE /test
{
	GET / App\IndexController
	GET /action App\IndexController.test
	POST /action App\IndexController.testPost
}
~~~

3. Write rules you need (Syntax)
~~~
# on GET to / will run App\IndexController.indexAction
GET / App\IndexController

# ROUTE key is for blocks of routes
ROUTE /test
{
	GET / App\IndexController
	# on GET to /test/action/1 will run App\IndexController.testAction
	GET /action/{param:\d+} App\IndexController.test
	POST /action App\IndexController.testPost
}
~~~

4. Run scaffold action from console.
~~~
$ cd /path/to/app
$ app/console scaffolding architecture/main.plan
~~~


5. You can also use console commands.
~~~
Will rewrite all routes
$ app/console scaffolding architecture/main.plan --routes
Will rewrite all scaffolded content (Be careful)
$ app/console scaffolding architecture/main.plan --force

Will run application asd start testAction in IndexController with param=2
$ app/console run App\IndexController.test [param=2]
~~~

6. Configure you editor.
~~~
Sublime text:

Prefences -> Browse packages -> User

Copy ZeroPlanFile.tmLanguage there.
Back to sublime text, View -> Syntax -> Open all with current extension as -> ZeroPlanFile
~~~


### app/bootstrap.php example ###
Short:
~~~php
<?php
require_once '../vendor/autoload.php';

$environment = new Zero\Config\Yaml('config/env.yml');
$app = new Zero\Core\Zero($environment);

$app->run();

$view = $app->getView();
$renderedData = $view->render();
echo $renderedData;
~~~