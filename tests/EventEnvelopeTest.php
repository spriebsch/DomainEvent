<?php declare(strict_types=1);

namespace spriebsch\DomainEvent;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use spriebsch\timestamp\Timestamp;

#[CoversClass(Envelope::class)]
final class EventEnvelopeTest extends TestCase
{
    public function test_create_sets_all_properties(): void
    {
        $topic = EventTopic::fromString('spriebsch.training.eventSourcing.created');
        $correlationId = CorrelationId::generate();
        $causationId = CausationId::generate();
        $schemaVersion = SchemaVersion::from(3);
        $event = $this->createMock(DomainEvent::class);

        $envelope = Envelope::from($event, $topic, $correlationId, $causationId, $schemaVersion);

        $this->assertInstanceOf(EventId::class, $envelope->eventId());
        $this->assertSame($topic, $envelope->topic());
        $this->assertSame($correlationId, $envelope->correlationId());
        $this->assertSame($causationId, $envelope->causationId());
        $this->assertSame($schemaVersion, $envelope->schemaVersion());
        $this->assertSame($event, $envelope->payload()->event());
    }

    public function test_has_schema_version(): void
    {
        $topic = EventTopic::fromString('spriebsch.training.eventSourcing.created');
        $event = $this->createMock(DomainEvent::class);
        $schemaVersion = SchemaVersion::from(3);

        $envelope = Envelope::from($event, $topic, null, null, $schemaVersion);

        $this->assertTrue($schemaVersion->equals($envelope->schemaVersion()));
    }

    public function test_has_schema_version_defaults_to_1(): void
    {
        $topic = EventTopic::fromString('spriebsch.training.eventSourcing.created');
        $event = $this->createMock(DomainEvent::class);

        $envelope = Envelope::from($event, $topic);

        $this->assertSame(1, $envelope->schemaVersion()->asInt());
    }

    public function test_CorrelationId_is_optional(): void
    {
        $topic = EventTopic::fromString('spriebsch.training.eventSourcing.created');
        $event = $this->createMock(DomainEvent::class);

        $envelope = Envelope::from($event, $topic);

        $this->assertNull($envelope->correlationId());
    }

    public function test_CausationId_is_optional(): void
    {
        $topic = EventTopic::fromString('spriebsch.training.eventSourcing.created');
        $event = $this->createMock(DomainEvent::class);

        $envelope = Envelope::from($event, $topic);

        $this->assertNull($envelope->causationId());
    }

    public function test_envelope_knows_if_it_was_persisted(): void
    {
        $persistedAt = Timestamp::generate();
        $topic = EventTopic::fromString('spriebsch.training.eventSourcing.created');
        $event = $this->createMock(DomainEvent::class);

        $envelope = Envelope::from($event, $topic);
        $persisted = Envelope::fromPersisted(
            $envelope->eventId(),
            $persistedAt,
            $envelope->payload()->event(),
            $topic
        );

        $this->assertFalse($envelope->isPersisted());
        $this->assertTrue($persisted->isPersisted());
    }

    public function test_receivedAt_is_generated_on_envelope_creation(): void
    {
        $topic = EventTopic::fromString('spriebsch.training.eventSourcing.created');
        $event = $this->createMock(DomainEvent::class);

        $envelope = Envelope::from($event, $topic);

        $this->assertInstanceOf(Timestamp::class, $envelope->receivedAt());
    }

    public function test_persistedAt_is_null_by_default(): void
    {
        $topic = EventTopic::fromString('spriebsch.training.eventSourcing.created');
        $event = $this->createMock(DomainEvent::class);

        $envelope = Envelope::from($event, $topic);

        $this->assertNull($envelope->persistedAt());
    }
}
