<?php
// all classes are extendable by default unless explicitly marked as final.
class Animal {
    public function speak() {
        return "Some sound";
    }
}

// Other classes can easily extend it
class Dog extends Animal {
    public function speak() {
        return "Woof!";
    }
}

//--------------------------------------------

// Example of a final class

final class Car {
    public function drive() {
        return "Driving";
    }
}
class SportsCar extends Car {  // ❌ ERROR: Cannot inherit from final class 'Car'
    // Custom code here
}

//--------------------------------------------

// Example of a final method
class Animal2 {
    final public function speak() {
        return "Some sound";
    }
}

class Dog2 extends Animal2 {
    // ❌ ERROR: Cannot override final method Animal::speak()
    public function speak() {
        return "Woof!";
    }
}
