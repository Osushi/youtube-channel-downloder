<?php

namespace Tests\Unit\DataAccesses\Processes\Shared;

use \Mockery;
use Symfony\Component\Process\Process;
use DataAccesses\Processes\Process\YoutubeDl;
use Tests\TestCase;

class YoutubeDlTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();

        Mockery::close();
    }

    /**
     * @test
     */
    public function testDownload(): void
    {
        $mock = Mockery::mock("DataAccesses\Processes\Process\YoutubeDl", [2])->makePartial();
        $mock->shouldReceive('exec')->andReturn(new Process('date'));

        $this->assertNull(
            $mock->download(
                [
                    [
                        'id' => [
                            'videoId' => '1',
                        ],
                        'snippet' => [
                            'title' => 'title',
                        ],
                    ],
                    [
                        'id' => [
                            'videoId' => '2',
                        ],
                        'snippet' => [
                            'title' => 'title',
                        ],
                    ],
                    [
                        'id' => [
                            'videoId' => '3',
                        ],
                        'snippet' => [
                            'title' => 'title',
                        ],
                    ],
                ],
                'true'
            )
        );
    }

    /**
     * @test
     */
    public function testWait(): void
    {
        $process = new Process('date');
        $process->start();

        $youtubeDl = new YoutubeDl(1);
        $method = self::getMethod(
            $youtubeDl,
            'wait'
        );
        $actual = $method->invokeArgs(
            $youtubeDl,
            [
                [$process],
            ]
        );

        $this->assertNull($actual);
    }
}
