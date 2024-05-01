<?php
require_once "./include.php";
abstract class UserList {
    public array $users;
    abstract function gatherList(mysqli $db);
    function getUser(mysqli $db, int $index){}
}
class FollowingList extends UserList {
    public User $user;
    function gatherList(mysqli $db){}
}
class FollowerList extends UserList {
    public User $user;
    function gatherList(mysqli $db){}
}
class LikesList extends UserList {
    public Post $post;
    function gatherList(mysqli $db){}
}
enum BLTypeEnum {
    case block;
    case mute; 
    function gatherList(mysqli $db){}
}
class BlockList extends UserList {
    public BLTypeEnum $type;
    function gatherList(mysqli $db){}
}
?>