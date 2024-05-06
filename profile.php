<?php
require_once "./views/head.php";
if (is_null($user_manager->user)){
    header("Location: index.php");

}
?>

<main>
    <h1 class="feed-head"><img src="<?=$user_manager->user->profile_pic?>" class="rounded-circle pfp-big" alt="..."></h1>
    <h1 class="feed-head"><?=$user_manager->user->display_name ?></h1>
    <h3 class="feed-head">@<?=$user_manager->user->username ?></h3>
    <?php
    $feed = new UserFeed;
    $feed->user=$user_manager->user;
    $feed->gatherFeed($main_db);
    foreach ($feed->posts as $i => $post) {
        switch($post->post_type){
            case PostTypeEnum::main:
                require "./views/post-small.php";
                break;
            case PostTypeEnum::quote:
                require "./views/quote-small.php";
                break;
        }
    }
    ?>
</main>
<?php
require_once "./views/foot.php";
?>  