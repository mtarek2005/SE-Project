<div class="card tweet">
    <div class="card-body">
        <h5 class="card-title"><img src="<?=$post->poster->profile_pic?>" class="rounded-circle pfp" alt="..."> <?=$post->poster->display_name?></h5>
        <p class="card-text tweet-username">@<?=$post->poster->username?></p>
        <p class="card-text"><?=$post->content?></p>
        <p class="card-text tweet-date"><?=date("F j, Y, g:i a",$post->date->getTimestamp())?></p>
        <button class="btn btn-link card-link text-muted text-decoration-none"><i class="nf nf-fa-heart like-icon"></i></button>
        <button class="btn btn-link card-link text-muted text-decoration-none"><i class="nf nf-fa-retweet rtwt-icon"></i></button>
        <button class="btn btn-link card-link text-muted text-decoration-none"><i class="nf nf-fa-bookmark bkmrk-icon"></i></button>
        <a href="#" class="card-link text-muted text-decoration-none"><i class="nf nf-md-comment cmnt-icon"></i></a>
    </div>
    <?php if (!is_null($post->image)): ?>
    <img src="<?=$post->image?>" class="card-img-bottom" alt="...">
    <?php endif; ?>
</div>