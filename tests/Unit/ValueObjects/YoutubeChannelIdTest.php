<?php

namespace Tests\Unit\ValueObjects;

use ValueObjects\YoutubeChannelId;
use Tests\TestCase;

class YoutubeChannelIdTest extends TestCase
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
            'id',
            YoutubeChannelId::of('id')->asString()
        );
    }
}
