<?php
require_once "./views/head.php";
if (is_null($user_manager->user)) {
    header("Location: index.php");
}
?>

<main>
    <h1 class="feed-head">Notifications</h1>
    <?php
    $feed = new Notifications;
    $feed->user = $user_manager->user;
    $feed->gatherFeed($main_db);
    $posts = array_merge($feed->reposts, $feed->replies, $feed->likes, $feed->follows);
    usort($posts, "cmp_post_repost");


    foreach ($posts as $i => $notification) {
        $type = null;
        $user = null;
        $post = null;
        if (isset($notification->post_type)) {
            switch ($notification->post_type) {
                case PostTypeEnum::reply:
                    $type = "replied to your post";
                    $post = $notification->post_replied_to;
                    break;
                case PostTypeEnum::quote:
                    $type = "quote reposted your post";
                    $post = $notification;
                    break;
            }
            $user = $notification->poster;
        } else if (isset($notification->poster)) {
            $type = "reposted your post";
            $user = $notification->poster;
            $post = $notification->post;
        } else if (isset($notification->user)) {
            $type = "liked your post";
            $user = $notification->user;
            $post = $notification->post;
        } else if (isset($notification->follower)) {
            $type = "followed you";
            $user = $notification->follower;
        }
    ?>
        <div class="card tweet">
            <div class="card-body">
                <h5 class="card-title"><a href="userpage.php?username=<?= $user->username ?>" class="text-decoration-none text-reset"><img src="<?= $user->profile_pic ?>" class="rounded-circle pfp" alt="..."> <?= $user->display_name ?></a></h5>
                <p class="card-text tweet-username">
                    <a href="<?= (is_null($post)) ? '#' : ('post-page.php?id=' . $post->post_id) ?>" class="text-decoration-none text-reset">
                        <?= $type ?>
                    </a>
                </p>
            </div>
        </div>
    <?php
    }
    ?>
</main>
<?php
require_once "./views/foot.php";
?>