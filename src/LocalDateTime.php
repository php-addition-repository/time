<?php declare(strict_types=1);

namespace PAR\Time;

use PAR\Core\ComparableInterface;
use PAR\Core\ObjectInterface;
use PAR\Time\Temporal\Temporal;
use PAR\Time\Temporal\TemporalAmount;
use PAR\Time\Temporal\TemporalField;
use PAR\Time\Temporal\TemporalUnit;

/**
 * A date-time without a time-zone in the ISO-8601 calendar system, such as 2007-12-03T10:15:30.
 */
final class LocalDateTime implements Temporal, ObjectInterface, ComparableInterface
{
    /**
     * @inheritDoc
     */
    public function compareTo(ComparableInterface $other): int
    {
        // TODO: Implement compareTo() method.
        return 0;
    }

    /**
     * @inheritDoc
     */
    public function equals($other): bool
    {
        // TODO: Implement equals() method.
        return false;
    }

    /**
     * @inheritDoc
     */
    public function get(TemporalField $field): int
    {
        // TODO: Implement get() method.
        return 0;
    }

    /**
     * @inheritDoc
     * @return self
     */
    public function minus(int $amountToSubtract, TemporalUnit $unit): self
    {
        // TODO: Implement minus() method.
        return $this;
    }

    /**
     * @inheritDoc
     * @return self
     */
    public function minusAmount(TemporalAmount $amount): self
    {
        // TODO: Implement minusAmount() method.
        return $this;
    }

    /**
     * @inheritDoc
     * @return self
     */
    public function plus(int $amountToAdd, TemporalUnit $unit): self
    {
        // TODO: Implement plus() method.
        return $this;
    }

    /**
     * @inheritDoc
     * @return self
     */
    public function plusAmount(TemporalAmount $amount): self
    {
        // TODO: Implement plusAmount() method.
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function supportsField(TemporalField $field): bool
    {
        // TODO: Implement supportsField() method.
        return false;
    }

    /**
     * @inheritDoc
     */
    public function supportsUnit(TemporalUnit $unit): bool
    {
        // TODO: Implement supportsUnit() method.
        return false;
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        // TODO: Implement toString() method.
        return '';
    }
}
