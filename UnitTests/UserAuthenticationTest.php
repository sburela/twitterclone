<?php

use PHPUnit\Framework\TestCase;
require "RestAPI/UserAuthentication.php";

/* 
Unit Tests for Section 1 of Twitter Clone, written for below functionality.
1. User registration with input validation using RegEx
2. User login with session management
*/

class UserAuthenticationTest extends TestCase {

    protected $user;
    public function setUp() : void {
        $this->user = new UserAuthentication;
    }

    // Successful registration with new user
    public function testSuccessUserRegister() { 
        
        $this->user->email = "testuser44@xyz.com";
        $this->user->password = "Testuser123";
        $result = $this->user->register($this->user->email, $this->user->password);
        
        $this->assertTrue($result);
        print "\n Registration successful for the email: ".$this->user->email;
    }
    
    // Failed registration with existing user email
    public function testFailUserRegister() {
        
        $this->user->email = "testuser@xyz.com";
        $this->user->password = "Testuser123";
        $result = $this->user->register($this->user->email, $this->user->password);

        $this->assertFalse($result);
        print "\n Registration failed for Email: " .$this->user->email. " Email already exists!";
    }

    // SuccSuccessful login with registered user
    public function testSuccessUserLogin() {
        
        $this->user->email = "testuser@xyz.com";
        $this->user->password = "Testuser123";
        $result = $this->user->login($this->user->email, $this->user->password);

        $this->assertTrue($result);
        print "\n Login successful for Email: " .$this->user->email;
    }

    // Failed login with incorrect password
    public function testFailUserLogin() {
        
        $this->user->email = "testuser@xyz.com";
        $this->user->password = "dfgdsg";
        $result = $this->user->login($this->user->email, $this->user->password);

        $this->assertFalse($result);
        print "\n Login failed for email: " .$this->user->email. " Invalid email/password ";
    }
}

?>