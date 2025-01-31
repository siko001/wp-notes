<?php

class Car {
    // Public properties
    public $make;
    public $model;
    public $year;

    // Constructor to initialize car details
    public function __construct($make, $model, $year) {
        $this->make = $make;
        $this->model = $model;
        $this->year = $year;
    }

    // Public method to start the car
    public function startCar() {
        echo "The " . $this->year . " " . $this->make . " " . $this->model . " is now started!\n";
    }

    // Public method to display car details
    public function getCarDetails() {
        return $this->year . " " . $this->make . " " . $this->model;
    }
}

$myCar = new Car("Tesla", "Model S", 2023);

// Accessing public property directly
echo $myCar->make . "\n"; // ✅ Works, prints "Tesla"

// Calling public method
$myCar->startCar(); // ✅ Works, prints "The 2023 Tesla Model S is now started!"

// Accessing public method
echo $myCar->getCarDetails(); // ✅ Works, prints "2023 Tesla Model S"


