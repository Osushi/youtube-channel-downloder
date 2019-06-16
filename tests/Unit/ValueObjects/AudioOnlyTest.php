<?php

namespace Tests\Unit\ValueObjects;

use ValueObjects\AudioOnly;
use Tests\TestCase;

class AudioOnlyTest extends TestCase
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
            'true',
            AudioOnly::of('true')->asString()
        );
    }
}
