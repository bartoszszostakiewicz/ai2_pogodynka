<?php

namespace App\Tests\Entity;

use App\Entity\Measurement;
use PHPUnit\Framework\TestCase;

class MeasurementTest extends TestCase
{
    /**
     * @dataProvider dataGetFahrenheit
     */
    public function testGetFahrenheit($celsius, $expectedFahrenheit): void
    {
        $measurement = new Measurement();

        $measurement->setCelsius($celsius);
        $this->assertTrue($measurement->getFahrenheit() === $expectedFahrenheit);


    }

    public function dataGetFahrenheit(): array
    {
        return [
            [0, '32'],
            [-100, '-148'],
            [100, '212'],
            [5.2, '41.36'],
            [-2.1, '28.22'],
            [-15.3, '4.46'],
            [21,'69.8'],
            [8,'46.4'],
            [-17.7,'0.14'],
            [5,'41'],
        ];
    }

}
