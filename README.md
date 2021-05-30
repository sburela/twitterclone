---

Create an application similar to Twitter. DO NOT BUILD A USER INTERFACE, just a backend exposing a well-formed API. You can use anything you want for the server and storage layer. The API must adhere to REST standards. Focus on completing the basic functionality before moving on to the rest. The code you write is expected to be good quality, it should:

- Have correct formatting

- Have resilient error handling

- Exceptions should appropriate handling

- Architecture should be scalable, easy to maintain

- Tricky parts of the code should have proper documentation

\*\* Database queries should be efficient

Section 1

- User registration using unique username and a password

- User login (Including session maintenance using any means you're comfortable with)

- Unit tests for these basic methods
  These two APIs must be perfect. DO NOT move on to the remainder of the assignment until these are completed. If either of these APIs are missing or incomplete, the remainder of the assignment WILL NOT be scored at all.

Section 2
Start _only_ once the Basic Functionality is complete. Complete these _in the order specified_

- Chat with other users

- Create, read, update, delete tweet (Twitter doesn't support update, can you?)

- Unit/Integration tests for _all_ endpoints you've built so far (Basic & Extended Functionality)

Section 3
Start _only_ once section 1 and 2 functionality is complete. The following endpoints are for bonus points, and you SHOULD NOT attempt them until all previous requirements are completed.

- Like/unlike a tweet

- Retweet

- Threading

If you can implement message queues/ real-time queries then go ahead and make a feature that’s not listed above. You can skip section 2 and 3 of the tests if you have an idea for these.

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
