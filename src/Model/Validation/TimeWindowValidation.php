<?php
declare(strict_types=1);

namespace App\Model\Validation;

class TimeWindowValidation
{
    /**
     * Validate that the given time is not in the future.
     *
     * @param mixed $value The value to validate.
     * @return bool
     */
    public static function notInFuture(mixed $value): bool
    {
        $time = $value instanceof \DateTimeInterface
            ? $value
            : new \DateTimeImmutable((string)$value);

        return $time <= new \DateTimeImmutable('now');
    }

    /**
     * Validate that the given time is within the last N years.
     *
     * @param mixed $value The value to validate.
     * @param int $years Max age in years.
     * @return bool
     */
    public static function withinLastYears(mixed $value, int $years): bool
    {
        $time = $value instanceof \DateTimeInterface
            ? $value
            : new \DateTimeImmutable((string)$value);

        $min = new \DateTimeImmutable('-' . $years . ' years');

        return $time >= $min;
    }
}
