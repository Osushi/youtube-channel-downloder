<?php

namespace Tests\Unit\ValueObjects;

use ValueObjects\YoutubeDataApiKey;
use Tests\TestCase;

class YoutubeDataApiKeyTest extends TestCase
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
            'key',
            YoutubeDataApiKey::of('key')->asString()
        );
    }
}
