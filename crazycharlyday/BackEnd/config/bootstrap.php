<?php

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use PhpAmqpLib\Connection\AMQPStreamConnection;



$builder = new ContainerBuilder();
$builder->addDefinitions(__DIR__ . '/settings.php' );
$builder->addDefinitions(__DIR__ . '/dependencies.php');


$c=$builder->build();
$app = AppFactory::createFromContainer($c);

////init rabit mq connection
//try {
//    $connection = new AMQPStreamConnection(
//        getenv('AMQP_HOST'),
//        getenv('AMQP_PORT'),
//        getenv('AMQP_USER'),
//        getenv('AMQP_PASSWORD')
//    );
//    $channel = $connection->channel();
//} catch (Exception $e) {
//
//}

////init fanout exchange
//$exchange = getenv('NOTIFY_EXCHANGE');
//$channel->exchange_declare($exchange, 'fanout', false, true, false);
//$queue_name = "mail";
//$channel->queue_declare($queue_name, false, true, false, false);
//$channel->queue_bind($queue_name , $exchange);
//
//// Fermeture de la connexion
//$channel->close();
//$connection->close();

$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware($c->get('displayErrorDetails'), false, false)
    ->getDefaultErrorHandler()
    ->forceContentType('application/json');


$app = (require_once __DIR__ . '/routes.php')($app);
$routeParser = $app->getRouteCollector()->getRouteParser();


return $app;