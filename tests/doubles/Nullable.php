<?php declare(strict_types=1);

namespace spriebsch\DomainEvent;

final readonly class Nullable
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
