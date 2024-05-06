<?php
require_once "./include.php";
class CurrentUserManager{
    public User|null $user; // : User
    function login(mysqli $db,string $username,string $pass){
        $stmt = $db->prepare("SELECT * FROM Users WHERE Username = ? AND Hashed_password = ?");
        $stmt->bind_param('ss', $username, md5($pass));
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            echo "errooor: " . $db->error . "\n";
            return false;
        }
        if ($row = $result->fetch_assoc()) {
            $this->user = User::CreateFromArr($row);
            $_SESSION["user"] = serialize($this->user);
            return true;
        } else {
            return false;
        }
    } // : void SELECT
    function register(mysqli $db,string $username,string $pass,string $name){
        $stmt = $db->prepare("SELECT * FROM Users WHERE Username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            echo "errooor: " . $db->error . "\n";
            return false;
        }
        if ($row = $result->fetch_assoc()) {
            return false;
        } else {
            $stmt = $db->prepare("INSERT INTO Users (UUID, Username, Hashed_password, Display_name) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('isss', random_int(0, 2147483647), $username, md5($pass), $name);
            $stmt->execute();
            return $this->login($db, $username, $pass);
        }
    } // : void SELECT
    function check_username(mysqli $db,string $username){
        $stmt = $db->prepare("SELECT * FROM Users WHERE Username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            echo "errooor: " . $db->error . "\n";
            return false;
        }
        if ($row = $result->fetch_assoc()) {
            return false;
        } else {
            return true;
        }
    }
    function follow(mysqli $db, User $user){
        $stmt = $db->prepare("INSERT INTO Follows (Followed, Follower) VALUES (?, ?)");
        $stmt->bind_param('ii', $user->UUID, $this->user->UUID);
        $stmt->execute();
    } // : void NO SELECT
    function mute(mysqli $db,User $user){
        $stmt = $db->prepare("INSERT INTO Mutes (Muted, Muter) VALUES (?, ?)");
        $stmt->bind_param('ii', $user->UUID, $this->user->UUID);
        $stmt->execute();
    } // : void NO SELECT
    function block(mysqli $db,User $user){
        $stmt = $db->prepare("INSERT INTO Blocks (Blocked, Blocker) VALUES (?, ?)");
        $stmt->bind_param('ii', $user->UUID, $this->user->UUID);
        $stmt->execute();
    } // : void NO SELECT
    function bookmark(mysqli $db,Post $post){
        $stmt = $db->prepare("INSERT INTO Bookmarks (User, Post) VALUES (?, ?)");
        $stmt->bind_param('ii', $this->user->UUID, $post->post_id);
        $stmt->execute();
    } // : void NO SELECT
    function update_name(mysqli $db,string $name){
        $stmt = $db->prepare("UPDATE Users SET Display_name = ? WHERE UUID = ?");
        $stmt->bind_param('si', $name, $this->user->UUID);
        $stmt->execute();
    } // : void NO SELECT
    function update_about(mysqli $db,string $about){
        $stmt = $db->prepare("UPDATE Users SET About = ? WHERE UUID = ?");
        $stmt->bind_param('si', $about, $this->user->UUID);
        $stmt->execute();
    } // : void NO SELECT
    function update_username(mysqli $db,string $username){
        $stmt = $db->prepare("SELECT * FROM Users WHERE Username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            echo "errooor: " . $db->error . "\n";
            return false;
        }
        if ($row = $result->fetch_assoc()) {
            return false;
        } else {
            $stmt = $db->prepare("UPDATE Users SET Username = ? WHERE UUID = ?");
            $stmt->bind_param('si', $username, $this->user->UUID);
            return $stmt->execute();
        }
    } // : void SELECT
    function update_pic(mysqli $db,string $pic){
        $stmt = $db->prepare("UPDATE Users SET Profile_pic = ? WHERE UUID = ?");
        $stmt->bind_param('si', $pic, $this->user->UUID);
        $stmt->execute();
    } // : void NO SELECT
    function like(mysqli $db,Post $post){
        $stmt = $db->prepare("INSERT INTO Likes (User, Post) VALUES (?, ?)");
        $stmt->bind_param('ii', $this->user->UUID, $post->post_id);
        $stmt->execute();
    } // : void NO SELECT
    function repost(mysqli $db,Post $post){
        $stmt = $db->prepare("INSERT INTO Reposts (User, Post) VALUES (?, ?)");
        $stmt->bind_param('ii', $this->user->UUID, $post->post_id);
        $stmt->execute();
    } // : void NO SELECT
    function post(mysqli $db,Post $post){
        $stmt = $db->prepare("INSERT INTO Post (PostID, Poster, Post_type, Content, Image, Post_date) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('iissss', $post->post_id, $this->user->UUID, Post::PostTypeEnumToString(PostTypeEnum::main), $post->content, $post->image, date("Y-m-d G:i:s", $post->date->getTimestamp()));
        $stmt->execute();
    } // : void NO SELECT
    function reply(mysqli $db,Post $post, Post $reply){
        $stmt = $db->prepare("INSERT INTO Post (PostID, Poster, Post_type, Content, Image, Post_date, Post_replied_to) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('iissssi', $reply->post_id, $this->user->UUID, Post::PostTypeEnumToString($reply->post_type), $reply->content, $reply->image, date("Y-m-d G:i:s", $reply->date->getTimestamp()), $post->post_id);
        $stmt->execute();
    } // : void NO SELECT
    function unfollow(mysqli $db,User $user){
        $stmt = $db->prepare("DELETE FROM Follows WHERE Followed = ? AND Follower = ?");
        $stmt->bind_param('ii', $user->UUID, $this->user->UUID);
        $stmt->execute();
    } // : void NO SELECT
    function unmute(mysqli $db,User $user){
        $stmt = $db->prepare("DELETE FROM Mutes WHERE Muted = ? AND Muter = ?");
        $stmt->bind_param('ii', $user->UUID, $this->user->UUID);
        $stmt->execute();
    } // : void NO SELECT
    function unblock(mysqli $db,User $user){
        $stmt = $db->prepare("DELETE FROM Blocks WHERE Blocked = ? AND Blocker = ?");
        $stmt->bind_param('ii', $user->UUID, $this->user->UUID);
        $stmt->execute();
    } // : void NO SELECT
    function delete_post(mysqli $db,Post $post){
        $stmt = $db->prepare("DELETE FROM Posts WHERE PostID = ? AND Poster = ?");
        $stmt->bind_param('ii', $post->post_id, $this->user->UUID);
        $stmt->execute();
    } // : void NO SELECT
    function edit_post(mysqli $db,Post $post){
        $stmt = $db->prepare("UPDATE Posts SET Content = ?, Image = ?, Date = current_timestamp() WHERE PostID = ? AND Poster = ?");
        $stmt->bind_param('sii', $post->content, $post->image, $post->post_id, $this->user->UUID);
        $stmt->execute();
    } // : void NO SELECT
    function logout(){
        unset($_SESSION["user"]);
    } // : void NO DB
}
class CurrentModManager extends CurrentUserManager{
    // no select
    function global_mute(mysqli $db,$user){
        $stmt = $db->prepare("UPDATE Users SET Mute_to = ? WHERE UUID = ?");
        $stmt->bind_param('ii', date("Y-m-d G:i:s", time()+3*24*3600), $user->UUID);
        $stmt->execute();
    } // : void 
    function ban(mysqli $db,$user){
        $stmt = $db->prepare("UPDATE Users SET Ban_to = ? WHERE UUID = ?");
        $stmt->bind_param('ii', date("Y-m-d G:i:s", time()+7*24*3600), $user->UUID);
        $stmt->execute();
    } // : void
    function delete_post(mysqli $db,$post){
        $stmt = $db->prepare("DELETE FROM Posts WHERE PostID = ?");
        $stmt->bind_param('i', $post->post_id);
        $stmt->execute();
    } // : void

}
?>