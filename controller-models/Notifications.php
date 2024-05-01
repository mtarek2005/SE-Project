<?php
require_once "./include.php";
class Notifications {
    public array $replies; 
    public array $reposts; 
    public array $likes;
    public array $follows;
    function gatherFeed(mysqli $db){}
}
?>