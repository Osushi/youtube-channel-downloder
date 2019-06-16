<?php

namespace Tests\Unit\Logger\Shared;

use Logger\Shared\Client;
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
    public function testStdout(): void
    {
        $client = new Client();

        ob_start();
        $client->stdout('ok', ['param' => 1]);
        $actual = ob_get_clean();

        $this->assertTrue(
            strlen(
                strstr($actual, 'ok')
            ) > 0
        );
    }

    /**
     * @test
     */
    public function testTime(): void
    {
        $client = new Client();

        $method = self::getMethod(
            $client,
            'time'
        );
        $actual = $method->invokeArgs(
            $client,
            []
        );

        $this->assertTrue(
            is_string($actual)
        );
    }
}
