<!-- Lorem ipsum -->
<?php
require_once "./include.php";
echo "hellooo\n"; 

$user = new User;
$user->UUID = 0;
$feed = new UserFeed;
$feed->user = $user;
$feed->gatherFeed($main_db);
print_r($feed);
echo "UUID ".$user->UUID;
?>
