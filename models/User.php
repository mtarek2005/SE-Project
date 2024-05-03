<?php
require_once "./include.php";
enum RoleEnum{
    case regular;
    case moderator;
}
class Duration{
    public DateTime $start;
    public DateInterval $end;
}
class User{
    public int $UUID; // : int
    public string $username; // : string
    public string $hashed_password; // : string
    public string $display_name; // : string
    public string $about; // : string
    public string|null $profile_pic; // : string
    public DateTime $join_date; // : date
    public DateTime|null $mute_duration; // : duration
    public DateTime|null $ban_duration; // : durtion
    public RoleEnum $role; // : RoleEnum
    public array $following; // : Follow[]
    public array $muted; // : User[]
    public array $blocked; // : User[]
    public array $bookmarks; // : Bookmark[]
}
class Bookmark{
    public Post $post; // : Post
    public DateTime $date; // : DateTime
}
class Follow{
    public User $followed; // : User
    public DateTime $date; // : DateTime
}
?>