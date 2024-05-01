<?php
class User{
    public $UUID; // : int
    public $username; // : string
    public $hashed_password; // : string
    public $display_name; // : string
    public $about; // : string
    public $profile_pic; // : string
    public $join_date; // : date
    public $mute_duration; // : duration
    public $ban_duration; // : durtion
    public $role; // : RoleEnum
    public $following; // : Follow[]
    public $muted; // : User[]
    public $blocked; // : User[]
    public $bookmarks; // : Bookmark[]
}
class Bookmark{
    public $post; // : Post
    public $date; // : DateTime
}
class Follow{
    public $followed; // : User
    public $date; // : DateTime
}
?>