<?php

include 'config.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require './vendor/autoload.php';

$path =  '/' . explode('\\', dirname(__FILE__))[count(explode('\\', dirname(__FILE__))) - 1];
$app = AppFactory::create();
$app->setBasePath($path);

$app->post('/message', function (Request $request, Response $response, array $args) {
    // post message to public key
    // message: from: to:
    $parsedBody = $request->getParsedBody();
    if (isset($parsedBody['from']) && isset($parsedBody['to']) && isset($parsedBody['message'])) {
    } else {
        $response->getBody()->write(json_encode(array('status' => 'error', 'message' => 'missing params')));
    }
    return $response;
});

$app->get('/', function (Request $request, Response $response, array $args) {
    global $_PRIV8MESSAGING;
    $message = array('version' => $_PRIV8MESSAGING['version'], 'name' => $_PRIV8MESSAGING['name'], 'address' => $_PRIV8MESSAGING['address'], 'message' => $_PRIV8MESSAGING['message'], 'contact' => $_PRIV8MESSAGING['contact'], 'messages' => 0);
    $response->getBody()->write(json_encode($message));
    return $response;
});

$app->run();
