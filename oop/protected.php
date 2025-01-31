<?php

// With protected, child classes can access and modify properties and methods from the parent class. This is useful when you want to allow subclasses to interact with internal data or logic but still restrict external access.

class ParentClass {
    protected $name = "Neil"; // Protected property

    protected function greet() { // Protected method
        return "Hello, " . $this->name;
    }
}

class ChildClass extends ParentClass {
    public function sayHi() {
        return $this->greet(); // ✅ Can access protected method from parent
    }

    public function changeName($newName) {
        $this->name = $newName; // ✅ Can access and modify protected property from parent
    }
}

$child = new ChildClass();
echo $child->sayHi(); // ✅ Works, calls protected method from parent
$child->changeName("John"); // ✅ Can change the protected property through child


// What happens outside the class 
$child = new ChildClass();
// echo $child->greet(); // ❌ ERROR: Cannot access protected method from outside
// echo $child->name;   // ❌ ERROR: Cannot access protected property from outside

// -------------------------------------------------------------------------------------------------

// Let’s say you want to share internal methods or properties with child classes, but keep them hidden from the outside world.

class Car {
    protected $fuelLevel = 100;

    protected function drive() {
        $this->fuelLevel -= 10;
        echo "Driving... Fuel level: " . $this->fuelLevel . "\n";
    }
}

class ElectricCar extends Car {
    public function charge() {
        $this->fuelLevel = 100; // ✅ Inherited, can modify fuelLevel
        echo "Charging... Fuel level: " . $this->fuelLevel . "\n";
    }

    public function driveCar() {
        $this->drive(); // ✅ Inherited, can use the protected method drive()
    }
}

$ev = new ElectricCar();
$ev->charge(); // ✅ Works, can access and modify fuelLevel
$ev->driveCar(); // ✅ Works, can call protected drive() method

// What happens outside the class
$ev = new ElectricCar();
// echo $ev->fuelLevel; // ❌ ERROR: Cannot access protected property from outside
// $ev->drive(); // ❌ ERROR: Cannot access protected method from outside


// -------------------------------------------------------------------------------------------------

// The protected modifier is perfect when you want to prevent external code from accessing or modifying class members, but still allow child classes to interact with them.
class Animal {
    protected $name = "Unknown Animal"; // Default name

    protected function speak() {
        return "Some generic animal sound!";
    }

    public function makeSound() {
        return $this->speak(); // ✅ Can access protected method
    }
}

class Dog extends Animal {
    // Constructor to set the name for each dog
    public function __construct($name) {
        $this->name = $name; // Setting the dog's name
    }

    public function speak() {
        return "Woof! My name is " . $this->name; // Now it will use the specific dog's name
    }
}


// What happens inside the class
$dog = new Dog("Rex"); // Create a Dog object and set its name
echo $dog->makeSound(); // ✅ This will work
echo $dog->speak(); // ✅ This will work
echo $dog->name; // ✅ This will not work as it is protected



// What happens outside the class
$dog = new Dog("Rex"); // Create a Dog object and set its name

// This would work because the `speak()` method is public:
echo $dog->speak(); // ✅ This will work and output "Woof! My name is Rex"

// This would work because the `makeSound()` method is public:
echo $dog->makeSound(); // ✅ This will work and output "Woof! My name is Rex"

// But this won't work because `name` is a protected property:
echo $dog->name; // ❌ ERROR: Cannot access protected property `name` from outside


// -------------------------------------------------------------------------------------------------
