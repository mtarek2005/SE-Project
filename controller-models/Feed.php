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
        $stmt = $db->prepare("SELECT * FROM Post WHERE Poster = ?");
        $stmt->bind_param('i', $this->user->UUID);
        $stmt->execute();
        $result = $stmt->get_result(); // todo
        if(!$result){echo "errooor: ".$db -> error."\n";}
        $posts = [];
        while ($row = $result->fetch_assoc()){
            print_r($row);
            $post_replied_to=null;
            if(!is_null($row["Post_replied_to"])){
                $post_replied_to=new Post;
            }
            $post = Post::CreateFromArr($row,$this->user,$post_replied_to);
            print_r($post);
            $posts[] = $post;
        }
        $this->posts = $posts;
        $stmt = $db->prepare("SELECT * FROM Reposts WHERE User = ?");
        $stmt->bind_param('i', $this->user->UUID);
        $stmt->execute();
        $result = $stmt->get_result();
        if(!$result){echo "errooor: ".$db -> error."\n";}
        $reposts = [];
        while ($row = $result->fetch_assoc()){
            $repost = Repost::CreateFromArr($row, $this->user, new Post); //todo 
            
            $reposts[] = $repost;
            print_r($row);
            print_r($repost);
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