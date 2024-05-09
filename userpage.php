<?php
require_once "./views/head.php";
if (!isset($_GET["username"])) {
    header("Location: index.php");
}
$username = $_GET["username"];
$target_user = null;
$stmt = $main_db->prepare("SELECT * FROM Users WHERE Username = ?");
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
if (!$result) {
    echo "errooor: " . $main_db->error . "\n";
}
if ($row = $result->fetch_assoc()) {
    $target_user = User::CreateFromArr($row);
} else {
    echo "Not found";
    header("Location: index.php");
}
$follow = $user_manager->follows_user($main_db, $target_user);
$same_user = false;
if ($target_user->UUID == $user_manager->user->UUID) {
    $same_user = true;
}

?>

<main>
    <h1 class="feed-head"><img src="<?= $target_user->profile_pic ?>" class="rounded-circle pfp-big" alt="..."></h1>
    <h1 class="feed-head"><?= $target_user->display_name ?></h1>
    <h3 class="feed-head">@<?= $target_user->username ?></h3>
    <p class="feed-head"><?= $target_user->about ?></p>
    <h4 class="feed-head"><a href="follower-list.php?id=<?= $target_user->UUID ?>">Followers</a> <a href="following-list.php?id=<?= $target_user->UUID ?>">Following</a></h4>
    <?php if ((!is_null($user_manager->user)) && $user_manager->user->role == RoleEnum::moderator) : ?>
        <h4 class="feed-head"><button class="btn btn-link text-muted text-decoration-none" onclick="global_mute(<?= $target_user->UUID ?>)">Global Mute</button> <button class="btn btn-link text-muted text-decoration-none" onclick="ban(<?= $target_user->UUID ?>)">Ban</button></h4>
    <?php endif; ?>
    <?php if (!$same_user) : ?>
        <h4 class="feed-head"><button class="btn btn-link text-muted text-decoration-none" onclick="follow(<?= '' . $target_user->UUID . ',' . (($follow) ? 'true' : 'false') ?>)"><i class="nf <?= ($follow) ? "nf-md-account_remove unfollow-icon" : "nf-md-account_plus follow-icon" ?>"></i></button></h4>
        <h4 class="feed-head"><a href="chatpage.php?id=<?= $target_user->UUID ?>">Message</a></h4>
    <?php else : ?>
        <h4 class="feed-head"><a href="edit-profile.php">Edit Profile</a></h4>
    <?php endif; ?>
    <?php
    $feed = new UserFeed;
    $feed->user = $target_user;
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