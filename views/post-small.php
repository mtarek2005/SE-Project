<div class="card tweet">
    <div class="card-body">
        <h5 class="card-title"><a href="userpage.php?username=<?= $post->poster->username ?>" class="text-decoration-none text-reset"><img src="<?= $post->poster->profile_pic ?>" class="rounded-circle pfp" alt="..."> <?= $post->poster->display_name ?></a></h5>
        <p class="card-text tweet-username"><a href="userpage.php?username=<?= $post->poster->username ?>" class="text-decoration-none text-reset">@<?= $post->poster->username ?></a></p>
        <p class="card-text"><a href="post-page.php?id=<?= $post->post_id ?>" class="text-decoration-none text-reset"><?= $post->content ?></a></p>
        <p class="card-text tweet-date"><?= date("F j, Y, g:i a", $post->date->getTimestamp()) ?></p>
        <button class="btn btn-link card-link text-muted text-decoration-none" onclick="like(<?= $post->post_id ?>)"><i class="nf nf-fa-heart like-icon"></i></button>
        <button class="btn btn-link card-link text-muted text-decoration-none" onclick="retweet_id = <?= $post->post_id ?>" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="nf nf-fa-retweet rtwt-icon"></i></button>
        <button class="btn btn-link card-link text-muted text-decoration-none"  onclick="bookmark(<?= $post->post_id ?>)"><i class="nf nf-fa-bookmark bkmrk-icon"></i></button>
        <a href="post-page.php?id=<?= $post->post_id ?>" class="card-link text-muted text-decoration-none"><i class="nf nf-md-comment cmnt-icon"></i></a>
    </div>
    <?php if (!is_null($post->image)) : ?>
        <a href="post-page.php?id=<?= $post->post_id ?>" class="text-decoration-none text-reset"><img src="<?= $post->image ?>" class="card-img-bottom" alt="..."></a>
    <?php endif; ?>
</div>