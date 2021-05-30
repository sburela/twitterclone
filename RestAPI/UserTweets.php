<?php
session_start();
require_once('config.php');
require_once('config.db.php');

/* 
REST API for Section 2 of Twitter Clone.
It includes: 
1. User login session check 
2. Create, Update, Delete, and Read the tweets
3. Also has supporting functions
*/

class UserTweets {
    
    public $error_msg;
    // Initialising the database connection
    function __construct() {
        $db_connection = new db();
        $this->link = $db_connection->connect();
        return $this->link;
    }

    // Select a record from a table 
    public function selectQuery($sql, $row) {
        try {
            $q = $this->link->prepare($sql);
            $q->execute($row);
            $results = $q->fetchAll();
            $count = $q->rowCount();
            return $results;
        } catch(PDOException $e) {
            return $e->getMessage();
        }
    }

    // Insert a record into a table
    public function insertQuery($sql, $row) {
        try {
            $result = $this->link->prepare($sql);
            $status = $result->execute($row);
            if ($status) {
                $userId = (int)$this->link->lastInsertId();
                return $userId;
            }
        } catch(PDOException $e){
            return $e->getMessage();
        }
    }

    // Update a record in the table
    public function updateQuery($sql, $row) {
        try {
            $q = $this->link->prepare($sql);
            $q->execute($row);
            $affected = $q->rowCount();
            return $affected;
        } catch(PDOException $e){
            return $e->getMessage();
        }
    }

    // Delete a record from the table
    public function deleteQuery($sql, $where) {
        try {
            $this->link->prepare($sql)->execute($where);
            $affected = $this->link->rowCount();
            return $affected;
        } catch(PDOException $e){
            return $e->getMessage();
        }
    }

    // Execute any complex query
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

    // User login with session creation
    public function login($email, $pass) {
        $pass = sha1($pass);
        
        $q = " SELECT * FROM users WHERE user_email=:email AND user_pwd=:pass ";
        $values = array(
            'email' => $email,
            'pass' => $pass
        );
        $results = SELF::selectQuery($q, $values);
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

    // Function to create a tweet with default status as 1. 
    //status=1 means tweet available to user. status=0 means tweet deleted at user end but still exists in the DB. Useful to pullout the history.
    public function createTweet($tweetpost) {
        $uid = $_SESSION["usr_id"];
        $cdate = DATEX." ".TIMEX; //Constants defined in config.php

        $q = "INSERT INTO tweets SET tw_uid_created=:userid, tw_message=:tweetpost, tw_created_date=:cdate";
        $values = array(
            'userid' => $uid,
            'tweetpost' => $tweetpost,
            'cdate' => $cdate
        );
        $tweet = SELF::insertQuery($q, $values);
        if($tweet > 1) { 
            return $tweet;
        } else{
            return FALSE;
        }
    }

    // Function to return all tweets if parameter value is 0 and tweets per user if value is 1
    public function getTweets($peruser = 0) {
        
        if (isset($_SESSION["usr_id"])) {

            $uid = $_SESSION["usr_id"];
            $q = "SELECT t.tw_message as tweetpost, u.user_name as user, t.tw_id as tweet_id, t.tw_no_of_likes as likes, t.tw_no_of_retweets as retweets FROM tweets t, users u WHERE u.user_id = t.tw_uid_created and t.tw_status = 1";

            if ($peruser == 1) {
                $q .=  " and t.tw_uid_created = ".$uid;
            }
            $result = SELF::fetch_by_query($q);
            
            if(count($result) > 0){
                return $result;
            } else {
                return FALSE;
            } 
        }
    }

    // Function to delete a tweet. Parameter is tweet_id. 
    //  Using status flag instead of deleting the tweet record. Active tweet when status=1 and delete when status set to 0. This is the best practice to maintain history. 
    public function deleteTweet($id){
        
        $query = " UPDATE tweets SET tw_status=0 WHERE tw_id=:id ";
        $value = array('id' => $id);
        $result = SELF::updateQuery($query, $value);
        if ($result > 0) {

            // Upon retweet, a new tweet record is inserted in retweets table. Update the status flag of this if retweet id matches. We can do this for all child tables of tweets as per the requirements.
            $tr_query = " UPDATE tweets_retweets_info SET tr_status=0 WHERE tr_id=:id ";
            $tr_result = SELF::updateQuery($query, $value);

            $tr_query = " UPDATE tweets_comments_info SET tc_status=0 WHERE tc_tweet_id=:id ";
            $tr_result = SELF::updateQuery($query, $value);

            $tr_query = " UPDATE tweet_comments_reply SET tcr_status=0 WHERE tcr_tweet_id=:id ";
            $tr_result = SELF::updateQuery($query, $value);

            $tr_query = " UPDATE tweet_likes_info SET tl_status=0 WHERE tl_tweet_id=:id ";
            $tr_result = SELF::updateQuery($query, $value);
            
            return TRUE;
        }  else {
            return FALSE;
        }
    }  

    // Normal function check to see if the record exists in the tweets table for READ, UPDATE, DELETE transactions
    public function tweetExists($id) {
        $query = " SELECT * FROM tweets WHERE tw_status=1 and tw_id=:id ";
        $value = array('id' => $id);
        $result = SELF::selectQuery($query, $value);
            
        if($result >= 1){
            return true;
        } else {
            return false;
        } 
    }

    // Function to update a tweet. Parameters are Tweet_id and new_tweet_post. 
    // Currently logged in users can update tweets owned by them. Session concept is present
    public function updateTweet($id, $new_tweet_post){
        $user_id = $_SESSION['usr_id'];
        if(SELF::tweetExists($id)) {

            $query = " UPDATE tweets SET tw_message=:newtweet WHERE tw_id=:tweetid and tw_uid_created=:userid ";
            $values = array(
                'newtweet' => $new_tweet_post,
                'tweetid' => $id,
                'userid' => $user_id
            );
            $result = SELF::updateQuery($query, $values);
            if ($result > 0) {
                return TRUE;   
            } 
        } else {
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


