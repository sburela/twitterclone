<?php
session_start();
require 'config.php';
require 'config.db.php';

/* 
REST API for Section 1 of Twitter Clone.
It includes: 
1. User registration with input validation using RegEx
2. User login with session management
3. User logout by destroying the user specific session
*/

class UserAuthentication {
    
    private $db_connection;
    public $error_msg;
    
    // Initialising the database connection
    function __construct() {
        $db_connection = new db();
        $this->link = $db_connection->connect();
        return $this->link;
    }

    // Executing a query
    public function fetch_by_query($q) {
        try {
            $q = $this->link->prepare($q);
            $q->execute();
            $results = $q->fetchAll();
            $count = $q->rowCount();
            return $results;
        } catch(PDOException $e){
            return $e->getMessage();
        }
    }

    // Validation of username/email and password
    public function register_valid($email, $pass) {
        $error = "";
        $ret = TRUE; //1 OK, 0 NOK

        // Email must contain @ and . as per valid format
        if(filter_var($email, FILTER_VALIDATE_EMAIL)==FALSE) { 
            $error .= "Please enter valid Email. "; 
            $ret = FALSE;
        }  
        
        // Password must be at least 6 Alpha numeric Chars with atleast 1 uppercase, 1 lowercase and 1 digit
        if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z]{6,}$/', $pass)){  
            $error .= "Password must be at least 6 Alpha numeric Chars"; 
            $ret = FALSE;
        }

        if($ret==0) {
            $error_msg = $error;
        }
        return $ret;   
    }

    // Check if user already exists
    public function user_exist($email) {
        $q = " SELECT * FROM users WHERE user_email='$email' ";
        $results = SELF::fetch_by_query($q);

        if(count($results) >= 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // User registration
    public function register($email, $pass) {
        $arr = explode('@', $email);
        $username = $arr[0]; //This should come from user form data. Currently fetching the email prefix as username
        
        if(SELF::register_valid($email, $pass) == TRUE) {

            $pass = sha1($pass); //password encryption
            $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if(SELF::user_exist($email) == TRUE) {
                $error_msg = "Email already exists!";  
                return FALSE;
            } else {
                $error_msg = null;
                try {
                    $q = $this->link->prepare("INSERT INTO users(user_name, user_email, user_pwd) VALUES(?,?,?)");
                    $values = array($username, $email, $pass);
                    $q->execute($values);
                    $count = $q->rowCount();
                    if($count == 1){
                        return TRUE;
                    } 
                } catch(PDOException $e){
                    return $e->getMessage();
                }
            }
        } else {
            return FALSE;
        }
    }

    // User login with session creation
    public function login($email, $pass) {
        $pass = sha1($pass);
        
        $q = " SELECT * FROM users WHERE (user_email='$email' AND user_pwd='$pass') ";
        $results = SELF::fetch_by_query($q);
        
        if(count($results) >= 1 ) {
            if(isset($results[0]['user_name']) || isset($results[0]['user_id'])){
                $_SESSION['username'] =  $results[0]['user_name'];
                $_SESSION['usr_id'] =  $results[0]['user_id'];
                $_SESSION['active'] = 1; 
                return TRUE;
            }    
        }
        else {
            return FALSE;
        }
    }

    // User logout with session destroy
    public function logout() {
        unset($_SESSION['username']);
        unset($_SESSION['usr_id']);
        unset($_SESSION['active']);
        session_destroy();
    } 
   
}

?>


