<?php
class Post {
    public $post_id; // : int
    public $poster ; // : User
    public $post_replied_to ; // : Post
    public $post_type ; // : PostTypeEnum
    public $content ; // : string
    public $date ; // : DateTime
    public $image  ; // : string
    public $liked_by  ; // : Like[]
    public $reposts  ; // : Repost[]
}
class Repost{
    public $poster; // : User
    public $date; // : DateTime
    public $post; // : Post
}
class Like{
    public $user; // : User
    public $date; // : DateTime
}
?>