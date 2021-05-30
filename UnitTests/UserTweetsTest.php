<?php 

use PHPUnit\Framework\TestCase;
require "RestAPI/UserTweets.php";

/* 
Unit Tests for Section 2 of Twitter Clone, written for below functionality.
1. User login session check 
2. Create, Update, Delete, and Read the tweets
*/

class UserTweetsTest extends TestCase {

    protected $usert;
    // Create session for user login as it is a prerequisite for the user to perform tweet actions.
    // Arguements - email & password must present in DB
    public function setUp() : void {
        $this->usert = new UserTweets;
        $this->usert->email = "testuser@xyz.com";
        $this->usert->password = "Testuser123";
        $this->usert->login($this->usert->email, $this->usert->password);
    }

    // Successful post of a tweet - CREATE
    // No Arguements
    public function testSuccessCreateTweet() { 
        
        $this->usert->tmessage = "Testing the tweet post from phpunit";
        $result = $this->usert->createTweet($this->usert->tmessage);
        
        $this->assertIsInt($result);
        print "\n Tweet posted successfully. Tweet id is: ".$result;
    }
    
    // Successful read all tweets to display in newsfeed for the user - READ
    // No Arguements
    public function testSuccessReadAllTweets() { 

        $result = $this->usert->getTweets();
        
        $this->assertIsArray($result);
        print "\n ******* All tweets *****";
        print_r($result);
    }

    // Successful read only currently loggedin user tweets - My Tweets section for the user - READ
    // No Arguements
    public function testSuccessReadCurrentUserTweets() { 

        $result = $this->usert->getTweets(1);
        
        $this->assertIsArray($result);
        print "\n ******* Tweets of user having email: ".$this->usert->email."*******";
        print_r($result);

    }

    // Successful tweet delete - DELETE
    // Arguement - tweetid must exist in DB
    public function testSuccessDeleteTweet() { 
        
        $this->usert->tid = 28;
        $result = $this->usert->deleteTweet($this->usert->tid);
        
        $this->assertTrue($result);
        print "\n Tweet with id: ".$this->usert->tid. " deleted successfully.";
    }

    // Successful tweet update - UPDATE
    // Arguements - existing tweetid and new tweetmessage
    public function testSuccessUpdateTweet() { 

        $this->usert->tid = 30;
        $this->usert->newtweetmsg = "Testing the update tweet functionality from phpunit. Note: Only format acceptable currently is plain text.";
        $result = $this->usert->updateTweet($this->usert->tid, $this->usert->newtweetmsg);
        
        $this->assertTrue($result);
        print "\n Tweet with id: ".$this->usert->tid. " updated successfully.";
    }
    

}

?>