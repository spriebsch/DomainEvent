<?php declare(strict_types=1);

namespace spriebsch\DomainEvent;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final readonly class MapToTopic
{
    public function __construct(
        public string $topic
    ) {}
}
