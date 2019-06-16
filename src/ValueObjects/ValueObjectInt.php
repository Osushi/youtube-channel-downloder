<?php

declare(strict_types=1);

namespace ValueObjects;

trait ValueObjectInt
{
    use ValueObjectOf;

    /** @var int */
    private $value;

    /**
     * @param int $value
     */
    private function __construct(
        int $value
    ) {
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function asInt(): int
    {
        return $this->value;
    }
}
