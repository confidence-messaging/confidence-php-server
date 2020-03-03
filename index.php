<?php

include 'config.php';
include 'dbService.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use GuzzleHttp\Client;

require './vendor/autoload.php';

// $separator = dirname(__FILE__)[0];
// $path =  '/' . explode($separator, dirname(__FILE__))[count(explode($separator, dirname(__FILE__))) - 1];
// echo $path;
$app = AppFactory::create();
$app->setBasePath('/');

function request($address)
{
    $client = new GuzzleHttp\Client();
    $res = $client->request('GET', $address, ['http_errors' => false, 'headers' => ['Accept' => 'application/json', 'Content-type' => 'application/json']]);

    $statusCode = $res->getStatusCode();
    if ($statusCode == 200 && isset(json_decode($res->getBody())["status"])) {
        return true;
    } else {
        trigger_error("node addr - $address", E_USER_WARNING);
        return false;
    };
}

$app->post('/message', function (Request $request, Response $response, array $args) {
    global $_CONFIDENCE;
    $parsedBody = $request->getParsedBody();
    if (isset($parsedBody['from']) && isset($parsedBody['to']) && isset($parsedBody['message']) && isset($parsedBody['visibleAt'])) {
        $databaseService = new DatabaseService();
        $conn = $databaseService->getConnection();

        $stmt = $conn->prepare("INSERT INTO messages
        SET to = :to,
            message = :message,
            visibelAt = :visibleAt");

        $stmt->bindParam(':from', $parsedBody->from);
        $stmt->bindParam(':to', $parsedBody->to);
        $stmt->bindParam(':message', $parsedBody->message);
        $stmt->bindParam(':visibleAt', $parsedBody->visibleAt);

        $stmt->execute();

        // broadcast
        $stmt = $conn->prepare('SELECT address FROM nodes order by rand() limit 2');
        $stmt->execute();
        request($stmt[0]->address);
        request($stmt[1]->address);
        // post to 0 and 1

        $response->withStatus(200);
        $response->getBody()->write(json_encode(array('status' => 'ok', 'message' => 'message sent to the network.', 'node' => $_CONFIDENCE['name'])));
    } else {
        $response->withStatus(400);
        $response->getBody()->write(json_encode(array('status' => 'error', 'message' => 'missing params', 'node' => $_CONFIDENCE['name'])));
    }
    return $response;
});

$app->get('/', function (Request $request, Response $response, array $args) {
    global $_CONFIDENCE;
    $message = array('version' => $_CONFIDENCE['version'], 'name' => $_CONFIDENCE['name'], 'address' => $_CONFIDENCE['address'], 'message' => $_CONFIDENCE['message'], 'contact' => $_CONFIDENCE['contact'], 'messages' => 0);
    $response->withStatus(200);
    $response->getBody()->write(json_encode($message));
    return $response;
});

$app->run();
