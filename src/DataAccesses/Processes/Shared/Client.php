<?php

declare(strict_types=1);

namespace DataAccesses\Processes\Shared;

use Symfony\Component\Process\Process;
use Logger\Shared\Client as Logger;

class Client
{
    /** @var Logger */
    protected $logger;

    /**
     * @param array $commands
     * @return Process
     */
    public function exec(
        array $commands
    ): Process {
        $process = new Process($commands);
        $process->start();

        return $process;
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
