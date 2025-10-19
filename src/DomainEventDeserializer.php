<?php declare(strict_types=1);

namespace spriebsch\DomainEvent;

interface DomainEventDeserializer
{
    public function deserialize(string $domainEvent, string $class): DomainEvent;
}
