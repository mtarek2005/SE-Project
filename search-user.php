<?php
require_once "./views/head.php";
if (!isset($_GET["query"])){
    header("Location: index.php");

}
$query = $_GET["query"];
$feed = new SearchUserList;
$feed->query=$query;
$feed->gatherList($main_db);
?>

<main>
    <h1 class="feed-head">Search: <?= $query?></h1>
    <h4 class="feed-head"><a href="search.php?query=<?=$query?>">Posts</a> Users</h4>
    <?php
  
    foreach ($feed->users as $i => $user) {
        require "./views/user-small.php";
    }
    if (count($feed->users) == 0){
         echo "<h6 class=\"feed-head\">This search yielded no results.</h6>";
    }
    ?>
</main>
<?php
require_once "./views/foot.php";
?>