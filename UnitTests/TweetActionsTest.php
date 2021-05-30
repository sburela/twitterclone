<?php 

use PHPUnit\Framework\TestCase;
require "RestAPI/TweetActions.php";

/* 
Unit Tests for  Section 3 of Twitter Clone, written for below functionality.
1. User login session check 
2. Like/dislike a tweet
3. Retweet
4. Threading
*/

class TweetActionsTest extends TestCase {

    protected $userta;
    // Create session for user login as it is a prerequisite for the user to perform tweet actions.
    // Arguements - email & password must present in DB
    public function setUp() : void {
        $this->userta = new TweetActions;
        $this->userta->email = "testuser@xyz.com";
        $this->userta->password = "Testuser123";
        $this->userta->login($this->userta->email, $this->userta->password);
    }

    // Successful test - like a tweet 
    // Arguements - tweetid
    public function testSuccessLikeTweet() { 
        
        $this->userta->tid = 25;
        $result = $this->userta->likeTweet($this->userta->tid);
        
        $this->assertTrue($result);
        print "\n You liked the tweet: ".$this->userta->tid;
    }
    
    // Successful test - unlike a tweet
    // Arguements - tweetid
    public function testSuccessUnlikeTweet() { 
        $this->userta->tid = 26;
        $result = $this->userta->unlikeTweet($this->userta->tid);
        
        $this->assertTrue($result);
        print "\n You unliked the tweet: ".$this->userta->tid;
    }

    // Successful test - retweet a tweet
    // Arguements - tweetid
    public function testSuccessReTweet() { 
        $this->userta->tid = 30;
        $result = $this->userta->reTweet($this->userta->tid);
        
        $this->assertTrue($result);
        print "\n You retweeted the tweet: ".$this->userta->tid;
    }

    // Successful test - comment a tweet
    // Arguements - tweetid, comment message
    public function testSuccessCommentTweet() { 
        $this->userta->tid = 15;
        $this->userta->comment = "This is a test comment from phpunit";
        $result = $this->userta->commentTweet($this->userta->tid, $this->userta->comment);
        
        $this->assertTrue($result);
        print "\n You commented for the tweet: ".$this->userta->tid;
    }
    
    // Successful test - reply to a comment of a tweet
    // Arguements - tweetid, reply msg, comment_id
    public function testSuccessReplyToCommentOfTweet() { 
        $this->userta->tid = 8;
        $this->userta->parentthreadid = 2;
        $this->userta->replymsg = "This is a test reply to a comment of a tweet from phpunit";
        $result = $this->userta->replyToCommentOfTweet($this->userta->tid, $this->userta->parentthreadid, $this->userta->replymsg);
        
        $this->assertTrue($result);
        print "\n You commented for the tweet: ".$this->userta->tid;
        print_r($result);
    }
}

    
?>