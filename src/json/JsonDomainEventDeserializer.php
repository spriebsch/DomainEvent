<?php declare(strict_types=1);

namespace spriebsch\DomainEvent;

use Crell\Serde\SerdeCommon;

final readonly class JsonDomainEventDeserializer implements DomainEventDeserializer
{
    public function deserialize(string $domainEvent, string $class): DomainEvent
    {
        return new SerdeCommon()->deserialize($domainEvent, from: 'json', to: $class);
    }
}
