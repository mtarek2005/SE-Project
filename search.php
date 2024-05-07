<?php
require_once "./views/head.php";
if (!isset($_GET["query"])){
    header("Location: index.php");

}
$query = $_GET["query"];
?>

<main>
    <h1 class="feed-head">Search: <?= $query?></h1>
    <?php
    $feed = new SearchFeed;
    $feed->viewer=$user_manager->user;
    $feed->query = $query;
    $feed->gatherFeed($main_db);
    foreach ($feed->posts as $i => $post) {
        switch($post->post_type){
            case PostTypeEnum::main:
                require "./views/post-small.php";
                break;
            case PostTypeEnum::quote:
                require "./views/quote-small.php";
                break;
            case PostTypeEnum::reply:
                require "./views/reply-small.php";
                break;
        }
    }
    if (count($feed->posts) == 0){
        echo "This search yielded no results.";
    }
    ?>
</main>
<?php
require_once "./views/foot.php";
?>