<?php
/*
 * This file is part of the Execution Speed package.
 *
 * (c) Bogdan Koval' <scorpioninua@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Bogkov\ExecutionSpeed;

use InvalidArgumentException;

/**
 * Class ExecutionSpeed
 *
 * @package Bogkov\ExecutionSpeed
 */
class ExecutionSpeed
{
    const MIN_MAX = 5;
    const MIN_COEFFICIENT = 0.001;

    /**
     * @var array
     */
    protected $stack = [];

    /**
     * @var int
     */
    protected $max = 50;

    /**
     * ExecutionSpeed constructor
     *
     * @param int $max max
     *
     * @throws InvalidArgumentException
     */
    public function __construct(int $max = 50)
    {
        if (static::MIN_MAX > $max) {
            throw new InvalidArgumentException('Max must be more than ' . static::MIN_MAX);
        }

        $this->max = $max;
    }

    /**
     * @param int $count    count
     * @param int $duration duration
     *
     * @return void
     */
    public function push(int $count, int $duration)/*: void*/
    {
        \array_unshift(
            $this->stack,
            [
                $count => $duration,
            ]
        );

        $this->stack = \array_slice($this->stack, 0, $this->max);
    }

    /**
     * @param float $coefficient
     * @param int   $precision
     *
     * @return float
     */
    public function getSpeed(float $coefficient = 0.3, int $precision = 1): float
    {
        $coefficients = $this->getCoefficients($coefficient);

        $result = null;

        foreach ($this->stack as $index => $item) {
            $value = key($item) / current($item);
            $coefficient = $coefficients[$index];

            if (null !== $result) {
                $average = ($result + $value) / 2;
                $difference = $result - $average;
                $actualDifference = $difference - $difference * (1 - $coefficient);
                $value = $result - $actualDifference;
            }

            $result = $value;
        }

        return \round($result, $precision);
    }

    /**
     * @param float $coefficient coefficient
     *
     * @return array
     */
    protected function getCoefficients(float $coefficient): array
    {
        $value = 1;

        $coefficients = [
            $value,
        ];

        $max = $this->max;
        while (--$max > 0) {
            $value -= ($coefficient * $value);

            if (static::MIN_COEFFICIENT >= $value) {
                $value = static::MIN_COEFFICIENT;
            }

            $coefficients[] = $value;
        }

        return $coefficients;
    }
}