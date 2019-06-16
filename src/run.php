<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use ValueObjects\YoutubeDataApiKey;
use ValueObjects\YoutubeChannelId;
use ValueObjects\AudioOnly;
use ValueObjects\CheckDateFrom;
use ValueObjects\AsyncDownloadNumber;
use DataAccesses\Http\YoutubeDataApi\GetSearchList;
use DataAccesses\Processes\Process\YoutubeDl;
use GuzzleHttp\Client as GuzzleClient;
use Logger\Shared\Client as Logger;

/* Set Logger */
$logger = new Logger();
$logger->stdout('Start script');

/* factories */
$youtubeDataApiKey = YoutubeDataApiKey::of(getenv('YOUTUBE_DATA_API_KEY'));
$youtubeChannelId = YoutubeChannelId::of(getenv('YOUTUBE_CHANNEL_ID'));
$audioOnly = AudioOnly::of(getenv('AUDIO_ONLY'));
$checkDateFrom = CheckDateFrom::ofString((string) getenv('CHECK_DATE_FROM'));
$asyncDownloadNumber = AsyncDownloadNumber::ofString((string) getenv('ASYNC_DOWNLOAD_NUM'));

/* Get all video details on channels */
$logger->stdout('Get video information from Youtube');
$getSearchList = new GetSearchList(
    new GuzzleClient(),
    $youtubeDataApiKey->asString()
);
$getSearchList->setLogger($logger);
$results = $getSearchList->all(
    $youtubeChannelId->asString(),
    $checkDateFrom->asInt()
);

/* Video download */
$logger->stdout('Download all videos');
$youtubeDl = new YoutubeDl($asyncDownloadNumber->asInt());
$youtubeDl->setLogger($logger);
$youtubeDl->download(
    $results,
    $audioOnly->asString(),
);

$logger->stdout('***');
$logger->stdout('Finished! Please check your "data" directory on app root!');

/* todo: テスト */
/* todo: docker-compose */
/* todo: readme */
