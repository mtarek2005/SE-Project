<?php
require_once "./views/head.php";
?>

<main>
    <h1>Hello, world!</h1>
    <?php
    $post = new Post;
    $post->post_id=0;
    $post->poster=new User;
    $post->poster->username="goog";
    $post->poster->display_name="Tweeter";
    $post->poster->profile_pic="images/pexels-pixabay-45201.jpg";
    $post->content="Some quick example text to build on the card title and make up the bulk of the card's content.";
    $post->date=new DateTime();
    $post->image="images/pexels-mikebirdy-170811.jpg";
     require_once "./views/post-small.php"; 
     ?>
</main>
<?php
require_once "./views/foot.php";
?>