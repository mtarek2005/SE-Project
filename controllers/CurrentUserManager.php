<?php
require_once "./include.php";
class CurrentUserManager{
    public $user; // : User
    function login($db/* : mysqli*/,$username,$pass){} // : void
    function register($db/* : mysqli*/,$username,$pass,$name){} // : void
    function follow($db/* : mysqli*/,$user){} // : void
    function mute($db/* : mysqli*/,$user){} // : void
    function block($db/* : mysqli*/,$user){} // : void
    function bookmark($db/* : mysqli*/,$post){} // : void
    function update_name($db/* : mysqli*/,$name){} // : void
    function update_about($db/* : mysqli*/,$about){} // : void
    function update_username($db/* : mysqli*/,$username){} // : void
    function update_pic($db/* : mysqli*/,$pic){} // : void
    function like($db/* : mysqli*/,$post){} // : void
    function repost($db/* : mysqli*/,$post){} // : void
    function post($db/* : mysqli*/,$post){} // : void
    function reply($db/* : mysqli*/,$post,$reply){} // : void
    function unfollow($db/* : mysqli*/,$user){} // : void
    function unmute($db/* : mysqli*/,$user){} // : void
    function unblock($db/* : mysqli*/,$user){} // : void
    function delete_post($db/* : mysqli*/,$post){} // : void
    function edit_post($db/* : mysqli*/,$post){} // : void
    function logout(){} // : void
}
class CurrentModManager extends CurrentUserManager{
    function global_mute($db/* : mysqli*/,$user){} // : void
    function ban($db/* : mysqli*/,$user){} // : void
    function delete_post($db/* : mysqli*/,$post){} // : void

}
?>