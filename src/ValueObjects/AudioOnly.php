<?php

declare(strict_types=1);

namespace ValueObjects;

use \InvalidArgumentException;
use Webmozart\Assert\Assert;

final class AudioOnly
{
    use ValueObjectString;

    /**
     * @param string $value
     * @throws InvalidArgumentException
     */
    private function __construct(
        string $value
    ) {
        Assert::stringNotEmpty($value, 'Invalid audio only. Got: %s');
        Assert::oneOf($value, ['true', 'false'], 'Invalid audio only. Only: true|false Got: %s');
        $this->value = $value;
    }
}
