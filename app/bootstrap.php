<?php
require_once '../vendor/autoload.php';

$environment = new Zero\Config\Yaml('config/env.yml');
$app = new Zero\Core\Zero($environment);

$dbConfig = new Zero\Config\Ini('config/db.ini');
$app->setService('db', new Zero\DB\MySQL($dbConfig['host'], $dbConfig['user'], $dbConfig['pass'], $dbConfig['db']));

//$app->setService('session', new Zero\HTTP\Session());
$app->setService('request', new Zero\HTTP\Request());

$ACLConfig = new Zero\Config\Ini('config/acl.ini');
$app->setService('ACLConfig', $ACLConfig);

$app->run();

$view = $app->getView();
$renderedData = $view->render();
echo $renderedData;