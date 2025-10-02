<?php declare(strict_types=1);

namespace spriebsch\DomainEvent;

use Crell\Serde\SerdeCommon;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\TestCase;

#[CoversNothing]
class SerializationTest extends TestCase
{
    public function test_serde_serializes_and_deserializes_object(): void
    {
        $id = TestId::generate();
        $serde = new SerdeCommon();

        $object = new ComplexEvent(
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
                SomeBackedEnum::B
            ),
            new NullableTest(
                null,
                null,
                null,
                null,
                null,
                null,
                null,
            )
        );

        $jsonString = $serde->serialize($object, format: 'json');
        $deserializedObject = $serde->deserialize($jsonString, from: 'json', to: ComplexEvent::class);
        $this->assertEquals($object, $deserializedObject);
    }
}
