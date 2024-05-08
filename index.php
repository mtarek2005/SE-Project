<?php
require_once "./views/head.php";
?>

<main>
    <h1 class="feed-head">Home</h1>
    <?php
    $new_post_type = "main";
    require "./views/new-post.php";
    $feed = (is_null($user_manager->user)) ? new ChronoFeed : new FollowingFeed; 
    $feed->viewer=$user_manager->user;
    $feed->gatherFeed($main_db);
    $posts = array_merge($feed->posts, $feed->reposts);
    if(!is_null($user_manager->user)){
        $ufeed = new UserFeed; 
        $ufeed->user=$user_manager->user;
        $ufeed->gatherFeed($main_db);
        $uposts = array_merge($ufeed->posts, $ufeed->reposts);
        $posts = array_merge($posts, $uposts);
    }
    usort($posts, "cmp_post_repost");

    foreach ($posts as $i => $post) {
        if (isset($post->post_type)) {
            switch($post->post_type){
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