<?php
require __DIR__ . '/vendor/autoload.php';

$options = [
    'host' => '127.0.0.1',
    'scheme' => 'tcp://',
    'port' => 5038,
    'username' => 'cloud',
    'secret' => '3HiogJmGlZfEQSHOJZjn',
    'connect_timeout' => 10000,
    'read_timeout' => 10000
];

use PAMI\Client\Impl\ClientImpl as PamiClient;
use PAMI\Message\Event\EventMessage;
use PAMI\Listener\IEventListener;
use PAMI\Message\Event\DialEvent;

$pamiClient = new PamiClient($options);
$pamiClient->open();

$pamiClient->registerEventListener(function (EventMessage $event) {
    print_r($event);
});

while (true) {
    $pamiClient->process();
    usleep(1000);
}

$pamiClient->close();
?>
