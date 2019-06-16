<?php

declare(strict_types=1);

namespace ValueObjects;

use \InvalidArgumentException;
use Webmozart\Assert\Assert;

final class YoutubeDataApiKey
{
    use ValueObjectString;

    /**
     * @param string $value
     * @throws InvalidArgumentException
     */
    private function __construct(
        string $value
    ) {
        Assert::stringNotEmpty($value, 'Invalid youtube data api key. Got: %s');
        $this->value = $value;
    }
}
