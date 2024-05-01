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
    function gatherFeed(mysqli $db){}
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