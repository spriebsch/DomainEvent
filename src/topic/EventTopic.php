<?php declare(strict_types=1);

namespace spriebsch\DomainEvent;

use InvalidArgumentException;
use RuntimeException;

final readonly class EventTopic
{
    public function __construct(
        private string $vendor,
        private string $domain,
        private string $context,
        private string $name,
    ) {
    }

    public static function fromComponents(
        string $vendor,
        string $domain,
        string $context,
        string $name
    ): self
    {
        return new self($vendor, $domain, $context, $name);
    }

    public static function fromString(string $topic): self
    {
        if (substr_count($topic, '.') !== 3) {
            throw new RuntimeException('At least three dots!');
        }

        $parts = explode('.', $topic);
        if (count($parts) !== 4) {
            throw new InvalidArgumentException(sprintf('Invalid topic format: %s. Expected vendor.domain.context.name', $topic));
        }

        [$vendor, $domain, $context, $name] = $parts;
        if ($vendor === '' || $domain === '' || $context === '' || $name === '') {
            throw new InvalidArgumentException('Topic components must be non-empty strings.');
        }

        return new self($vendor, $domain, $context, $name);
    }

    public function vendor(): string
    {
        return $this->vendor;
    }

    public function domain(): string
    {
        return $this->domain;
    }

    public function context(): string
    {
        return $this->context;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function asString(): string
    {
        return sprintf(
            '%s.%s.%s.%s',
            $this->vendor,
            $this->domain,
            $this->context,
            $this->name
        );
    }
}
