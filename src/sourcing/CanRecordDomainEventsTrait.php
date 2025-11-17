<?php declare(strict_types=1);

namespace spriebsch\DomainEvent;

trait CanRecordDomainEventsTrait
{
    use CanApplyDomainEventsTrait;

    /** @var DomainEvent[] */
    private array $newEvents = [];

    /** @return DomainEvent[] */
    public function newEvents(): array
    {
        $events = $this->newEvents;
        $this->newEvents = [];

        return $events;
    }

    private function record(DomainEvent $event): void
    {
        $this->newEvents[] = $event;
        $this->apply($event);
    }
}
