<?php

namespace Tests\Unit\DataAccesses\Http\YoutubeDataApi;

use \Throwable;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client as GuzzleClient;
use Carbon\CarbonImmutable;
use DataAccesses\Http\YoutubeDataApi\GetSearchList;
use Tests\TestCase;

class GetSearchListTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function testAll(): void
    {
        $bodies = [];
        $bodies[] = json_encode([
            'kind' => 'youtube#searchListResponse',
            'etag' => 'etag',
            'regionCode' => 'JP',
            'pageInfo' => [
                'totalResults' => 5,
                'resultsPerPage' => 50,
            ],
            'nextPageToken' => 'token',
            'items' => [
                [
                    'kind' => 'youtube#searchResult',
                    'etag' => 'etag',
                    'id' => [
                        'kind' => 'youtube#video',
                        'videoId' => 'videoid',
                    ],
                    'snippet' => [
                        'publishedAt' => '2019-06-12T02:17:51.000Z',
                        'channelId' => 'channelId',
                        'title' => 'title',
                        'description' => 'description',
                        'thumbnails' => [
                            'default' => [
                                'url' => 'https://example.com/image01.jpg',
                                'width' => 120,
                                'height' => 90,
                            ],
                            'medium' =>  [
                                'url' => 'https://example.com/image02.jpg',
                                'width' => 320,
                                'height' => 180,
                            ],
                            'high' => [
                                'url' => 'https://example.com/image03.jpg',
                                'width' => 480,
                                'height' => 360,
                            ],
                        ],
                        'channelTitle' => 'channel_title',
                        'liveBroadcastContent' => 'none',
                    ],
                ],
            ],
        ]);
        $bodies[] = json_encode([
            'kind' => 'youtube#searchListResponse',
            'etag' => 'etag',
            'regionCode' => 'JP',
            'pageInfo' => [
                'totalResults' => 5,
                'resultsPerPage' => 50,
            ],
            'items' => [
            ],
        ]);
        $mock = new MockHandler([
            new Response(200, [], $bodies[0]),
            new Response(200, [], $bodies[1]),
            new Response(200, [], $bodies[0]),
            new Response(200, [], $bodies[1]),
        ]);
        $handler = HandlerStack::create($mock);

        $getSearchList = new GetSearchList(
            new GuzzleClient(['handler' => $handler]),
            'key'
        );
        $this->assertTrue(
            count(
                $getSearchList->all(
                    'key',
                    (int) CarbonImmutable::now()->subMonths(1)->format('Ymd')
                )
            ) === 2
        );
    }

    /**
     * @test
     */
    public function testRun(): void
    {
        $bodies = [];
        $bodies[] = json_encode([
            'kind' => 'youtube#searchListResponse',
            'etag' => 'etag',
            'regionCode' => 'JP',
            'pageInfo' => [
                'totalResults' => 5,
                'resultsPerPage' => 50,
            ],
            'nextPageToken' => 'token',
            'items' => [
                [
                    'kind' => 'youtube#searchResult',
                    'etag' => 'etag',
                    'id' => [
                        'kind' => 'youtube#video',
                        'videoId' => 'videoid',
                    ],
                    'snippet' => [
                        'publishedAt' => '2019-06-12T02:17:51.000Z',
                        'channelId' => 'channelId',
                        'title' => 'title',
                        'description' => 'description',
                        'thumbnails' => [
                            'default' => [
                                'url' => 'https://example.com/image01.jpg',
                                'width' => 120,
                                'height' => 90,
                            ],
                            'medium' =>  [
                                'url' => 'https://example.com/image02.jpg',
                                'width' => 320,
                                'height' => 180,
                            ],
                            'high' => [
                                'url' => 'https://example.com/image03.jpg',
                                'width' => 480,
                                'height' => 360,
                            ],
                        ],
                        'channelTitle' => 'channel_title',
                        'liveBroadcastContent' => 'none',
                    ],
                ],
            ],
        ]);
        $bodies[] = json_encode([
            'kind' => 'youtube#searchListResponse',
            'etag' => 'etag',
            'regionCode' => 'JP',
            'pageInfo' => [
                'totalResults' => 5,
                'resultsPerPage' => 50,
            ],
            'items' => [
            ],
        ]);
        $mock = new MockHandler([
            new Response(200, [], $bodies[0]),
            new Response(200, [], $bodies[1]),
            new RequestException('Request Exception', new Request('Get', '')),
        ]);
        $handler = HandlerStack::create($mock);

        $getSearchList = new GetSearchList(
            new GuzzleClient(['handler' => $handler]),
            'key'
        );
        $this->assertTrue(
            count(
                $getSearchList->run(
                    'channelId',
                    CarbonImmutable::now(),
                    CarbonImmutable::now(),
                )
            ) > 0
        );
    }

    /**
     * @test
     * @expectedException Throwable
     */
    public function testRunRules(): void
    {
        $mock = new MockHandler([
            new RequestException('Request Exception', new Request('Get', '')),
        ]);
        $handler = HandlerStack::create($mock);

        $getSearchList = new GetSearchList(
            new GuzzleClient(['handler' => $handler]),
            'key'
        );
        $getSearchList->run(
            'channelId',
            CarbonImmutable::now(),
            CarbonImmutable::now(),
        );
    }

    /**
     * @test
     */
    public function testBuildQuery(): void
    {
        $getSearchList = new GetSearchList(
            new GuzzleClient(),
            'key'
        );
        $method = self::getMethod(
            $getSearchList,
            'buildQuery'
        );
        $actual = $method->invokeArgs(
            $getSearchList,
            [
                'channelId',
                CarbonImmutable::createFromFormat('Ymd His', '19700101 000000'),
                CarbonImmutable::createFromFormat('Ymd His', '19700101 000000'),
                'token',
            ]
        );

        $this->assertSame(
            [
                'key' => 'key',
                'part' => 'snippet',
                'channelId' => 'channelId',
                'maxResults' => 50,
                'order' => 'date',
                'publishedAfter' => '1970-01-01T00:00:00+09:00',
                'publishedBefore' => '1970-01-01T00:00:00+09:00',
                'pageToken' => 'token',
            ],
            $actual
        );
    }
}
