<?php

namespace Tests\Unit\DataAccesses\Processes\Shared;

use Logger\Shared\Client as Logger;
use DataAccesses\Processes\Shared\Client;
use Symfony\Component\Process\Process;
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
    public function testExec(): void
    {
        $client = new Client();
        $this->assertTrue(
            $client->exec(['ls']) instanceof Process
        );
    }

    /**
     * @test
     */
    public function testSetLogger(): void
    {
        $client = new Client();
        $this->assertNull(
            $client->setLogger(new Logger)
        );
    }

    /**
     * @test
     */
    public function testGetLogger(): void
    {
        $client = new Client();
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
        $client = new Client();
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
