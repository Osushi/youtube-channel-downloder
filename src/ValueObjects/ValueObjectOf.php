<?php

declare(strict_types=1);

namespace ValueObjects;

trait ValueObjectOf
{
    /**
     * @param mixed $value
     * @return self
     */
    public static function of(
        $value
    ): self {
        return new self($value);
    }
}
