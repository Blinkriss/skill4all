<?php

namespace Faker\Provider;

class Car extends Base
{
    public const CAR = 'car';
    public const CAR_CATEGORY = 'carCategory';

    protected static $car = [
        'Ford', 'Wolswagen', 'Peugeot', 'Volvo', 'Tesla',
        'Ferrari', 'Renault', 'Lamborgini', 'BMW', 'Mercedes',
        'Audi',
    ];

    protected static $carCategory = [
        'Roadster', 'Break', 'Sedan', 'Pick-up', 'SUV',
        'Crossover', 'Limo', 'Minivan', '4WD', 'Sports car',
        'Off-road', 'Vintage', 'Family',
    ];

    /**
     * @example 'Ford'
     *
     * @return string
     */
    public function car()
    {
        return static::randomElement(static::$car);
    }

    /**
     * @example 'Roadster'
     *
     * @return string
     */
    public function carCategory()
    {
        return static::randomElement(static::$carCategory);
    }
}
