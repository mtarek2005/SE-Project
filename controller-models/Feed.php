<?php
require_once "./include.php";
abstract class Feed {
    public array $posts; // Post[]
    public array $reposts; // Repost[]
    abstract function gatherFeed(mysqli $db);
    function getPost(mysqli $db, $index){}
}
class UserFeed extends Feed {
    public User $user;
    function gatherFeed(mysqli $db){
        $result = $db->query("SELECT * FROM Post WHERE Poster = 0");
        if(!$result){echo "errooor: ".$db -> error."\n";}
        $posts = [];
        while ($row = $result->fetch_assoc()){
            $post = new Post;
            $post->post_id = $row["PostID"];
            $post->poster = $row["Poster"];
            $post->post_replied_to = $row["Post_replied_to"];
            $post->post_type = Post::PostTypeEnumFromString($row["Post_type"]);
            $post->content = $row["Content"];
            $post->date = $row["Post_date"];
            $post->image = $row["Image"];
            $posts[] = $post;
            var_dump($row);
        }
        $this->posts = $posts;
        $result = $db->query("SELECT * FROM Reposts WHERE User = 0");
        if(!$result){echo "errooor: ".$db -> error."\n";}
        $reposts = [];
        while ($row = $result->fetch_assoc()){
            $repost = new Repost;
            $repost->post = $row["Post"];
            $repost->date = $row["Date"];
            $repost->poster = $row["User"];
            $reposts[] = $repost;
            var_dump($row);
        }
        $this->posts = $reposts;
    } 
}
class FollowingFeed extends Feed {
    public User $viewer;
    function gatherFeed(mysqli $db){}
}
class ChronoFeed extends Feed {
    public User $viewer;
    function gatherFeed(mysqli $db){}
}
class SearchFeed extends Feed {
    public User $viewer;
    public string $query;
    function gatherFeed(mysqli $db){}
}
class BookmarkFeed extends Feed {
    public User $viewer;
    public array $bookmarks;
    function gatherFeed(mysqli $db){}
}
?>