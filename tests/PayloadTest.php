<?php declare(strict_types=1);

namespace spriebsch\DomainEvent;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Payload::class)]
final class PayloadTest extends TestCase
{
    public function test_can_be_serialized_and_unserialized(): void
    {
        $id = TestId::generate();

        $event = new ComplexEvent(
            $id,
            true,
            'the-string',
            42,
            3.14,
            ['a', 'b', 'c'],
            SomeEnum::A,
            SomeBackedEnum::B,
            new SomeValueObject(
                true,
                'the-string',
                42,
                3.14,
                ['a', 'b', 'c'],
                SomeEnum::A,
                SomeBackedEnum::B,
                new NestedValueObject('the-string')
            ),
            new Nullable(
                null,
                null,
                null,
                null,
                null,
                null,
                null,
            )
        );

        $envelope = Envelope::from($event);
        $payload = $envelope->payload();

        $json = $payload->asJson();

        $recreated = Envelope::fromStorage(
            $envelope->eventId(),
            $envelope->receivedAt(),
            $json,
            $envelope->topic()
        );

        $this->assertEquals($event, $recreated->payload()->event());
    }
}
