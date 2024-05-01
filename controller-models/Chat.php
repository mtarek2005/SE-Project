<?php
require_once "./include.php";
class Chat {
    public array $messages;
    public User $from;
    public User $to;
    function gatherFeed(mysqli $db){}
    function send(mysqli $db, string $content){}
    function react(mysqli $db, PMs $pm, string $reaction){}
}
?>