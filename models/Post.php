<?php
require_once "./include.php";
enum PostTypeEnum{
    case main;
    case reply;
    case quote;
}
class Post {
    public int $post_id; // : int
    public User $poster ; // : User
    public Post|null $post_replied_to ; // : Post
    public PostTypeEnum $post_type ; // : PostTypeEnum
    public string $content ; // : string
    public DateTime $date ; // : DateTime
    public string|null $image  ; // : string
    public array $liked_by  ; // : Like[]
    public array $reposts  ; // : Repost[]
    static function PostTypeEnumFromString(string $str){
        switch($str) {
            case 'main':
                return PostTypeEnum::main;
            case 'reply':
                return PostTypeEnum::reply;
            case 'quote':
                return PostTypeEnum::quote;
            default:
                return null;
        }
    }
    static function PostTypeEnumToString(PostTypeEnum $enum){
        switch ($enum) {
            case PostTypeEnum::main:
                return 'main';
            case PostTypeEnum::reply:
                return 'reply';
            case PostTypeEnum::quote:
                return 'quote';
            default:
                return null;
        }
    }
    static function CreateFromArr(array $row,User $poster,Post|null $post_replied_to){
        $post=new Post;
        $post->post_id = $row["PostID"];
        $post->poster = $poster;
        $post->post_replied_to = $post_replied_to;
        $post->post_type = Post::PostTypeEnumFromString($row["Post_type"]);
        $post->content = $row["Content"];
        $post->date = DateTime::createFromFormat("Y-m-d G:i:s",$row["Post_date"]);
        $post->image = $row["Image"];
        return $post;
    }
}
class Repost{
    public User $poster; // : User
    public DateTime $date; // : DateTime
    public Post $post; // : Post
}
class Like{
    public User $user; // : User
    public DateTime $date; // : DateTime
}
?>