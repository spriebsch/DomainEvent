<?php declare(strict_types=1);

namespace spriebsch\DomainEvent;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Envelope::class)]
#[UsesClass(AbstractId::class)]
#[UsesClass(MapToTopic::class)]
#[UsesClass(Payload::class)]
#[UsesClass(Topic::class)]
#[UsesClass(JsonDomainEventDeserializer::class)]
final class EnvelopeErrorTest extends TestCase
{
    public function test_creating_envelope_without_topic_attribute_throws(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Event has no topic attribute');

        Envelope::from(new EventWithoutTopic());
    }
}
