<?php

interface Flyable {
    public function fly();
}

interface Swimable {
    public function swim();
}

class Duck implements Flyable, Swimable {
    // must implement all methods of the interfaces
    public function fly() {
        return "I am flying!";
    }

    public function swim() {
        return "I am swimming!";
    }
}


//----------------------------------------------


interface Shape {
    public function area();
}

interface Drawable extends Shape {
    public function draw();
}

class Circle implements Drawable {
    // must implement all methods of the interfaces
    public function area() {
        return pi() * 4 * 4;  // example calculation
    }

    public function draw() {
        return "Drawing a circle";
    }
}



//----------------------------------------------

//// Real-World Example:

// Imagine a Payment Gateway system where different payment methods (like CreditCard, PayPal, etc.) all need to have the same methods, such as charge() and refund(), but each method will behave differently for each class.

interface PaymentGateway {
    public function charge($amount);
    public function refund($transactionId);
}

class CreditCardPayment implements PaymentGateway {
    public function charge($amount) {
        return "Charging {$amount} to the credit card.";
    }

    public function refund($transactionId) {
        return "Refunding transaction {$transactionId} to the credit card.";
    }
}

class PayPalPayment implements PaymentGateway {
    public function charge($amount) {
        return "Charging {$amount} to PayPal account.";
    }

    public function refund($transactionId) {
        return "Refunding transaction {$transactionId} to PayPal account.";
    }
}

// Now, you can use any of these classes interchangeably wherever you need a PaymentGateway.

function processPayment(PaymentGateway $payment) {
    echo $payment->charge(100);  // The charge method works based on the type of payment gateway
}

$payment = new CreditCardPayment();
processPayment($payment);  // Output: Charging 100 to the credit card.
