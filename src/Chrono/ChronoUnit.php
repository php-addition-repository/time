<?php

namespace PAR\Time\Chrono;

use PAR\Enum\Enum;
use PAR\Time\Duration;
use PAR\Time\Temporal\TemporalUnit;

/**
 * A standard set of date periods units.
 *
 * @method static self MICROS()
 * @method static self MILLIS()
 * @method static self SECONDS()
 * @method static self MINUTES()
 * @method static self HOURS()
 * @method static self HALF_DAYS()
 * @method static self DAYS()
 * @method static self WEEKS()
 * @method static self MONTHS()
 * @method static self YEARS()
 * @method static self DECADES()
 * @method static self CENTURIES()
 * @method static self MILLENIA()
 * @method static self FOREVER()
 */
final class ChronoUnit extends Enum implements TemporalUnit
{
    protected const MICROS = [false, true, 0, 1];
    protected const MILLIS = [false, true, 0, self::MILLI_IN_MICROS];
    protected const SECONDS = [false, true, 1];
    protected const MINUTES = [false, true, self::MINUTE_IN_SECONDS];
    protected const HOURS = [false, true, self::HOUR_IN_SECONDS];
    protected const HALF_DAYS = [false, true, self::DAY_IN_SECONDS / 12];
    protected const DAYS = [true, false, self::DAY_IN_SECONDS];
    protected const WEEKS = [true, false, self::DAY_IN_SECONDS * self::WEEK_IN_DAYS];
    protected const MONTHS = [true, false, (self::DAY_IN_SECONDS * self::YEAR_IN_DAYS) / self::YEAR_IN_MONTHS];
    protected const YEARS = [true, false, self::DAY_IN_SECONDS * self::YEAR_IN_DAYS];
    protected const DECADES = [true, false, self::DAY_IN_SECONDS * self::YEAR_IN_DAYS * self::DECADE_IN_YEARS];
    protected const CENTURIES = [true, false, self::DAY_IN_SECONDS * self::YEAR_IN_DAYS * self::CENTURY_IN_YEARS];
    protected const MILLENIA = [true, false, self::DAY_IN_SECONDS * self::YEAR_IN_DAYS * self::MILLENIUM_IN_YEARS];
    protected const FOREVER = [false, false, PHP_INT_MAX];

    public const MILLI_IN_MICROS = 1000;
    public const MINUTE_IN_SECONDS = 60;
    public const HOUR_IN_MINUTES = 60;
    public const HALF_DAY_IN_HOURS = 12;
    public const DAY_IN_HOURS = 24;
    public const WEEK_IN_DAYS = 7;
    public const YEAR_IN_DAYS = 365;
    public const YEAR_IN_MONTHS = 12;
    public const DECADE_IN_YEARS = 10;
    public const CENTURY_IN_YEARS = 100;
    public const MILLENIUM_IN_YEARS = 1000;

    public const HOUR_IN_SECONDS = self::MINUTE_IN_SECONDS * self::HOUR_IN_MINUTES;
    public const DAY_IN_MINUTES = self::DAY_IN_HOURS * self::HOUR_IN_MINUTES;
    public const DAY_IN_SECONDS = self::DAY_IN_MINUTES * self::MINUTE_IN_SECONDS;

    /**
     * @var bool
     */
    private $dateBased;

    /**
     * @var bool
     */
    private $timeBased;

    /**
     * @var int
     */
    private $durationInSeconds;

    /**
     * @var int
     */
    private $durationInMicros;

    /**
     * @param bool $dateBased
     * @param bool $timeBased
     * @param int  $durationSeconds
     * @param int  $durationMicros
     */
    protected function __construct(bool $dateBased, bool $timeBased, int $durationSeconds, int $durationMicros = 0)
    {
        $this->dateBased = $dateBased;
        $this->timeBased = $timeBased;
        $this->durationInSeconds = $durationSeconds;
        $this->durationInMicros = $durationMicros;
    }

    /**
     * @inheritDoc
     */
    public function isDateBased(): bool
    {
        return $this->dateBased;
    }

    /**
     * @inheritDoc
     */
    public function isTimeBased(): bool
    {
        return $this->timeBased;
    }

    /**
     * @inheritDoc
     */
    public function isDurationEstimated(): bool
    {
        return $this->isDateBased();
    }

    /**
     * @inheritDoc
     */
    public function getDuration(): Duration
    {
        return Duration::of($this->durationInSeconds, $this->durationInMicros);
    }

}
