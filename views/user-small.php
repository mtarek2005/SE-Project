<?php
$follow = $user_manager->follows_user($main_db, $user);

if ($user->UUID == $user_manager->user->UUID) {
    unset($follow);
}
?>

<div class="card tweet">
    <div class="card-body">
        <h5 class="card-title"><a href="userpage.php?username=<?= $user->username ?>" class="text-decoration-none text-reset"><img src="<?= $user->profile_pic ?>" class="rounded-circle pfp" alt="..."> <?= $user->display_name ?></a></h5>
        <p class="card-text tweet-username"><a href="userpage.php?username=<?= $user->username ?>" class="text-decoration-none text-reset">@<?= $user->username ?></a></p>
        <?php if (isset($follow)) : ?>
            <button class="btn btn-link card-link text-muted text-decoration-none" onclick="follow(<?= ''.$user->UUID .',' . (($follow) ? 'true' : 'false')?>)"><i class="nf <?= ($follow) ? "nf-md-account_remove unfollow-icon" : "nf-md-account_plus follow-icon" ?>"></i></button>
        <?php endif; ?>
    </div>
</div>