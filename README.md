---

An application similar to Twitter. (Without a user interface) just a backend exposing a well-formed REST API. 

- Has correct formatting

- Has resilient error handling

- Exception handling

- Architecture is scalable and easy to maintain

- Tricky parts of the code has proper documentation

- Database queries are efficient

Section 1
- User registration using unique username and a password

- User login (Including session maintenance)

- Unit tests for these basic methods

Section 2
- Create, read, update, delete tweet (Twitter doesn't support update, but I can)

- Unit/Integration tests for _all_ endpoints

Section 3
- Like/unlike a tweet

- Retweet

- Threading
---

Developed Features:

REST API's & Unit Tests for :

1. User Registration with input validation using RegEx
2. User Login/Logout based on Session management
3. Create, Read, Update, Delete a tweet
4. Like/dislike a tweet
5. Retweet
6. Comments/Threading

Languages & Frameworks used:

1. PHP, PDO, Mysql, phpunit

Database Schema:

1. users table to store all the user information
2. tweets table to store the tweets.
3. tweet_likes_info table to store what tweet liked by whoom. A user can dislike a tweet only affter its liked by him. Keeping this in mind, handling dislike tweet by just deleting the respective tweet in this table.
4. tweet_retweets_info table to store the retweets along with parent tweet id.
5. tweet_comments_info to store all the parent comments for tweets
6. tweet_comment_replies to store all the child comments/replies for parent comments.

Primary keys, AI, Foriegn Keys, Dependency are maintained while creating the DB schema. Status flag for all the tables is maintained inorder to restore the history when required. If status =1 then active/visible to user. if 0 then deleted/inactive. This is to avoid deleting the information from the DB.

Available test users in the database: (email - Password)

1. testuser@xyz.com - Testuser123
2. qaz@xyz.com - 235aMO

Note: Please foollow the instructions/comments mentioned in the UnitTests to execute the assertions.
Back-end architecture is developed in a flexible way that can be modified as per the requirements. APIs can be reused or extended. Database can be extended further to contain user profile information,

Database is deployed in Heroku. Please add below code in XAMPP/phpmyadmin/config.inc.php to connect to the database.
(Database name is : heroku_2ee1b2ba097646d)

/_ Heroku remote server - twitterclone backend REST API, phpunit _/
/_ mysql://bc9af26d07907e:2587679a@us-cdbr-east-04.cleardb.com/heroku_2ee1b2ba097646d?reconnect=true _/
$i++;
$cfg["Servers"][$i]["host"] = "us-cdbr-east-04.cleardb.com"; //provide hostname
$cfg["Servers"][$i]["user"] = "bc9af26d07907e"; //user name for your remote server
$cfg["Servers"][$i]["password"] = "2587679a"; //password
$cfg["Servers"][$i]["auth_type"] = "config"; // keep it as config
