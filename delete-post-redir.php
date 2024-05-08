<?php
require_once "./include.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $content = $_POST['id'];

    if (!empty($content)) {
        $delete_post = new Post;
        $delete_post->post_id = $content;
        if ($user_manager->user->role == RoleEnum::regular) {
            $user_manager->delete_post($main_db, $delete_post);
            echo "ok";
        } else if ($user_manager->user->role == RoleEnum::moderator) {
            
            $mod_manager->delete_post($main_db, $delete_post);
            echo "ok";
        }
    } else {
        echo "please enter valid input";
        print_r($_POST);
    }
}

?>