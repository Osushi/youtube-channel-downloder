<?php

declare(strict_types=1);

namespace DataAccesses\Processes\Process;

use DataAccesses\Processes\Shared\Client;

class YoutubeDl extends Client
{
    /** @var int */
    protected $asyncDownloadNumber;

    /** @var string */
    protected $destPath = __DIR__ . '/../../../../data';

    /**
     * @param int $asyncDownloadNumber
     */
    public function __construct(
        int $asyncDownloadNumber
    ) {
        $this->asyncDownloadNumber = $asyncDownloadNumber;
    }

    /**
     * @param array $videos
     * @param string $audioOnly
     * @return void
     */
    public function download(
        array $videos,
        string $audioOnly
    ): void {
        $queues = [];
        foreach ($videos as $video) {
            $commands = [
                'youtube-dl',
                '-o',
                $this->destPath . '/%(title)s.%(ext)s',
                'https://www.youtube.com/watch?v=' . $video['id']['videoId'],
            ];
            if ($audioOnly === 'true') {
                $commands[] = '-x';
            }

            $this->log('Downloading... ' . $video['snippet']['title']);

            $queues[] = $this->exec($commands);

            if (count($queues) === $this->asyncDownloadNumber) {
                $this->wait($queues);
                $queues = [];
            }
        }

        if (count($queues)) {
            $this->wait($queues);
        }
    }

    /**
     * @param array $queues
     * @return void
     */
    private function wait(
        array $queues
    ): void {
        for (;;) {
            foreach ($queues as $key => $queue) {
                if (!$queue->isRunning()) {
                    unset($queues[$key]);
                }
            }

            if (count($queues) === 0) {
                break;
            }
            sleep(1);
        }
    }
}
