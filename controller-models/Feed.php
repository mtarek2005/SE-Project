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
        $result = $db->query("SELECT * FROM Post WHERE Poster = 0"); // todo
        if(!$result){echo "errooor: ".$db -> error."\n";}
        $posts = [];
        while ($row = $result->fetch_assoc()){
            print_r($row);
            $post = Post::CreateFromArr($row,$this->user,null);
            print_r($post);
            $posts[] = $post;
        }
        $this->posts = $posts;
        $result = $db->query("SELECT * FROM Reposts WHERE User = 0"); // todo
        if(!$result){echo "errooor: ".$db -> error."\n";}
        $reposts = [];
        while ($row = $result->fetch_assoc()){
            $repost = Repost::CreateFromArr($row, $this->user, new Post); //todo 
            
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