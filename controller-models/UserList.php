<?php
require_once "./include.php";
abstract class UserList {
    public array $users;
    abstract function gatherList(mysqli $db);
    function getUser(mysqli $db, index){}
}
class FollowingList extends UserList {
    public User $user;
}
class FollowerList extends UserList {
    public User $user;
}
class LikesList extends UserList {
    public Post $post;
}
enum BLTypeEnum {
    case block;
    case mute; 
}
class BlockList extends UserList {
    public BLTypeEnum $type;
}
?>