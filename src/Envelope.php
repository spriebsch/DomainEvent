<?php declare(strict_types=1);

namespace spriebsch\DomainEvent;

use ReflectionClass;
use RuntimeException;
use spriebsch\timestamp\Timestamp;

final readonly class Envelope
{
    private ?Timestamp $persistedAt;
    private Topic $topic;
    private Payload $payload;

    private function __construct(
        private EventId        $eventId,
        private Timestamp      $receivedAt,
        DomainEvent            $event,
        ?Topic                 $topic,
        private ?CausationId   $causationId,
        private ?SchemaVersion $schemaVersion,
        ?Timestamp             $persistedAt = null,
    )
    {
        $this->topic = $this->determineTopic($topic, $event);
        $this->persistedAt = $persistedAt;
        $this->payload = new Payload($this, $event);
    }

    public static function from(
        DomainEvent    $event,
        ?CausationId   $causationId = null,
        ?SchemaVersion $schemaVersion = null,
    ): self
    {
        return new self(
            EventId::generate(),
            Timestamp::generate(),
            $event,
            null,
            $causationId,
            $schemaVersion,
            null,
        );
    }

    public static function fromStorage(
        EventId        $eventId,
        Timestamp      $receivedAt,
        Timestamp      $persistedAt,
        string         $json,
        string         $class,
        Topic          $topic,
        ?CausationId   $causationId = null,
        ?SchemaVersion $schemaVersion = null,
    ): self
    {
        return new self(
            $eventId,
            $receivedAt,
            new JsonDomainEventDeserializer()->deserialize($json, $class),
            $topic,
            $causationId,
            $schemaVersion,
            $persistedAt,
        );
    }

    public function eventId(): EventId
    {
        return $this->eventId;
    }

    public function topic(): Topic
    {
        return $this->topic;
    }

    public function correlationId(): ?CorrelationId
    {
        $reflection = new ReflectionClass($this->payload()->event());
        $methods = $reflection->getMethods();

        foreach ($methods as $method) {
            $attributes = $method->getAttributes(UseAsCorrelationId::class);

            if (count($attributes) > 1) {
                throw new RuntimeException('Method has more than one UseAsCorrelationId attribute');
            }

            if (count($attributes) === 1) {
                $idMethod = $method->getName();
                $id = $this->payload()->event()->$idMethod();
                if (!$id instanceof AbstractId) {
                    return null; // Unexpected return type; ignore
                }

                return CorrelationId::fromUUID($id->asUUID());
            };
        }

        return null;
    }

    public function causationId(): ?CausationId
    {
        return $this->causationId;
    }

    public function schemaVersion(): SchemaVersion
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

    private function determineTopic(?Topic $topic, DomainEvent $event): Topic
    {
        if ($topic !== null) {
            return $topic;
        }

        $reflection = new ReflectionClass($event);
        $attributes = $reflection->getAttributes(MapToTopic::class);

        foreach ($attributes as $attribute) {
            $instance = $attribute->newInstance();

            return Topic::fromString($instance->topic);
        }

        throw new RuntimeException('Event has no topic attribute');
    }
}
