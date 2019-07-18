<?php

namespace PARTest\Time;

use PAR\Core\PHPUnit\CoreAssertions;
use PAR\Enum\EnumMap;
use PAR\Time\Chrono\ChronoField;
use PAR\Time\EnumMapHelper;
use PAR\Time\Exception\UnsupportedTemporalTypeException;
use PAR\Time\Factory;
use PAR\Time\Month;
use PAR\Time\Temporal\TemporalAccessor;
use PAR\Time\Temporal\TemporalField;
use PAR\Time\YearMonth;

class YearMonthTest extends TimeTestCase
{
    use CoreAssertions;

    public function provideListOfFields(): array
    {
        $supported = [
            ChronoField::YEAR(),
            ChronoField::MONTH_OF_YEAR(),
        ];

        $map = EnumMap::for(ChronoField::class, 'bool', false);

        EnumMapHelper::putAllFalse($map, ChronoField::values());
        EnumMapHelper::putAllTrue($map, $supported);

        return EnumMapHelper::toProviderArray($map);
    }

    public function provideSupportedFieldsWithValue(): array
    {
        $map = EnumMap::for(ChronoField::class, 'int', false);

        $map->put(ChronoField::YEAR(), 2000);
        $map->put(ChronoField::MONTH_OF_YEAR(), 5);

        return EnumMapHelper::toProviderArray($map);
    }

    public function provideUnsupportedFields(): array
    {
        $supported = [
            ChronoField::YEAR(),
            ChronoField::MONTH_OF_YEAR(),
        ];

        $map = EnumMap::for(ChronoField::class, 'bool', false);

        EnumMapHelper::putAllNotIn($map, $supported, false);

        return EnumMapHelper::toProviderArray($map);
    }

    public function testCanBeComparedWithOtherYearMonth(): void
    {
        $this->assertSame(0, YearMonth::of(2000, 1)->compareTo(YearMonth::of(2000, 1)));
        $this->assertGreaterThan(0, YearMonth::of(2000, 1)->compareTo(YearMonth::of(1990, 1)));
        $this->assertGreaterThan(0, YearMonth::of(2000, 6)->compareTo(YearMonth::of(2000, 1)));
        $this->assertLessThan(0, YearMonth::of(2000, 1)->compareTo(YearMonth::of(2008, 1)));
        $this->assertLessThan(0, YearMonth::of(2000, 1)->compareTo(YearMonth::of(2000, 8)));
    }

    public function testCanCreateFromNow(): void
    {
        $this->wrapWithTestNow(
            static function () {
                $now = Factory::now();

                $current = YearMonth::now();

                self::assertSameYear($now, $current->getYear());
                self::assertSameMonth($now, $current->getMonthValue());
            }
        );
    }

    public function testCanCreateFromTemporal(): void
    {
        $temporal = \Mockery::mock(TemporalAccessor::class);
        $temporal->shouldReceive('get')->with(ChronoField::YEAR())->andReturn(2000);
        $temporal->shouldReceive('get')->with(ChronoField::MONTH_OF_YEAR())->andReturn(2);

        self::assertSameObject(YearMonth::of(2000, 2), YearMonth::from($temporal));
    }

    public function testCanCreateOfNative(): void
    {
        $expected = 2018;
        $dt = Factory::createDate($expected, 3, 4);

        $current = YearMonth::ofNative($dt);

        self::assertSameYear($dt, $current->getYear());
        self::assertSameMonth($dt, $current->getMonthValue());
    }

    public function testCanDetermineEquality(): void
    {
        self::assertTrue(YearMonth::of(2000, 1)->equals(YearMonth::of(2000, 1)));
        self::assertFalse(YearMonth::of(2000, 1)->equals(YearMonth::of(2001, 1)));
        self::assertFalse(YearMonth::of(2000, 1)->equals(YearMonth::of(2000, 2)));
        self::assertFalse(YearMonth::of(2000, 1)->equals(null));
    }

    /**
     * @dataProvider provideListOfFields
     *
     * @param TemporalField $field
     * @param bool          $expected
     */
    public function testCanDetermineIfFieldIsSupported(TemporalField $field, bool $expected): void
    {
        $temporal = YearMonth::of(2000, 1);

        $this->assertSame($expected, $temporal->supportsField($field));
    }

    /**
     * @dataProvider provideSupportedFieldsWithValue
     *
     * @param ChronoField $supportedField
     * @param int         $expectedValue
     */
    public function testCanRetrieveValueOfSupportedFields(ChronoField $supportedField, int $expectedValue): void
    {
        $temporal = YearMonth::of(2000, 5);

        self::assertSame($expectedValue, $temporal->get($supportedField));
    }

    public function testCreateFromIntegers(): void
    {
        $yearMonth = YearMonth::of(1, 2);
        self::assertSame(1, $yearMonth->getYear());
        self::assertSame(2, $yearMonth->getMonthValue());
        self::assertSameObject(Month::of(2), $yearMonth->getMonth());
    }

    /**
     * @dataProvider provideUnsupportedFields
     *
     * @param ChronoField $unsupportedField
     */
    public function testRetrievingValueOfUnsupportedFieldThrowsException(ChronoField $unsupportedField): void
    {
        $this->expectException(UnsupportedTemporalTypeException::class);

        YearMonth::of(2000, 5)->get($unsupportedField);
    }
}
