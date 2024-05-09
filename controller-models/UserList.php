<?php
require_once "./include.php";
abstract class UserList
{
    public array $users;
    abstract function gatherList(mysqli $db);
}
class FollowingList extends UserList
{
    public User $user;
    function gatherList(mysqli $db)
    {
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
class FollowerList extends UserList
{
    public User $user;
    public array $followers;
    function gatherList(mysqli $db)
    {
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
            $follower->date = DateTime::createFromFormat("Y-m-d G:i:s", $row["Date"]);
            $users[] = $user;
            $followers[] = $follower;
        }
        $this->users = $users;
        $this->followers = $followers;
    }
}
class LikesList extends UserList
{
    public Post $post;
    function gatherList(mysqli $db)
    {
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
enum BLTypeEnum
{
    case block;
    case mute;
}
// remember: blocks AND mutes
class BlockList extends UserList
{
    public User $user;
    public BLTypeEnum $type;
    function gatherList(mysqli $db)
    {
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
class SearchUserList extends UserList
{
    public string $query;
    function gatherList(mysqli $db)
    {
        $query = "%" . $this->query . "%";
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
class RepostsList extends UserList
{
    public Post $post;
    function gatherList(mysqli $db)
    {
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
class ChatsList extends UserList
{
    public User $user;
    function gatherList(mysqli $db)
    {
        $stmt = $db->prepare("SELECT * FROM PMs WHERE PMs.From_user = ? OR PMs.To_user = ? GROUP BY To_user,From_user ORDER BY PMs.Date DESC");
        $stmt->bind_param('ii', $this->user->UUID, $this->user->UUID);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            echo "errooor: " . $db->error . "\n";
        }
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $UUID = 0;
            if ($row["To_user"] == $this->user->UUID) {
                $UUID = $row["From_user"];
            } else {
                $UUID = $row["To_user"];
            }
            $stmt = $db->prepare("SELECT * FROM Users WHERE Users.UUID = ?");
            $stmt->bind_param('i', $UUID);
            $stmt->execute();
            $result2 = $stmt->get_result();
            if (!$result2) {
                echo "errooor: " . $db->error . "\n";
            }
            if ($row2 = $result2->fetch_assoc()) {
                $user = User::CreateFromArr($row2);
                $found=false;
                foreach($users as $curr_user){
                    if($curr_user->UUID==$user->UUID){
                        $found=true;
                        break;
                    }
                }
                if(!$found) $users[] = $user;
            }
        }
        $this->users = $users;
    }
    function getLatestMsg(mysqli $db, User $user)
    {
        $stmt = $db->prepare("SELECT * FROM PMs WHERE PMs.From_user = ? OR PMs.To_user = ? ORDER BY PMs.Date DESC");
        $stmt->bind_param('ii', $user->UUID, $user->UUID);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            echo "errooor: " . $db->error . "\n";
        }
        if ($row = $result->fetch_assoc()) {
            $from = new User;
            $to = new User;
            if ($row["To_user"] == $this->user->UUID) {
                $from = $user;
                $to = $this->user;
            } else {
                $from = $this->user;
                $to = $user;
            }
            $pm = PMs::CreateFromArr($row, $from, $to);
            return $pm;
        } else {
            return null;
        }
    }
}
