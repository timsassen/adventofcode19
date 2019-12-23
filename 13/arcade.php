<?php

phpinfo();die;

require_once __DIR__ . '/../vendor/autoload.php';

$startButton = isset($_REQUEST['sb']);
$leftButton = isset($_REQUEST['lb']);
$rightButton = isset($_REQUEST['rb']);

$connection = \Symfony\Component\Cache\Adapter\RedisAdapter::createConnection("redis://localhost:6379");

if ($startButton) {

}
if ($leftButton) {
    $connection->set('input', -1);
} elseif ($rightButton) {
    $connection->set('input', 1);
}

echo json_encode([
    'screen' => $connection->get('screen'),
    'meta' => $connection->get('meta'),
    'sb' => $startButton,
    'lb' => $leftButton,
    'rb' => $rightButton
]);