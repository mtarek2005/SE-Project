<?php
require_once "./include.php";
class PMs{
    public int $message_id; // : int
    public User $from ; // : User
    public User $to ; // : User
    public string $content ; // : string
    public DateTime $date ; // : DateTime
    public string|null $reaction ; // : string
    static function CreateFromArr(array $row,User $from,User $to){
        $pm = new PMs;
        $pm->message_id = $row["MessageID"];
        $pm->from = $from;
        $pm->to = $to; 
        $pm->content = $row["Content"];
        $pm->date = DateTime::createFromFormat("Y-m-d G:i:s", $row["Date"]);
        $pm->reaction = $row["Reaction"];
        return $pm;
    }
}
?>