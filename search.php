<?php
require_once "./views/head.php";
if (!isset($_GET["query"])){
    header("Location: index.php");

}
$query = $_GET["query"];
?>

<main>
    <h1 class="feed-head">Search: <?= $query?></h1>
    <h4 class="feed-head">Posts <a href="search-user.php?query=<?=$query?>">Users</a></h4>
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
        echo "<h6 class=\"feed-head\">This search yielded no results.</h6>";
    }
    ?>
</main>
<?php
require_once "./views/foot.php";
?>