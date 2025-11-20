<?php declare(strict_types=1);

namespace spriebsch\DomainEvent;

use RuntimeException;

require $_composer_autoload_path;

if (!isset($argv[1])) {
    throw new RuntimeException('Please provide path to the events directory');
}

GenerateTopicMap::for($argv[1]);
