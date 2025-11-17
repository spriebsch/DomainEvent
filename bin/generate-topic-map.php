<?php declare(strict_types=1);

require __DIR__ . '/../src/bootstrap.php';

if (!isset($argv[1])) {
    throw new RuntimeException('Please provide path to the events directory');
}

GenerateTopicMap::for($argv[1]);
