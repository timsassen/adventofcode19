<?php
include_once __DIR__ . '/../vendor/autoload.php';
$client = \Symfony\Component\Cache\Adapter\RedisAdapter::createConnection('redis://0.0.0.0:6379');

$output = new \Symfony\Component\Console\Output\ConsoleOutput();
while (1) {
    $message = "\x1B[1A\x1B[2K". 'x:' . (int)$client->hlen('hash'). '     y:' . (int)$client->hlen('hashy').'       z:' . (int)$client->hlen('hashz');
    $output->writeln($message, true);
}
