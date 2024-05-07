<?php
require_once "./views/head.php";
if (is_null($user_manager->user)) {
    header("Location: index.php");
}
?>

<main>
    <h1 class="feed-head">Explore</h1>
    <?php
    $new_post_type = "main";
    require "./views/new-post.php";
    $feed = new ChronoFeed;
    $feed->viewer = $user_manager->user;
    $feed->gatherFeed($main_db);
    $posts = array_merge($feed->posts, $feed->reposts);
    usort($posts, "cmp_post_repost");


    foreach ($posts as $i => $post) {
        if (isset($post->post_type)) {
            switch ($post->post_type) {
                case PostTypeEnum::main:
                    require "./views/post-small.php";
                    break;
                case PostTypeEnum::quote:
                    require "./views/quote-small.php";
                    break;
            }
        } else {
            require "./views/repost-small.php";
        }
    }
    ?>
</main>
<?php
require_once "./views/foot.php";
?>