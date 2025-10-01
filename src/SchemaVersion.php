<?php declare(strict_types=1);

namespace spriebsch\DomainEvent;

final readonly class SchemaVersion
{
    private function __construct(private int $value) {}

    public static function from(int $value): self
    {
        return new self($value);
    }

    public function equals(self $other): bool
    {
        return $this->asInt() === $other->asInt();
    }

    public function asInt(): int
    {
        return $this->value;
    }
}
