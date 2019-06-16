<?php

namespace Tests\Unit\DataAccesses\Http\Shared;

use GuzzleHttp\Client as GuzzleClient;
use DataAccesses\Http\Shared\Client;
use Logger\Shared\Client as Logger;
use Tests\TestCase;

class ClientTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function testSetLogger(): void
    {
        $client = new Client(new GuzzleClient());
        $this->assertNull(
            $client->setLogger(new Logger)
        );
    }

    /**
     * @test
     */
    public function testGetLogger(): void
    {
        $client = new Client(new GuzzleClient());
        $this->assertNull(
            $client->getLogger()
        );

        $client->setLogger(new Logger);
        $this->assertTrue(
            $client->getLogger() instanceof Logger
        );
    }

    /**
     * @test
     */
    public function testLog(): void
    {
        $client = new Client(new GuzzleClient());
        $client->setLogger(new Logger);

        ob_start();
        $client->log('ok');
        $actual = ob_get_clean();

        $this->assertTrue(
            strlen(
                strstr($actual, 'ok')
            ) > 0
        );
    }
}
