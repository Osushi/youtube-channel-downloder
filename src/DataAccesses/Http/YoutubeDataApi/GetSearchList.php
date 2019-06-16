<?php

declare(strict_types=1);

namespace DataAccesses\Http\YoutubeDataApi;

use \Throwable;
use \RuntimeException;
use DataAccesses\Http\Shared\Client;
use GuzzleHttp\Client as GuzzleClient;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;

final class GetSearchList extends Client
{
    /** @var string */
    protected $host = 'https://www.googleapis.com';

    /** @var string */
    protected $path = '/youtube/v3/search';

    /** @var string */
    protected $key;

    /**
     * @param GuzzleClient $client
     * @param string $key
     */
    public function __construct(
        GuzzleClient $client,
        string $key
    ) {
        $this->key = $key;

        parent::__construct($client);
    }

    /**
     * @param string $channelId
     * @param int $checkDateFrom
     * @throws RuntimeException
     * @return array
     */
    public function all(
        string $channelId,
        int $checkDateFrom
    ): array {
        $publishedBefore = CarbonImmutable::now();
        $publishedAfter = CarbonImmutable::now()->startOfMonth();
        $checkDateFrom = CarbonImmutable::createFromFormat('Ymd', (string) $checkDateFrom);
        if (!$checkDateFrom) {
            throw new RuntimeException('Valid checkDateFrom format: ' . $checkDateFrom);
        }
        $checkDateFrom = $checkDateFrom->startOfMonth();

        $results = [];
        for (;;) {
            $this->log('Fetch video between ' .
                       $publishedAfter->format('Ymd') .
                       ' and ' .
                       $publishedBefore->format('Ymd'));
            $response = $this->run(
                $channelId,
                $publishedBefore,
                $publishedAfter
            );

            if (count($response)) {
                $results = array_merge($results, $response);
            }

            if ($publishedAfter->timestamp === $checkDateFrom->timestamp) {
                break;
            }

            $publishedAfter = $publishedAfter->subMonths(1)->startOfMonth();
            $publishedBefore = $publishedAfter->endOfMonth();
        }

        return $results;
    }

    /**
     * @param string $channelId
     * @param CarbonInterface $publishedBefore
     * @param CarbonInterface $publishedAfter
     * @param string|null $pageToken
     * @throws Throwable
     * @return array
     */
    public function run(
        string $channelId,
        CarbonInterface $publishedBefore,
        CarbonInterface $publishedAfter,
        ?string $pageToken = null
    ): array {
        $results = [];
        try {
            for (;;) {
                $response = $this->client->request(
                    'GET',
                    $this->host . $this->path,
                    [
                    'query' => $this->buildQuery(
                        $channelId,
                        $publishedBefore,
                        $publishedAfter,
                        $pageToken
                    ),
                    ]
                );

                $response = json_decode(
                    (string) $response->getBody(),
                    true
                );

                if (count($response['items'])) {
                    $results = array_merge($results, $response['items']);
                }

                if (isset($response['nextPageToken'])) {
                    $pageToken = $response['nextPageToken'];
                    continue;
                }

                break;
            }
        } catch (Throwable $e) {
            throw $e;
        }

        return $results;
    }

    /**
     * @param string $channelId
     * @param CarbonInterface $publishedBefore
     * @param CarbonInterface $publishedAfter
     * @param string|null $pageToken
     * @return array
     */
    private function buildQuery(
        string $channelId,
        CarbonInterface $publishedBefore,
        CarbonInterface $publishedAfter,
        ?string $pageToken = null
    ): array {
        $query = [
            'key' => $this->key,
            'part' => 'snippet',
            'channelId' => $channelId,
            'maxResults' => 50,
            'order' => 'date',
            'publishedAfter' => $publishedAfter->toRfc3339String(),
            'publishedBefore' => $publishedBefore->toRfc3339String(),
        ];

        if (!is_null($pageToken)) {
            $query['pageToken'] = $pageToken;
        }

        return $query;
    }
}
