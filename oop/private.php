<?php

// If a property is public, anyone can modify it freely, which might break your logic. Making it private ensures that changes go through a controlled process.

// Example (without private, problem scenario)

class User {
    public $password; // Public is dangerous!

    public function __construct($password) {
        $this->password = $password;
    }
}

$user = new User("secret123");
$user->password = "hacked"; // ❌ Directly modified

// ------------------------------------------------------------


// Example (with private, controlled modification)

class User2 {
    private $password; // Private: Only accessible inside the class

    public function __construct($password) {
        $this->setPassword($password);
    }

    private function hashPassword($password) {
        return md5($password); // Example hashing (not secure in real life)
    }

    public function setPassword($password) {
        $this->password = $this->hashPassword($password); // ✅ Securely setting password
    }

    public function getPassword() {
        return $this->password;
    }
}

$user = new User2("secret123");
$user->setPassword("newPass"); // ✅ Allowed through a method
echo $user->getPassword(); // ✅ Access with a getter
// $user->password = "hacked"; // ❌ ERROR: Cannot modify private property

// ------------------------------------------------------------

// Sometimes, you have methods that are only meant to be used internally, not by external code or child classes.

class BankAccount {
    private $balance = 0;

    public function deposit($amount) {
        $this->balance += $amount;
        $this->logTransaction("Deposited: $amount");
    }

    public function withdraw($amount) {
        if ($this->balance >= $amount) {
            $this->balance -= $amount;
            $this->logTransaction("Withdrew: $amount");
        } else {
            echo "Insufficient funds!";
        }
    }

    private function logTransaction($message) {
        // This logs transactions, but we don’t want external access
        echo "Transaction: " . $message;
    }
}

$account = new BankAccount();
$account->deposit(100); // ✅ Works
$account->withdraw(50); // ✅ Works
// $account->logTransaction("Testing"); // ❌ ERROR: Private method, can't access


// -------------------------------------------------------------------------------------------------

// If a method is protected, child classes can override it. But if you make it private, it can't be overridden—ensuring critical functionality remains unchanged

class ParentClass {
    private function secretMethod() {
        return "This can't be overridden!";
    }
}

class ChildClass extends ParentClass {
    public function secretMethod() {
        return "Overridden"; // ❌ ERROR: Can't override private method
    }
}
