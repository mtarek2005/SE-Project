<?php
require_once "./include.php";
class CurrentUserManager{
    public $user; // : User
    function login(mysqli $db,$username,$pass){} // : void
    function register(mysqli $db,$username,$pass,$name){} // : void
    function follow(mysqli $db,$user){} // : void
    function mute(mysqli $db,$user){} // : void
    function block(mysqli $db,$user){} // : void
    function bookmark(mysqli $db,$post){} // : void
    function update_name(mysqli $db,$name){} // : void
    function update_about(mysqli $db,$about){} // : void
    function update_username(mysqli $db,$username){} // : void
    function update_pic(mysqli $db,$pic){} // : void
    function like(mysqli $db,$post){} // : void
    function repost(mysqli $db,$post){} // : void
    function post(mysqli $db,$post){} // : void
    function reply(mysqli $db,$post,$reply){} // : void
    function unfollow(mysqli $db,$user){} // : void
    function unmute(mysqli $db,$user){} // : void
    function unblock(mysqli $db,$user){} // : void
    function delete_post(mysqli $db,$post){} // : void
    function edit_post(mysqli $db,$post){} // : void
    function logout(){} // : void
}
class CurrentModManager extends CurrentUserManager{
    function global_mute(mysqli $db,$user){} // : void
    function ban(mysqli $db,$user){} // : void
    function delete_post(mysqli $db,$post){} // : void

}
?>