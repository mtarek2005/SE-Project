<?php if (!is_null($user_manager->user)) : ?>
    <div class="card tweet">
        <form class="card-body" method="post" action="post-redirect.php?rd=<?= urlencode($_SERVER['REQUEST_URI']) ?>" enctype="multipart/form-data">
            <p class="card-text"><textarea name="post-text" id="post-text" placeholder="Speak your mind..."></textarea></p>
            <p class="card-link"><input type="file" name="post-img" id="post-img"></p>
            <button class="btn btn-link card-link text-muted text-decoration-none text-end"><i class="nf nf-cod-send post-icon"></i></button>
            <?php if (isset($target_post)) : ?>
                <input type="hidden" name="post-id" value="<?= $target_post->post_id ?>">
            <?php endif; ?>
            <input type="hidden" name="type" value="<?= $new_post_type ?>">
        </form>
    </div>
<?php endif; ?>