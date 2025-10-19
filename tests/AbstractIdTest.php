<?php declare(strict_types=1);

namespace spriebsch\DomainEvent;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use spriebsch\uuid\UUIDv4;

#[CoversClass(EventId::class)]
#[UsesClass(AbstractId::class)]
final class AbstractIdTest extends TestCase
{
    public function test_generate_creates_valid_uuidv4_string(): void
    {
        $id = EventId::generate();

        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i',
            $id->asString()
        );
    }

    public function test_from_round_trips_string_value(): void
    {
        $generated = EventId::generate();
        $recreated = EventId::from($generated->asString());

        $this->assertTrue($generated->equals($recreated->asUUID()));
    }

    public function test_equals_with_null_returns_false(): void
    {
        $id = EventId::generate();

        $this->assertFalse($id->equals(null));
    }

    public function test_fromUUID_accepts_UUIDv4_instance(): void
    {
        $uuid = UUIDv4::generate();
        $id = EventId::fromUUID($uuid);

        $this->assertSame($uuid->asString(), $id->asUUID()->asString());
    }
}
