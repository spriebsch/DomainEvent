<?php declare(strict_types=1);

namespace spriebsch\DomainEvent;

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
        private SomeValueObject $valueObject,
        private NullableTest    $nullableTest,
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
        return $this->array;
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

    public function nullableTest(): NullableTest
    {
        return $this->nullableTest;
    }
}

enum SomeEnum
{
    case A;
    case B;
}

enum SomeBackedEnum: string
{
    case A = 'A';
    case B = 'B';
}

final readonly class SomeValueObject
{
    /**
     * @param array<int, string> $array
     */
    public function __construct(
        private bool           $bool,
        private string         $string,
        private int            $int,
        private float          $float,
        private array          $array,
        private SomeEnum       $enum,
        private SomeBackedEnum $backedEnum,
    ) {}

    /**
     * @return array<int, string>
     */
    public function array(): array
    {
        return $this->array;
    }

    public function bool(): bool { return $this->bool; }

    public function string(): string { return $this->string; }

    public function int(): int { return $this->int; }

    public function float(): float { return $this->float; }

    public function enum(): SomeEnum { return $this->enum; }

    public function backedEnum(): SomeBackedEnum { return $this->backedEnum; }
}

final readonly class NullableTest
{
    /**
     * @param array<int, string>|null $array
     */
    public function __construct(
        private ?bool           $bool,
        private ?string         $string,
        private ?int            $int,
        private ?float          $float,
        private ?array          $array,
        private ?SomeEnum       $enum,
        private ?SomeBackedEnum $backedEnum,
    ) {}

    /**
     * @return array<int, string>|null
     */
    public function array(): ?array
    {
        return $this->array;
    }

    public function bool(): ?bool { return $this->bool; }

    public function string(): ?string { return $this->string; }

    public function int(): ?int { return $this->int; }

    public function float(): ?float { return $this->float; }

    public function enum(): ?SomeEnum { return $this->enum; }

    public function backedEnum(): ?SomeBackedEnum { return $this->backedEnum; }
}
