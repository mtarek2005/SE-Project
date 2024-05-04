<?php
require_once "./include.php";
class Notifications {
    public User $user;
    public array $replies; 
    public array $reposts; 
    public array $likes;
    public array $follows;
    function gatherFeed(mysqli $db){
        // likes
        $stmt = $db->prepare("SELECT * FROM Users JOIN Likes ON Likes.User = Users.UUID JOIN Post ON Likes.Post = Post.PostID WHERE Post.Poster = ? ORDER BY Likes.Date DESC;");
        $stmt->bind_param('i', $this->user->UUID);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            echo "errooor: " . $db->error . "\n";
        }
        $likes = [];
        while ($row = $result->fetch_assoc()) {
            print_r($row);
            $user = User::CreateFromArr($row);
            $post = Post::CreateFromArr($row, $this->user, null);
            $like = new Like;
            $like->post = $post;
            $like->user = $user;
            $like->date = DateTime::createFromFormat("Y-m-d G:i:s", $row["Date"]);
            print_r($like);
            $likes[] = $like;
        }
        $this->likes = $likes;
        // reposts
        $stmt = $db->prepare("SELECT * FROM Users JOIN Reposts ON Reposts.User = Users.UUID JOIN Post ON Reposts.Post = Post.PostID WHERE Post.Poster = ? ORDER BY Reposts.Date DESC");
        $stmt->bind_param('i', $this->user->UUID);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            echo "errooor: " . $db->error . "\n";
        }
        $reposts = [];
        while ($row = $result->fetch_assoc()) {
            print_r($row);
            $user = User::CreateFromArr($row);
            $post = Post::CreateFromArr($row, $this->user, null);
            $repost = Repost::CreateFromArr($row, $user, $post);
            print_r($repost);
            $reposts[] = $repost;
        }
        $this->reposts = $reposts;
        // follows
        $stmt = $db->prepare("SELECT * FROM Users JOIN Follows ON Follows.Follower = Users.UUID WHERE Follows.Followed = ? ORDER BY Follows.Date DESC");
        $stmt->bind_param('i', $this->user->UUID);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            echo "errooor: " . $db->error . "\n";
        }
        $follows = [];
        while ($row = $result->fetch_assoc()) {
            print_r($row);
            $user = User::CreateFromArr($row);
            $follow = new Follow;
            $follow->followed = $this->user;
            $follow->follower = $user;
            $follow->date = DateTime::createFromFormat("Y-m-d G:i:s", $row["Date"]);
            print_r($follow);
            $follows[] = $follow;
        }
        $this->follows = $follows;
        // replies
        $stmt = $db->prepare("SELECT Reply.* FROM Post as Reply JOIN Post as Original ON Reply.Post_replied_to = Original.PostID WHERE Reply.Post_type != 'main' AND Original.Poster = ? ORDER BY Reply.Post_date DESC");
        $stmt->bind_param('i', $this->user->UUID);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            echo "errooor: " . $db->error . "\n";
        }
        $posts = [];
        while ($row = $result->fetch_assoc()) {
            print_r($row);
            $post_replied_to = new Post;
            $stmt = $db->prepare("SELECT * FROM Users WHERE UUID = ?");
            $stmt->bind_param('i', $row["Poster"]);
            $stmt->execute();
            $result3 = $stmt->get_result();
            if (!$result3) {
                echo "errooor: " . $db->error . "\n";
            }
            $poster = null;
            if ($row3 = $result3->fetch_assoc()) {
                $poster = User::CreateFromArr($row3); // todo
            }
            $post = Post::CreateFromArr($row, $poster, $post_replied_to);
            print_r($post);
            $posts[] = $post;
        }
        $this->replies = $posts;
    }
}
?>