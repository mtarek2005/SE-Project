<?php
require_once "./views/head.php";
if (!isset($_GET["username"])){
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

?>

<main>
    <h1 class="feed-head"><img src="<?=$target_user->profile_pic?>" class="rounded-circle pfp-big" alt="..."></h1>
    <h1 class="feed-head"><?=$target_user->display_name ?></h1>
    <h3 class="feed-head">@<?=$target_user->username ?></h3>
    <?php
    $feed = new UserFeed;
    $feed->user=$target_user;
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