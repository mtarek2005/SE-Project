<?php
require_once "./views/head.php";
if (!isset($_GET["id"])){
    header("Location: index.php");
}
$post_id = intval($_GET["id"]);
$target_post = null;
$stmt = $main_db->prepare("SELECT * FROM Post WHERE PostID = ?");
$stmt->bind_param('i', $post_id);
$stmt->execute();
$result = $stmt->get_result();
if (!$result) {
    echo "errooor: " . $main_db->error . "\n";
    
}
if ($row = $result->fetch_assoc()) {
    dd($row);
    $post_replied_to = null;
    if (!is_null($row["Post_replied_to"])) { //todo
        dd($row["Post_replied_to"]);
        $stmt = $main_db->prepare("SELECT * FROM Post WHERE PostID = ?");
        $stmt->bind_param('i', $row["Post_replied_to"]);
        $stmt->execute();
        $result2 = $stmt->get_result();
        if (!$result2) {
            dd("errooor: " . $main_db->error . "\n");
        }

        if ($irow = $result2->fetch_assoc()) {
            $stmt = $main_db->prepare("SELECT * FROM Users WHERE UUID = ?");
            $stmt->bind_param('i', $irow["Poster"]);
            $stmt->execute();
            $result3 = $stmt->get_result();
            if (!$result3) {
                dd("errooor: " . $main_db->error . "\n");
            }
            $poster = null;
            if ($row3 = $result3->fetch_assoc()) {
                $poster = User::CreateFromArr($row3); // todo
            }
            $post_replied_to = Post::CreateFromArr($irow, $poster, null); // todo
        }
    }
    $stmt = $main_db->prepare("SELECT * FROM Users WHERE UUID = ?");
    $stmt->bind_param('i', $row["Poster"]);
    $stmt->execute();
    $result3 = $stmt->get_result();
    if (!$result3) {
        dd("errooor: " . $main_db->error . "\n");
    }
    $poster = null;
    if ($row3 = $result3->fetch_assoc()) {
        $poster = User::CreateFromArr($row3); // todo
    }
    $post = Post::CreateFromArr($row, $poster, $post_replied_to);
    dd($post);
    $target_post = $post;
} else {
    echo "Not found";
    header("Location: index.php");
}

?>

<main>
    <?php
    $post = $target_post;
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

    $feed = new ReplyFeed;
    $feed->viewer=$user_manager->user;
    $feed->post=$target_post;
    $feed->type= PostTypeEnum::reply;
    $feed->gatherFeed($main_db);
    foreach ($feed->posts as $i => $post) {
        switch($post->post_type){
            case PostTypeEnum::reply:
                require "./views/post-small.php";
                break;
            // case PostTypeEnum::quote:
            //     require "./views/quote-small.php";
            //     break;
        }
    }
    ?>
</main>
<?php
require_once "./views/foot.php";
?>  