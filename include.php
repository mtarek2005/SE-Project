<?php
session_start();
function dd($dd){}
require_once "./models/User.php";
require_once "./models/Post.php";
require_once "./models/PMs.php";
require_once "./controllers/CurrentUserManager.php";
require_once "./controller-models/Chat.php";
require_once "./controller-models/Feed.php";
require_once "./controller-models/Notifications.php";
require_once "./controller-models/UserList.php";
require_once "./views/connect_db.php";
function cmp_post_repost(Post|Repost|Like|Follow $a, Post|Repost|Like|Follow $b) {
    return -($a->date <=> $b->date);
}
$main_user=null;
if(isset($_SESSION["user"])){
    $main_user=unserialize($_SESSION["user"]);
}
$user_manager=new CurrentUserManager;
$user_manager->user=$main_user;
?>