<?php
require_once "./include.php";
enum RoleEnum{
    case regular;
    case moderator;
}
class User{
    public int $UUID; // : int
    public string $username; // : string
    public string $hashed_password; // : string
    public string $display_name; // : string
    public string $about; // : string
    public string $profile_pic; // : string
    public $join_date; // : date
    public $mute_duration; // : duration
    public $ban_duration; // : durtion
    public RoleEnum $role; // : RoleEnum
    public array $following; // : Follow[]
    public array $muted; // : User[]
    public array $blocked; // : User[]
    public array $bookmarks; // : Bookmark[]
}
class Bookmark{
    public Post $post; // : Post
    public $date; // : DateTime
}
class Follow{
    public User $followed; // : User
    public $date; // : DateTime
}
?>