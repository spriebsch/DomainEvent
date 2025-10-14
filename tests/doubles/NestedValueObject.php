<?php declare(strict_types=1);

namespace spriebsch\DomainEvent;

final readonly class NestedValueObject
{
    public function __construct(private string $string) {}

    public function string(): string
    {
        return $this->string;
    }
}
