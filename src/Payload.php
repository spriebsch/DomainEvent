<?php declare(strict_types=1);

namespace spriebsch\DomainEvent;

use Crell\Serde\SerdeCommon;

readonly class Payload
{
    public function __construct(
        private Envelope    $envelope,
        private DomainEvent $event
    ) {}

    public function envelope(): Envelope
    {
        return $this->envelope;
    }

    public function event(): DomainEvent
    {
        return $this->event;
    }

    public function asJson(): string
    {
        return new SerdeCommon()->serialize($this->event, format: 'json');
    }
}
