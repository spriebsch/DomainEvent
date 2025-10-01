<?php declare(strict_types=1);

namespace spriebsch\DomainEvent;

use spriebsch\timestamp\Timestamp;

final readonly class Envelope
{
    private Timestamp $receivedAt;
    private ?Timestamp $persistedAt;

    private Payload $payload;

    private function __construct(
        private EventId        $eventId,
        DomainEvent            $event,
        private EventTopic     $topic,
        private ?CorrelationId $correlationId,
        private ?CausationId   $causationId,
        private ?SchemaVersion $schemaVersion,
        ?Timestamp             $persistedAt = null,
    )
    {
        $this->receivedAt = Timestamp::generate();
        $this->persistedAt = $persistedAt;
        $this->payload = new Payload($this, $event);
    }

    public static function from(
        DomainEvent    $event,
        EventTopic     $topic,
        ?CorrelationId $correlationId = null,
        ?CausationId   $causationId = null,
        ?SchemaVersion $schemaVersion = null,
    ): self
    {
        return new self(
            EventId::generate(),
            $event,
            $topic,
            $correlationId,
            $causationId,
            $schemaVersion,
            null,
        );
    }

    public static function fromPersisted(
        EventId        $eventId,
        Timestamp      $persistedAt,
        DomainEvent    $event,
        EventTopic     $topic,
        ?CorrelationId $correlationId = null,
        ?CausationId   $causationId = null,
        ?SchemaVersion $schemaVersion = null,
    ): self
    {
        return new self(
            $eventId,
            $event,
            $topic,
            $correlationId,
            $causationId,
            $schemaVersion,
            $persistedAt,
        );
    }

    public function eventId(): EventId
    {
        return $this->eventId;
    }

    public function topic(): EventTopic
    {
        return $this->topic;
    }

    public function correlationId(): ?CorrelationId
    {
        return $this->correlationId;
    }

    public function causationId(): ?CausationId
    {
        return $this->causationId;
    }

    public function schemaVersion(): ?SchemaVersion
    {
        if ($this->schemaVersion === null) {
            return SchemaVersion::from(1);
        }

        return $this->schemaVersion;
    }

    public function receivedAt(): Timestamp
    {
        return $this->receivedAt;
    }

    public function isPersisted(): bool
    {
        return isset($this->persistedAt);
    }

    public function persistedAt(): ?Timestamp
    {
        if (!$this->isPersisted()) {
            return null;
        }

        return $this->persistedAt;
    }

    public function payload(): Payload
    {
        return $this->payload;
    }
}
