## Object Oriented Programing Cheatsheet

| Modifier      | Accessible inside class? | Inherited by child classes? | Accessible outside class? |
| ------------- | ------------------------ | --------------------------- | ------------------------- |
| **Public**    | ✅ Yes                   | ✅ Yes                      | ✅ Yes                    |
| **Protected** | ✅ Yes                   | ✅ Yes                      | ❌ No                     |
| **Private**   | ✅ Yes                   | ❌ No                       | ❌ No                     |

---

### When Should You Use Public?

#### ✅ Use public when:

-   You want data or functionality to be accessible from anywhere (inside or outside the class).
-   The public access modifier is the least restrictive and allows access to the property or method from anywhere: inside the class, from child classes, and outside the class. If you want a method or property to be part of the public interface of your class, use public.
-   You might have a getter method or a public action that anyone can call.

### When Should You Use Protected Data?

#### ✅ Use protected when:

-   You want to share functionality or data with child classes, but not with external code.
-   You have a base class that provides core functionality, and subclasses need access to that functionality but you don't want it to be accessible from outside the class hierarchy.
-   You use protected to allow child classes to access and modify data or logic that’s not intended for external access. This is useful when you want to allow child classes to build on or customize the behavior, while still hiding the details from outside classes.

### When Should You Use Private?

Using private ensures that the class’s internal logic and data are completely encapsulated and not accessible from outside or from subclasses.

#### ✅ Use private when:

-   You don’t want external code or child classes to modify or access a property/method.
-   You need to protect data from direct modification.
-   You have helper functions inside a class that shouldn't be exposed.
-   You want to prevent unintended method overriding in child classes.

### TL;DR

-   Public: Use when the property/method should be accessible from anywhere.
-   Protected: Use when the property/method should be accessible only within the class and subclasses.
-   Private: Use when the property/method should be accessible only within the class itself to ensure data security, encapsulation, and internal logic protection.

---

## Final

all classes are extendable by default unless explicitly marked as final. Regular Classes: These can be extended freely. If you create a class like this:

### Use of the 'final' keyword

If a class is marked as final, it cannot be extended. This is useful when you want to prevent any further inheritance or modification of the class behavior.

### Using the final Keyword on Methods

Similarly, if a method is declared as final, it cannot be overridden by child classes, even though the class itself may still be extendable.

### Why Use final Classes or Methods?

#### You might want to use final to:

-   Prevent alteration of important functionality. If you want to make sure a class or method is not changed (for reasons like security or consistency), you can declare it final.
-   Improve performance: In some cases, PHP can optimize final classes and methods, knowing that they can't be extended or overridden.

## TL;DR

-   All classes are extendable by default unless marked as final.
-   Final classes cannot be extended at all.
-   Final methods cannot be overridden in child classes, but the class itself can still be extended.

---

## Interface

### What is an Interface?

An interface is like a blueprint that a class can follow. It defines a set of methods that a class must implement, but it does not provide the actual code for those methods.

```php
interface Animal {
    public function speak();  // Method signature without implementation
    public function move();
}
```

```php
class Dog implements Animal {
    public function speak() {
        return "Woof!";
    }

    public function move() {
        return "Runs on four legs!";
    }
}
```

### Key Points About Interfaces

-   No Method Implementation: Interfaces only declare method signatures. They don’t define how those methods should work, leaving that to the class implementing the interface.
-   A Class Can Implement Multiple Interfaces: Unlike classes, which can only inherit from one parent class (unless using multiple traits), a class can implement multiple interfaces. This allows for more flexible and modular design.
-   A Class Must Implement All Methods: If a class declares that it implements an interface, it must implement all of the interface’s methods. If any method is not implemented, PHP will throw an error.
-   Interface Inheritance: Just like classes, interfaces can extend other interfaces. This means a new interface can inherit methods from an existing one.
-   No Visibility Keywords: All methods in an interface must be public, because interface methods are meant to be accessible outside the class. You can’t make them 'protected' or private.
-   Type Hinting with Interfaces: You can type-hint an interface in method parameters, ensuring that only classes that implement that interface can be passed to the method.
```php
function printArea(Shape $shape) {
    echo $shape->area();
}

$circle = new Circle();
printArea($circle);  // ✅ This works because Circle implements Shape
```


### Why Use Interfaces?
* Decouple Code: Interfaces allow you to define consistent contracts that multiple classes can implement, but the classes themselves can have different internal logic. This leads to looser coupling.
* Multiple Implementations: If you need multiple classes to share the same method signatures but with different implementations, interfaces provide a way to enforce this structure.
* Flexibility in Design: You can design flexible code that works with many different classes, as long as they implement the same interface.


### TL;DR:
* Interfaces define a contract that classes must follow.
* No implementation in interfaces, just method declarations.
* A class that implements an interface must implement all methods declared in that interface.
* A class can implement multiple interfaces.
* Interfaces are useful for decoupling and ensuring classes provide certain methods, regardless of their internal implementation.


<!-- STATIC -->
<!-- ABSTRACT -->