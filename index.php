<?php
require_once "./views/head.php";
?>

<main>
    <h1>Hello, world!</h1>
    <div class="card tweet">
        <div class="card-body">
            <h5 class="card-title"><img src="images/pexels-pixabay-45201.jpg" class="rounded-circle pfp" alt="..."> Tweeter</h5>
            <p class="card-text tweet-username">@goog</p>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <button class="btn btn-link card-link">like</button>
            <button class="btn btn-link card-link">repost</button>
            <a href="#" class="card-link">comment</a>
        </div>
        <img src="images/pexels-mikebirdy-170811.jpg" class="card-img-bottom" alt="...">
    </div>
</main>
<?php
require_once "./views/foot.php";
?>