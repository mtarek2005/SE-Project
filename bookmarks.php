<?php
require_once "./views/head.php";
if (is_null($user_manager->user)){
    header("Location: index.php");

}
?>

<main>
    <h1 class="feed-head">Bookmarks</h1>
    <?php
    $feed = new BookmarkFeed;
    $feed->viewer=$user_manager->user;
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
    ?>
</main>
<?php
require_once "./views/foot.php";
?>