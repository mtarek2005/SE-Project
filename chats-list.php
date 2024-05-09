<?php
require_once "./views/head.php";
if (is_null($user_manager->user)) {
    header("Location: index.php");
}
$feed = new ChatsList;
$feed->user = $user_manager->user;
$feed->gatherList($main_db);
?>

<main>
    <h1 class="feed-head">Chats: <?= count($feed->users) ?></h1>
    <?php

    foreach ($feed->users as $i => $user) {
        $latest = $feed->getLatestMsg($main_db, $user);
    ?>
        <div class="card tweet">
            <div class="card-body">
                <h5 class="card-title"><a href="chatpage.php?id=<?= $user->UUID ?>" class="text-decoration-none text-reset"><img src="<?= $user->profile_pic ?>" class="rounded-circle pfp" alt="..."> <?= $user->display_name ?></a></h5>
                <p class="card-text tweet-username"><a href="chatpage.php?id=<?= $user->UUID ?>" class="text-decoration-none text-reset"><?= $latest->content ?></a></p>
            </div>
        </div>
    <?php
    }
    if (count($feed->users) == 0) {
        echo "You have no messages.";
    }
    ?>
</main>
<?php
require_once "./views/foot.php";
?>