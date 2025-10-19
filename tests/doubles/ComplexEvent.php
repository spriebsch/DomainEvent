<?php declare(strict_types=1);

namespace spriebsch\DomainEvent;

use Crell\Serde\Attributes\StaticTypeMap;

#[MapToTopic('spriebsch.domainEvent.test.complex')]
final readonly class ComplexEvent implements TestEvent
{
    public function __construct(
        private TestId          $id,
        private bool            $bool,
        private string          $string,
        private int             $int,
        private float           $float,
        private array           $array,
        private SomeEnum        $enum,
        private SomeBackedEnum  $backedEnum,
        #[StaticTypeMap(key: 'type', map: ['someValue' => SomeValueObject::class])]
        private SomeValueObject $valueObject,
        private Nullable        $nullableTest,
    ) {}

    #[UseAsCorrelationId]
    public function id(): TestId
    {
        return $this->id;
    }

    /**
     * @return array<int, string>
     */
    public function array(): array
    {
        // Ensure keys are sequential ints and values are strings for static analysis
        return array_values(array_map(static fn($v): string => (string) $v, $this->array));
    }

    public function valueObject(): SomeValueObject
    {
        return $this->valueObject;
    }

    public function bool(): bool
    {
        return $this->bool;
    }

    public function string(): string
    {
        return $this->string;
    }

    public function int(): int
    {
        return $this->int;
    }

    public function float(): float
    {
        return $this->float;
    }

    public function enum(): SomeEnum
    {
        return $this->enum;
    }

    public function backedEnum(): SomeBackedEnum
    {
        return $this->backedEnum;
    }

    public function nullableTest(): Nullable
    {
        return $this->nullableTest;
    }
}
