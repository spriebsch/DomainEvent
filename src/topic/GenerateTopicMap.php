<?php declare(strict_types=1);

use spriebsch\DomainEvent\DomainEvent;
use spriebsch\DomainEvent\MapToTopic;

final readonly class GenerateTopicMap
{
    public static function for(string $directory): void
    {
        if (!is_dir($directory)) {
            throw new RuntimeException(
                sprintf('Directory "%s" does not exist', $directory)
            );
        }

        foreach (glob($directory . '/*.php') as $file) {
            if (basename($file) == 'TopicMap.php') {
                continue;
            }

            require_once $file;
        }

        $allClasses = get_declared_classes();

        $result = [];

        foreach ($allClasses as $class) {
            $interfaces = class_implements($class);

            if (in_array(DomainEvent::class, $interfaces)) {
                $attributes = new ReflectionClass($class)->getAttributes(MapToTopic::class);

                if ($attributes !== []) {
                    $result[$attributes[0]->newInstance()->topic] = $class;
                }
            }
        }

        file_put_contents(
            $directory . '/TopicMap.php',
            '<?php return ' . var_export($result, true) . ';'
        );
    }
}
