
<?php
session_start();
require_once('config.php');
require_once('config.db.php');

/* 
REST API for Section 3 of Twitter Clone.
It includes: 
1. User login session check 
2. Like/Dislike a tweet, Retweet, Comments for tweets, threads for comments (replies for comments)
3. Also has supporting functions
*/

class TweetActions {
    
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
            $q = $this->link->prepare($sql);
            $q->execute($where);
            $affected = $q->rowCount();
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

    // Function to like a tweet. Parameter is tweet_id. User can like other's tweets.
    // It also updates number of likes of a tweet and store user info who likes the tweet.
    public function likeTweet($id){
        $user_id = $_SESSION['usr_id'];

        $query = "INSERT INTO tweet_likes_info SET tl_tweet_id=:tweetid, tl_liked_by=:userid";
        $values = array(
            'tweetid' => $id,
            'userid' => $user_id
        );
        $liked = SELF::insertQuery($query, $values);

        if($liked >= 1) { 
            $query = " UPDATE tweets SET tw_no_of_likes = tw_no_of_likes+1 WHERE tw_id=:id ";
            $value = array('id' => $id);
            
            $result = SELF::updateQuery($query, $value);
            if ($result > 0) {
                return TRUE;
            }   
         } else {
            return FALSE;
        } 
    }

    // Function to unlike a tweet. Parameter is tweet_id. User can unlike the previously liked tweets.
    // It also updates number of likes of a tweet and store user info who likes the tweet.
    public function unlikeTweet($id) {
        $user_id = $_SESSION['usr_id'];

        $query = "DELETE FROM tweet_likes_info WHERE tl_tweet_id=:tweetid AND tl_liked_by=:userid";
        $values = array(
            'tweetid' => $id,
            'userid' => $user_id
        );
        $unliked = SELF::deleteQuery($query, $values);
        if ($unliked > 0) {
            return TRUE;
        } else {
            return FALSE;
        }   
    }

    // Function to retweet a tweet. Parameter is tweet_id. User can retweet the tweets posted by other users.
    // Inserting a new record in retweets table with the info of who is doing the retweet.

    public function reTweet($id) {
        $user_id = $_SESSION['usr_id'];
        $cdate = DATEX." ".TIMEX;

        $query = "INSERT INTO tweets_retweets_info SET tr_tweet_id=:tweetid, tr_retweeted_by=:userid, tr_created_time=:cdate";
        $values = array(
            'tweetid' => $id,
            'userid' => $user_id,
            'cdate' => $cdate
        );
        $retweet_id = SELF::insertQuery($query, $values);
        if ($retweet_id > 0) {
            $query = " UPDATE tweets SET tw_no_of_retweets = tw_no_of_retweets+1 WHERE tw_id=:id ";
            $value = array('id' => $id);
            
            $result = SELF::updateQuery($query, $value);
            if ($result > 0) {
                return TRUE;
            }   
         } else {
            return FALSE;
        } 
    }

    // Function to comment a tweet. Parameters are tweet_id, comment message. 
    // Inserting ths record in tweet_comments_info table 

    public function commentTweet($id, $comment_msg) {
        $user_id = $_SESSION['usr_id'];
        $cdate = DATEX." ".TIMEX;
        
        $query = "INSERT INTO tweet_comments_info SET tc_tweet_id=:tweetid, tc_commented_by=:userid, tc_comment_date=:cdate, tc_comment=:commentmsg";
        $values = array(
            'tweetid' => $id,
            'userid' => $user_id,
            'cdate' => $cdate,
            'commentmsg' => $comment_msg    
        );
        $comment_id = SELF::insertQuery($query, $values);
        //print "test".$comment_id;
        if ($comment_id > 0) {
            /* We can have a flag called no_of_comments in tweets table and update it. 
            $query = " UPDATE tweets SET tw_no_of_retweets = tw_no_of_retweets+1 WHERE tw_id=:id ";
            $value = array('id' => $id);
            
            $result = SELF::updateQuery($query, $value);
            if ($result > 0) {
                return TRUE;
            }  */ 
            return TRUE;
         } else {
            return FALSE;
        } 
    }

    // Function to reply to a comment of a tweet. Parameters are tweet_id, comment id, userid who is replying, reply message, . 
    // Inserting ths record in tweet_comment_replies table 

    public function replyToCommentOfTweet($tweetid, $commentid, $reply_msg) {
        $user_id = $_SESSION['usr_id'];
        $cdate = DATEX." ".TIMEX;
        
        $query = "INSERT INTO tweet_comment_replies SET tcr_tweet_id=:tweetid, tcr_parent_comment_id=:commentid, tcr_replied_by=:userid, tcr_reply_msg=:replymsg, tcr_reply_time=:cdate";
        $values = array(
            'tweetid' => $tweetid,
            'commentid' => $commentid,
            'userid' => $user_id,
            'replymsg' => $reply_msg,
            'cdate' => $cdate
                
        );
        $row = SELF::insertQuery($query, $values);
        if ($row > 0) {
            return TRUE;
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


