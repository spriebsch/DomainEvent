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
        $causationId = CausationId::generate();
        $schemaVersion = SchemaVersion::from(3);

        $event = new SimpleEvent();

        $envelope = Envelope::from($event, $causationId, $schemaVersion);

        $this->assertInstanceOf(EventId::class, $envelope->eventId());
        $this->assertTrue($event->id()->equals($envelope->correlationId()));
        $this->assertSame($causationId, $envelope->causationId());
        $this->assertTrue($schemaVersion->equals($envelope->schemaVersion()));
        $this->assertSame($event, $envelope->payload()->event());
    }

    public function test_has_schema_version(): void
    {
        $event = new SimpleEvent();
        $schemaVersion = SchemaVersion::from(3);

        $envelope = Envelope::from($event, null, $schemaVersion);

        $this->assertTrue($schemaVersion->equals($envelope->schemaVersion()));
    }

    public function test_has_schema_version_defaults_to_1(): void
    {
        $event = new SimpleEvent();

        $envelope = Envelope::from($event);

        $this->assertSame(1, $envelope->schemaVersion()->asInt());
    }

    public function test_CorrelationId_is_optional(): void
    {
        $event = new EventWithoutCorrelationId();

        $envelope = Envelope::from($event);

        $this->assertNull($envelope->correlationId());
    }

    public function test_CausationId_is_optional(): void
    {
        $event = new SimpleEvent();

        $envelope = Envelope::from($event);

        $this->assertNull($envelope->causationId());
    }

    public function test_envelope_knows_if_it_was_persisted(): void
    {
        $topic = EventTopic::fromString('spriebsch.training.eventSourcing.created');
        $persistedAt = Timestamp::generate();
        $event = new SimpleEvent();

        $envelope = Envelope::from($event);

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
        $event = new SimpleEvent();

        $envelope = Envelope::from($event);

        $this->assertInstanceOf(Timestamp::class, $envelope->receivedAt());
    }

    public function test_persistedAt_is_null_by_default(): void
    {
        $event = new SimpleEvent();

        $envelope = Envelope::from($event);

        $this->assertNull($envelope->persistedAt());
    }
}
