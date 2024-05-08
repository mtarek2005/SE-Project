<?php
require_once "./views/head.php";
if (!isset($_GET["id"])){
    header("Location: index.php");

}
$id = intval($_GET["id"]);
$feed = new LikesList;
$feed->post=new Post;
$feed->post->post_id = $id;
$feed->gatherList($main_db);
?>

<main>
    <h1 class="feed-head">Likes: <?= count($feed->users)?></h1>
    <?php
  
    foreach ($feed->users as $i => $user) {
        require "./views/user-small.php";
    }
    if (count($feed->users) == 0){
        echo "This user has no followers. Sad.";
    }
    ?>
</main>
<?php
require_once "./views/foot.php";
?>