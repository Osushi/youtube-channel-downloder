<?php

declare(strict_types=1);

namespace ValueObjects;

use \InvalidArgumentException;
use Webmozart\Assert\Assert;

final class YoutubeChannelId
{
    use ValueObjectString;

    /**
     * @param string $value
     * @throws InvalidArgumentException
     */
    private function __construct(
        string $value
    ) {
        Assert::stringNotEmpty($value, 'Invalid youtube channel id. Got: %s');
        $this->value = $value;
    }
}
