<?php
require_once "./views/head.php";
?>

<main>
    <h1 class="feed-head">Home</h1>
    <?php
    $feed=new ChronoFeed;
    $feed->viewer=null;
    $feed->gatherFeed($main_db);
    foreach ($feed->posts as $i => $post) {
        require "./views/post-small.php";
    }
    ?>
</main>
<?php
require_once "./views/foot.php";
?>