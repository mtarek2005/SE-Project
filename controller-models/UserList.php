<?php
require_once "./include.php";
abstract class UserList {
    public array $users;
    abstract function gatherList(mysqli $db);
    function getUser(mysqli $db, int $index){}
}
class FollowingList extends UserList {
    public User $user;
    function gatherList(mysqli $db){
        $stmt = $db->prepare("SELECT * FROM Users JOIN Follows ON Follows.Followed = Users.UUID WHERE Follows.Followed = ?");
        $stmt->bind_param('i', $this->user->UUID);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            echo "errooor: " . $db->error . "\n";
        }
        $users = [];
        while ($row = $result->fetch_assoc()) {
            print_r($row);
            $user = User::CreateFromArr($row);
            print_r($user);
            $users[] = $user;
        }
        $this->users = $users;
        
    }
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
}
// remember: blocks AND mutes
class BlockList extends UserList {
    public BLTypeEnum $type;
    function gatherList(mysqli $db){}
}
?>