<?php

declare(strict_types=1);

namespace DataAccesses\Http\Shared;

use GuzzleHttp\Client as GuzzleClient;
use Logger\Shared\Client as Logger;

class Client
{
    /** @var GuzzleClient */
    protected $client;

    /** @var Logger */
    protected $logger;

    /**
     * @param GuzzleClient $client
     */
    public function __construct(
        GuzzleClient $client
    ) {
        $this->client = $client;
    }

    /**
     * @param Logger $logger
     * @return void
     */
    public function setLogger(
        Logger $logger
    ): void {
        $this->logger = $logger;
    }

    /**
     * @return Logger|null
     */
    public function getLogger(): ?Logger
    {
        return $this->logger;
    }

    /**
     * @param string $message
     * @param array $params
     * @return void
     */
    public function log(
        string $message,
        array $params = []
    ) {
        $logger = $this->getLogger();
        if (!is_null($logger)) {
            $logger->stdout(
                $message,
                $params
            );
        }
    }
}
