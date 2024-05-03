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
    public string|null $profile_pic; // : string
    public DateTime $join_date; // : date
    public DateTime|null $mute_duration; // : duration
    public DateTime|null $ban_duration; // : duration
    public RoleEnum $role; // : RoleEnum
    public array $following; // : Follow[]
    public array $muted; // : User[]
    public array $blocked; // : User[]
    public array $bookmarks; // : Bookmark[]
    static function RoleEnumFromString(string $str){
        switch($str) {
            case 'regular':
                return RoleEnum::regular;
            case 'moderator':
                return RoleEnum::moderator;
            default:
                return null;
        }
    }
    static function RoleEnumToString(RoleEnum $enum){
        switch ($enum) {
            case RoleEnum::regular:
                return 'regular';
            case RoleEnum::moderator:
                return 'moderator';
            default:
                return null;
        }
    }
    static function CreateFromArr(array $row){
        $user = new User;
        $user->UUID = $row["UUID"];
        $user->username = $row["Username"];
        $user->hashed_password = $row["Hashed_password"];
        $user->display_name = $row["Display_name"];
        $user->about = $row["About"];
        $user->profile_pic = $row["Profile_pic"];
        $user->join_date = DateTime::createFromFormat("Y-m-d", $row["Join_date"]);
        $user->mute_duration = is_null($row["Mute_to"]) ? null : DateTime::createFromFormat("Y-m-d G:i:s", $row["Mute_to"]);
        $user->ban_duration = is_null($row["Ban_to"]) ? null : DateTime::createFromFormat("Y-m-d G:i:s", $row["Ban_to"]);
        $user->role = User::RoleEnumFromString($row["Role"]);
        return $user;
    }
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