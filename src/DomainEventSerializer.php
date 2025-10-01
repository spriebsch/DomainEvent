<?php declare(strict_types=1);

namespace spriebsch\DomainEvent;

interface DomainEventSerializer
{
    public function serialize(DomainEvent $event): string;
}
