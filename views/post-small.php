<div class="card tweet">
    <div class="card-body">
        <h5 class="card-title"><img src="<?=$post->poster->profile_pic?>" class="rounded-circle pfp" alt="..."> <?=$post->poster->display_name?></h5>
        <p class="card-text tweet-username">@<?=$post->poster->username?></p>
        <p class="card-text"><?=$post->content?></p>
        <p class="card-text tweet-date"><?=date("F j, Y, g:i a",$post->date->getTimestamp())?></p>
        <button class="btn btn-link card-link">like</button>
        <button class="btn btn-link card-link">repost</button>
        <button class="btn btn-link card-link">bkmrk</button>
        <a href="#" class="card-link">comment</a>
    </div>
    <?php if (!is_null($post->image)): ?>
    <img src="<?=$post->image?>" class="card-img-bottom" alt="...">
    <?php endif; ?>
</div>