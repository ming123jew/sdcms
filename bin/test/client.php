<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2018-3-29
 * Time: 15:46
 */
require_once __DIR__ . '/../../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();
$channel->queue_declare('amqp-cache', false, true, false, false);
$msg = new AMQPMessage('Hello World!');
for($i=0;$i<=20000;$i++)
{
    $channel->basic_publish($msg, 'amqp-cache');
    echo " [x] Sent 'Hello World!'\n";
}


$channel->close();
$connection->close();