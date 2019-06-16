<?php

namespace Tests\Unit\ValueObjects;

use ValueObjects\AsyncDownloadNumber;
use Tests\TestCase;

class AsyncDownloadNumberTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function testOfString(): void
    {
        $this->assertSame(
            1,
            AsyncDownloadNumber::ofString('1')->asInt()
        );
    }
}
