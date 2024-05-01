<?php
require_once "./include.php";
class PMs{
    public int $message_id; // : int
    public User $from ; // : User
    public User $to ; // : User
    public string $content ; // : string
    public $date ; // : DateTime
    public string $reaction ; // : string
}
?>