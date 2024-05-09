<?php
require_once "./views/head.php";
if (!is_numeric($_GET["id"])||is_null($user_manager->user)) {
    header("Location: index.php");
}
$id = intval($_GET["id"]);
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $react = $_POST['react'];
    $msgid = $_POST['msgid'];
    if (!empty($react)&&is_numeric($msgid)) {
        $feed = new Chat;
        $feed->from = $user_manager->user;
        $feed->to = new User;
        $feed->to->UUID = $id;
        $pm=new PMs;
        $pm->message_id=intval($msgid);
        $feed->react($main_db,$pm,$react);
    }

    $send = $_POST['send'];
    if (!empty($send)) {
        $feed = new Chat;
        $feed->from = $user_manager->user;
        $feed->to = new User;
        $feed->to->UUID = $id;
        $feed->send($main_db,$send);
    }
}
$feed = new Chat;
$feed->from = $user_manager->user;
$feed->to = new User;
$feed->to->UUID = $id;
$feed->gatherFeed($main_db);
?>

<main>
    <h1 class="feed-head">Chat: </h1>
    <?php

    foreach ($feed->messages as $i => $message) {
    ?>
        <div class="card tweet">
            <div class="card-body <?= ($message->from->UUID == $user_manager->user->UUID) ? 'text-end' : '' ?>">
                <h5 class="card-title"><?= $message->content ?></h5>
                <p class="card-text tweet-username"><?= $message->reaction ?></p>
                <?php if (is_null($message->reaction)&&($message->from->UUID != $user_manager->user->UUID)) : ?><p class="card-text tweet-username">
                    <form method="post" style="display: inline;">
                        <input type="submit" name="react" value="😂">
                        <input type="hidden" name="msgid" value="<?= $message->message_id ?>">
                    </form>
                    <form method="post" style="display: inline;">
                        <input type="submit" name="react" value="👍">
                        <input type="hidden" name="msgid" value="<?= $message->message_id ?>">
                    </form>
                    <form method="post" style="display: inline;">
                        <input type="submit" name="react" value="❤️">
                        <input type="hidden" name="msgid" value="<?= $message->message_id ?>">
                    </form>
                    <form method="post" style="display: inline;">
                        <input type="submit" name="react" value="🤯">
                        <input type="hidden" name="msgid" value="<?= $message->message_id ?>">
                    </form>
                    <form method="post" style="display: inline;">
                        <input type="submit" name="react" value="😢">
                        <input type="hidden" name="msgid" value="<?= $message->message_id ?>">
                    </form>
                    </p><?php endif; ?>
            </div>
        </div>
    <?php
    }
    if (count($feed->messages) == 0) {
        echo "<h6 class='feed-head'>You have no messages, start texting now!</h6>";
    }
    ?>
    <div class="card tweet">
            <div class="card-body">
                <h5 class="card-title">
                    <form method="post" style="display: inline;">
                        <input type="text" name="send" placeholder="write...">
                        <button type="submit" class="btn btn-secondary"><i class="nf nf-cod-send post-icon"></i></button>
                    </form>
                </h5>
            </div>
        </div>
</main>
<?php
require_once "./views/foot.php";
?>