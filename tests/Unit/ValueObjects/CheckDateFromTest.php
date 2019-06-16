<?php

namespace Tests\Unit\ValueObjects;

use \InvalidArgumentException;
use Carbon\CarbonImmutable;
use ValueObjects\CheckDateFrom;
use Tests\TestCase;

class CheckDateFromTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function testOf(): void
    {
        $this->assertSame(
            20100101,
            CheckDateFrom::ofString('20100101')->asInt()
        );
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function testOfRules(): void
    {
        $date = CarbonImmutable::now()->addDays(1)->format('Ymd');
        CheckDateFrom::ofString($date);
    }
}
