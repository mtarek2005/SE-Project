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
    public Post $post_replied_to ; // : Post
    public PostTypeEnum $post_type ; // : PostTypeEnum
    public string $content ; // : string
    public DateTime $date ; // : DateTime
    public string $image  ; // : string
    public array $liked_by  ; // : Like[]
    public array $reposts  ; // : Repost[]
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