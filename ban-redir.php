<?php
require_once "./include.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $content = $_POST['id'];
    if (!empty($content)) {
        $follow_user = new User;
        $follow_user->UUID = intval($content);
        //print_r($user_manager->user);
        if ($user_manager->user->role == RoleEnum::moderator) {
            $mod_manager->ban($main_db, $follow_user);
            echo "ok";
        } else {
            echo "not moderator";
        }
    } else {
        echo "please enter valid input";
        print_r($_POST);
    }
} 
