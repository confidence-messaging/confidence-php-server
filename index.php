<?php

include 'config.php';
include 'dbService.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require './vendor/autoload.php';

$path =  '/' . explode('\\', dirname(__FILE__))[count(explode('\\', dirname(__FILE__))) - 1];
$app = AppFactory::create();
$app->setBasePath($path);

$app->post('/message', function (Request $request, Response $response, array $args) {
    global $_PRIV8MESSAGING;
    $parsedBody = $request->getParsedBody();
    if (isset($parsedBody['from']) && isset($parsedBody['to']) && isset($parsedBody['message']) && isset($parsedBody['visibleAt'])) {
        $databaseService = new DatabaseService();
        $conn = $databaseService->getConnection();

        $query = "INSERT INTO messages
                SET to = :to,
                    message = :message,
                    visibelAt = :visibleAt";

        $stmt = $conn->prepare($query);

        $stmt->bindParam(':from', $parsedBody->from);
        $stmt->bindParam(':to', $parsedBody->to);
        $stmt->bindParam(':message', $parsedBody->message);
        $stmt->bindParam(':visibleAt', $parsedBody->visibleAt);

        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(array("message" => "User was successfully registered."));
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to register the user."));
        }

        $response->status(200);
        $response->getBody()->write(json_encode(array('status' => 'ok', 'message' => 'message sent to node ' . $_PRIV8MESSAGING['name'])));
    } else {
        $response->status(400);
        $response->getBody()->write(json_encode(array('status' => 'error', 'message' => 'missing params')));
    }
    return $response;
});

$app->get('/', function (Request $request, Response $response, array $args) {
    global $_PRIV8MESSAGING;
    $message = array('version' => $_PRIV8MESSAGING['version'], 'name' => $_PRIV8MESSAGING['name'], 'address' => $_PRIV8MESSAGING['address'], 'message' => $_PRIV8MESSAGING['message'], 'contact' => $_PRIV8MESSAGING['contact'], 'messages' => 0);
    $response->status(200);
    $response->getBody()->write(json_encode($message));
    return $response;
});

$app->run();
