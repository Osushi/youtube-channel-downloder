<?php

declare(strict_types=1);

namespace ValueObjects;

use \InvalidArgumentException;
use Webmozart\Assert\Assert;
use Carbon\CarbonImmutable;

final class CheckDateFrom
{
    use ValueObjectInt;

    /**
     * @param int $value
     * @throws InvalidArgumentException
     */
    private function __construct(
        int $value
    ) {
        Assert::integer($value, 'Invalid check date from. Got: %s');
        Assert::greaterThan($value, 0, 'Invalid check date from, Must be greater than 0.  Got: %s');
        $now = CarbonImmutable::now();
        $time = CarbonImmutable::createFromFormat('Ymd', (string) $value);
        if (!$time || $now->timestamp < $time->timestamp) {
            throw new InvalidArgumentException('Invalid check date from, Must be before time. Got: ' . $value);
        }
        $this->value = $value;
    }

    /**
     * @param string $value
     * @throws InvalidArgumentException
     */
    public static function ofString(
        string $value
    ): CheckDateFrom {
        $value = filter_var($value, FILTER_VALIDATE_INT);
        return new self(
            (int) $value
        );
    }
}
