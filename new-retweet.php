<?php
require_once "./include.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $content = $_POST['id'];

    if (is_numeric($content)) {
        $upload_post = new Post;
        $upload_post->post_id = $content;
        $user_manager->repost($main_db, $upload_post);
        echo "ok";
    } else {
        echo "please enter valid input";
        print_r($_POST);
    }
}

?>