<?php declare(strict_types=1);

namespace spriebsch\DomainEvent;

use Crell\Serde\Attributes\StaticTypeMap;

#[StaticTypeMap(key: 'type', map: [
    'simpleEvent'  => SimpleEvent::class,
    'complexEvent' => ComplexEvent::class,
])]
interface TestEvent extends DomainEvent
{
    public function id(): TestId;
}
