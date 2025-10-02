<?php declare(strict_types=1);

namespace spriebsch\eventExamples\bankAccount;

use ReflectionClass;
use spriebsch\DomainEvent\MapToTopic;

require_once __DIR__ . '/bootstrap.php';

$events = [
    AccountOpenedEvent::class,
    MoneyDepositedEvent::class,
    MoneyWithdrawnEvent::class,
];

foreach ($events as $event) {

    $reflection = new ReflectionClass($event);
    $attributes = $reflection->getAttributes(MapToTopic::class);

    foreach ($attributes as $attribute) {
        $instance = $attribute->newInstance();
        print 'Event: ' . $event . PHP_EOL;
        print 'Topic: ' . $instance->topic . PHP_EOL;
        print PHP_EOL;
    }

    $methods = $reflection->getMethods();

    foreach ($methods as $method) {
        $attributes = $method->getAttributes('UseAsCorrelationId');

        if (count($attributes) > 0) {
            var_dump($method->getReturnType()->getName());
            var_dump($attributes[0]);
        }
    }
}

// @todo we can combine static autoloading with a attribute-based topic mapping.
// @todo we need a script to discover all events. everything that implements domainevent.
// with autoloader, just requiring the event class should work, then reflection "implements"
// or just regex parse $classname implements DomainEvent
