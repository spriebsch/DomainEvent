<?php declare(strict_types=1);

namespace spriebsch\DomainEvent;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Envelope::class)]
#[CoversClass(Payload::class)]
final class DomainEventTest extends TestCase
{
    public function test_some(): void
    {
        $id = TestId::generate();

        $events = [
            EventA::from($id),
            EventB::from($id),
            EventC::from($id),
        ];

        $envelopes = [];

        foreach ($events as $event) {
            $envelopes[] = Envelope::from($event);
        }

        $this->expectNotToPerformAssertions();
    }
}
