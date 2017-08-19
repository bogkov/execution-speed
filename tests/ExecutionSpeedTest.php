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

namespace Bogkov\ExecutionSpeedTests;

use Bogkov\ExecutionSpeed\ExecutionSpeed;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Class ExecutionSpeedTest
 *
 * @package Bogkov\ExecutionSpeedTests
 */
class ExecutionSpeedTest extends TestCase
{
    /**
     * @return array
     */
    public function providerGetSpeed(): array
    {
        $chunks = [
            [
                1000 => 20, // 50
            ],
            [
                1000 => 19, // 52.631578947368
            ],
            [
                1000 => 18, // 55.555555555556
            ],
            [
                1000 => 17, // 58.823529411765
            ],
            [
                1000 => 16, // 62.5
            ],
            [
                1000 => 15, // 66.666666666667
            ],
            [
                1000 => 14, // 71.428571428571
            ],
            [
                1000 => 13, // 76.923076923077
            ],
            [
                1000 => 9, // 111.11111111111
            ],
            [
                1000 => 13, // 76.923076923077
            ],
            [
                1000 => 13, // 76.923076923077
            ],
            [
                1000 => 13, // 76.923076923077
            ],
            [
                1000 => 13, // 76.923076923077
            ],
        ];

        return [
            'coefficient=0.3 && precision=1' => [
                '$data' => [
                    'max'         => 50,
                    'chunks'      => $chunks,
                    'coefficient' => 0.3,
                    'precision'   => 1,
                    'speed'       => 77.9,
                    'exception'   => null,
                ],
            ],

            'coefficient=0.25 && precision=2' => [
                '$data' => [
                    'max'         => 50,
                    'chunks'      => $chunks,
                    'coefficient' => 0.25,
                    'precision'   => 2,
                    'speed'       => 76.62,
                    'exception'   => null,
                ],
            ],

            'coefficient=0.1 && precision=2' => [
                '$data' => [
                    'max'         => 50,
                    'chunks'      => $chunks,
                    'coefficient' => 0.1,
                    'precision'   => 2,
                    'speed'       => 63.88,
                    'exception'   => null,
                ],
            ],

            'max=' . (ExecutionSpeed::MIN_MAX - 1) . ' bad' => [
                '$data' => [
                    'max'         => ExecutionSpeed::MIN_MAX - 1,
                    'chunks'      => $chunks,
                    'coefficient' => 0.1,
                    'precision'   => 2,
                    'speed'       => 63.88,
                    'exception'   => [
                        'class'   => InvalidArgumentException::class,
                        'message' => 'Max must be more than ' . ExecutionSpeed::MIN_MAX
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider providerGetSpeed
     *
     * @param array $data data
     *
     * @return void
     */
    public function testGetSpeed(array $data)/*: void*/
    {
        if (true === isset($data['exception'])) {
            $this->expectException($data['exception']['class']);
            $this->expectExceptionMessage($data['exception']['message']);
        }

        $executionSpeed = new ExecutionSpeed($data['max']);

        foreach ((array)$data['chunks'] as $chunk) {
            $executionSpeed->push(key($chunk), current($chunk));
        }

        $this->assertEquals($data['speed'], $executionSpeed->getSpeed($data['coefficient'], $data['precision']));
    }
}