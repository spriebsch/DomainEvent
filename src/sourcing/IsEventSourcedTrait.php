<?php declare(strict_types=1);

namespace spriebsch\DomainEvent;

trait IsEventSourcedTrait
{
    use CanApplyDomainEventsTrait;

    public static function sourceFrom(DomainEvent ...$events): self
    {
        $instance = new self(...$events);
        $instance->reconstituteFrom(...$events);

        return $instance;
    }

    private function reconstituteFrom(DomainEvent ...$events): void
    {
        foreach ($events as $event) {
            $this->apply($event);
        }
    }
}
