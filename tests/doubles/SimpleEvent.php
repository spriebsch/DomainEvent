<?php declare(strict_types=1);

namespace spriebsch\DomainEvent;

#[MapToTopic('spriebsch.domainEvent.test.simple')]
final readonly class SimpleEvent implements TestEvent
{
    private TestId $id;
    #[UseAsCorrelationId]
    public function id(): TestId
    {
        if (!isset($this->id)) {
            $this->id = TestId::generate();
        }

        return $this->id;
    }
}
