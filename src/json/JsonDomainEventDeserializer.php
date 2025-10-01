<?php declare(strict_types=1);

namespace spriebsch\DomainEvent;

use Crell\Serde\SerdeCommon;

class JsonDomainEventDeserializer implements DomainEventDeserializer
{
    public function deserialize(string $domainEvent): DomainEvent
    {
        // @todo !!! how to determine the class?
        return new SerdeCommon()->deserialize($domainEvent, from: 'json', to: TestEvent::class);
    }
}
