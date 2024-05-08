<?php
require_once "./views/head.php";
?>
<main>
    <?php
        $redirpath = urlencode($_GET['rd']);
        $new_post_type = "quote";
        $target_post = new Post;
        $target_post->post_id = intval($_GET['id']);
        require "./views/new-post.php";
    ?>
</main>
<?php
require_once "./views/foot.php";
?>