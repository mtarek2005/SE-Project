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
        $stmt = $db->prepare("SELECT * FROM Users JOIN Follows ON Follows.Followed = Users.UUID WHERE Follows.Follower = ?");
        $stmt->bind_param('i', $this->user->UUID);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            echo "errooor: " . $db->error . "\n";
        }
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $user = User::CreateFromArr($row);
            $users[] = $user;
        }
        $this->users = $users;
        
    }
}
class FollowerList extends UserList {
    public User $user;
    public array $followers;
    function gatherList(mysqli $db){
        $stmt = $db->prepare("SELECT * FROM Users JOIN Follows ON Follows.Follower = Users.UUID WHERE Follows.Followed = ? ");
        $stmt->bind_param('i', $this->user->UUID);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            echo "errooor: " . $db->error . "\n";
        }
        $users = [];
        $followers = [];
        while ($row = $result->fetch_assoc()) {
            $user = User::CreateFromArr($row);
            $follower = new Follow;
            $follower->followed = $this->user;
            $follower->follower = $user;
            $follower->date = DateTime::createFromFormat("Y-m-d G:i:s",$row["Date"]);
            $users[] = $user;
            $followers[] = $follower;
        }
        $this->users = $users;
        $this->followers = $followers;
        
    }
}
class LikesList extends UserList {
    public Post $post;
    function gatherList(mysqli $db){
        $stmt = $db->prepare("SELECT * FROM Users JOIN Likes ON Likes.User = Users.UUID WHERE Likes.Post = ?");
        $stmt->bind_param('i', $this->post->post_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            echo "errooor: " . $db->error . "\n";
        }
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $user = User::CreateFromArr($row);
            $users[] = $user;
        }
        $this->users = $users;
        
    }
}
enum BLTypeEnum {
    case block;
    case mute; 
}
// remember: blocks AND mutes
class BlockList extends UserList {
    public User $user;
    public BLTypeEnum $type;
    function gatherList(mysqli $db){
        $stmt = null;
        if ($this->type == BLTypeEnum::block) {
            $stmt = $db->prepare("SELECT * FROM Users JOIN Blocks ON Blocks.Blocked = Users.UUID WHERE Blocks.Blocker = ?");
        } else if ($this->type == BLTypeEnum::mute) {
            $stmt = $db->prepare("SELECT * FROM Users JOIN Mutes ON Mutes.Muted = Users.UUID WHERE Mutes.Muter = ?");
        }
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
class SearchUserList extends UserList {
    public string $query;
    function gatherList(mysqli $db){
        $query = "%".$this->query."%";
        $stmt = $db->prepare("SELECT * FROM Users WHERE Users.Username LIKE ? OR Users.Display_name LIKE ?");
        $stmt->bind_param('ss', $query, $query);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            echo "errooor: " . $db->error . "\n";
        }
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $user = User::CreateFromArr($row);
            $users[] = $user;
        }
        $this->users = $users;
        
    }

} 
class RepostsList extends UserList {
    public Post $post;
    function gatherList(mysqli $db){
        $stmt = $db->prepare("SELECT * FROM Users JOIN Reposts ON Reposts.User = Users.UUID WHERE Reposts.Post = ?");
        $stmt->bind_param('i', $this->post->post_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            echo "errooor: " . $db->error . "\n";
        }
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $user = User::CreateFromArr($row);
            $users[] = $user;
        }
        $this->users = $users;
        
    }
}

?>