<?php

declare(strict_types=1);

namespace ValueObjects;

use \InvalidArgumentException;
use Webmozart\Assert\Assert;

final class AsyncDownloadNumber
{
    use ValueObjectInt;

    /**
     * @param int $value
     * @throws InvalidArgumentException
     */
    private function __construct(
        int $value
    ) {
        Assert::integer($value, 'Invalid async download number. Got: %s');
        Assert::greaterThan($value, 0, 'Invalid async download number, Must be greater than 0.  Got: %s');
        $this->value = $value;
    }

    /**
     * @param string $value
     * @throws InvalidArgumentException
     */
    public static function ofString(
        string $value
    ): AsyncDownloadNumber {
        $value = filter_var($value, FILTER_VALIDATE_INT);
        return new self(
            (int) $value
        );
    }
}
