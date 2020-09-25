<?php

namespace Spatie\TestTime\Tests;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use PHPUnit\Framework\TestCase;
use Spatie\TestTime\TestTime;

class TestTimeTest extends TestCase
{
    /** @test */
    public function it_can_control_the_flow_of_time()
    {
        $now = Carbon::createFromFormat('Y-m-d H:i:s', '2019-01-02 03:44:55');

        TestTime::freeze($now);
        $this->assertEquals('2019-01-02 03:44:55', (new Carbon())->format('Y-m-d H:i:s'));
        $this->assertEquals('2019-01-02 03:44:55', (new CarbonImmutable())->format('Y-m-d H:i:s'));

        TestTime::addYear();
        $this->assertEquals('2020', (new Carbon())->format('Y'));
        $this->assertEquals('2020', (new CarbonImmutable())->format('Y'));

        TestTime::addYear()->addYear();
        $this->assertEquals('2022', (new Carbon())->format('Y'));
        $this->assertEquals('2022', (new CarbonImmutable())->format('Y'));
    }

    /** @test */
    public function it_will_freeze_the_current_time_by_passing_no_arguments_to_it()
    {
        TestTime::freeze();
        $previousTimestamp = Carbon::now()->timestamp;

        sleep(2);
        $newTimestamp = Carbon::now()->timestamp;

        $this->assertEquals($previousTimestamp, $newTimestamp);
    }

    /** @test */
    public function the_freeze_function_can_accept_the_format_and_time()
    {
        TestTime::freeze('Y-m-d', '1979-09-22');

        $this->assertEquals('1979-09-22', Carbon::now()->format('Y-m-d'));
        $this->assertEquals('1979-09-22', CarbonImmutable::now()->format('Y-m-d'));
    }

    /** @test */
    public function it_can_freeze_the_current_time_at_the_start_of_the_second()
    {
        TestTime::freezeAtSecond('Y-m-d H:i:s.u', '2019-01-02 03:44:55.667788');

        $this->assertEquals('2019-01-02 03:44:55.000000', (new Carbon)->format('Y-m-d H:i:s.u'));
    }
}
