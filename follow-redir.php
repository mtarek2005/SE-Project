<?php
require_once "./include.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $content = $_POST['id'];
    $follow = $_POST['follow'];
    if (!empty($content) && !empty($follow)) {
        $follow_user = new User;
        $follow_user->UUID = intval($content);
        if ($follow == 'false') {
            $user_manager->follow($main_db, $follow_user);
        } else {
            $user_manager->unfollow($main_db, $follow_user);
        }
        echo "ok";
    } else {
        echo "please enter valid input";
        print_r($_POST);
    }
}

?>