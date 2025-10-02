<?php declare(strict_types=1);

use Crell\Serde\SerdeCommon;

require __DIR__ . '/vendor/autoload.php';

class BaseClass
{
    public function __construct(
        protected string $property
    ) {}
}

class ConcreteClass extends BaseClass
{
}

$object = new ConcreteClass('the-value');

var_dump($object);
var_dump((new SerdeCommon())->serialize($object, format: 'json'));
