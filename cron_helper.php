<?php
declare(strict_types=1);

class CronParser {
    public static function getNextRunDate(string $cronExpression, ?int $fromTime = null): int {
        if ($fromTime === null) {
            $fromTime = time();
        }

        $cron = explode(' ', trim($cronExpression));
        if (count($cron) !== 5) {
            throw new Exception("Invalid cron expression format. Must contain exactly 5 fields.");
        }

        list($min, $hour, $day, $month, $dow) = $cron;

        $next = $fromTime;
        // Search up to 5 years in future
        $limit = $fromTime + (5 * 365 * 24 * 3600);

        while ($next < $limit) {
            $next += 60; // increment by minute
            $t = getdate($next);

            if (!self::matchField($min, $t['minutes'])) continue;
            if (!self::matchField($hour, $t['hours'])) continue;
            if (!self::matchField($day, $t['mday'])) continue;
            if (!self::matchField($month, $t['mon'])) continue;
            if (!self::matchField($dow, $t['wday'])) continue;

            return $next;
        }

        throw new Exception("Could not find next execution date within 5 years.");
    }

    private static function matchField(string $field, int $value): bool {
        if ($field === '*') {
            return true;
        }

        if (strpos($field, ',') !== false) {
            $parts = explode(',', $field);
            foreach ($parts as $part) {
                if (self::matchField($part, $value)) {
                    return true;
                }
            }
            return false;
        }

        if (strpos($field, '/') !== false) {
            list($range, $step) = explode('/', $field);
            $step = (int)$step;
            if ($range === '*') {
                return ($value % $step) === 0;
            }
            if (strpos($range, '-') !== false) {
                list($start, $end) = explode('-', $range);
                $start = (int)$start;
                $end = (int)$end;
                return ($value >= $start && $value <= $end && (($value - $start) % $step) === 0);
            }
            $start = (int)$range;
            return ($value >= $start && (($value - $start) % $step) === 0);
        }

        if (strpos($field, '-') !== false) {
            list($start, $end) = explode('-', $field);
            return ($value >= (int)$start && $value <= (int)$end);
        }

        return (int)$field === $value;
    }
}
