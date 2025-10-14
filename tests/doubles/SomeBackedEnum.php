<?php declare(strict_types=1);

namespace spriebsch\DomainEvent;

enum SomeBackedEnum: string
{
    case A = 'A';
    case B = 'B';
}
