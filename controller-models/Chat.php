<?php
require_once "./include.php";
class Chat {
    public array $messages;
    public User $from;
    public User $to;
    function gatherFeed(mysqli $db){
        $stmt = $db->prepare("SELECT * FROM PMs WHERE (PMs.From_user = ? AND PMs.To_user = ?) OR (PMs.To_user = ? AND PMs.From_user = ?) ORDER BY Date ASC");
        $stmt->bind_param('iiii', $this->from->UUID, $this->to->UUID, $this->from->UUID, $this->to->UUID);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            echo "errooor: " . $db->error . "\n";
        }
        $messages = [];
        while ($row = $result->fetch_assoc()) {
            if($row['From_user']==$this->from->UUID){
                $message = PMs::CreateFromArr($row, $this->from, $this->to);
            } else {
                $message = PMs::CreateFromArr($row, $this->to, $this->from);
            }
            $messages[] = $message;
        }
        $this->messages = $messages;
        
    }
    function send(mysqli $db, string $content){
        $stmt = $db->prepare("INSERT INTO PMs (MessageID, From_user, To_user, Content) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('iiis', random_int(0, 2147483647), $this->from->UUID, $this->to->UUID, $content);
        $stmt->execute();
    }
    function react(mysqli $db, PMs $pm, string $reaction){
        $stmt = $db->prepare("UPDATE PMs SET Reaction = ? WHERE PMs.MessageID = ?");
        $stmt->bind_param('si', $reaction, $pm->message_id);
        $stmt->execute();    
    }
}
?>