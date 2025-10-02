<?php declare(strict_types=1);

namespace spriebsch\DomainEvent;

use spriebsch\filesystem\Filesystem;

final class TopicMap
{
    public function fromFile(string $path): self
    {
        return self::fromArray(Filesystem::from($path)->require());
    }

    public function fromArray(array $topicMap): self
    {
        return new self($topicMap);
    }

    private function __construct(private array $topicMap) {}

    public function classFor(string $topic): string
    {
        return $this->topicMap[$topic];
    }

    public function topicFor(DomainEvent $event): string
    {
        return array_flip($this->topicMap)[$event::class];
    }
}
