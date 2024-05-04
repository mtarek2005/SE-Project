<!-- Lorem ipsum -->
<?php
require_once "./include.php";
echo "hellooo\n"; 

/* $user = new User;
$user->UUID = 0;
$post = new Post; 
$post->post_id = 1;
$feed = new ReplyFeed;
$feed->post = $post;
$feed->viewer = $user;
$feed->type = PostTypeEnum::reply;
//$feed->query = "reply"; 
$feed->gatherFeed($main_db);
print_r($feed); */
$user_1 = new User; 
$user_2 = new User; 
$user_1->UUID = 0;
$user_2->UUID = 1;
$chat = new Chat; 
// $chat->to = $user_1;
// $chat->from = $user_2;
// $chat->send($main_db, "This is a test message");
$chat->to = $user_2;
$chat->from = $user_1;
// $chat->send($main_db, "This is a test reply to that message");
$pm = new PMs;
$pm->message_id = 827757441; 
$chat->react($main_db, $pm, "💩");
$chat->gatherFeed($main_db);
print_r($chat);
echo "UUID ".$user->UUID;
?>
