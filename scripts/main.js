let retweet_id = null



async function bookmark(id) {
    url = "new-bookmark.php";
    const response = await fetch(url, {
        method: "POST",
        body: "id="+id,
        headers: {
            //"Content-Type": "application/json",
             'Content-Type': 'application/x-www-form-urlencoded',
          }
    })
    const body = await response.text();
    if (body != "ok") {
        alert(body)
    } else {
        alert("Added bookmark")
    }
}
async function follow(id, follow) {
    url = "follow-redir.php";
    const response = await fetch(url, {
        method: "POST",
        body: "id="+id+"&follow="+follow,
        headers: {
            //"Content-Type": "application/json",
             'Content-Type': 'application/x-www-form-urlencoded',
          }
    })
    const body = await response.text();
    if (body != "ok") {
        alert(body)
    } else {
        alert((follow) ? "Unfollowed":"Followed" )
    }
    location.reload()
}
async function like(id) {
    url = "new-like.php";
    const response = await fetch(url, {
        method: "POST",
        body: "id="+id,
        headers: {
            //"Content-Type": "application/json",
             'Content-Type': 'application/x-www-form-urlencoded',
          }
    })
    const body = await response.text();
    if (body != "ok") {
        alert(body)
    } else {
        alert("Liked post")
    }
}
async function repost_empty(id) {
    url = "new-retweet.php";
    const response = await fetch(url, {
        method: "POST",
        body: "id="+id,
        headers: {
            //"Content-Type": "application/json",
             'Content-Type': 'application/x-www-form-urlencoded',
          }
    })
    const body = await response.text();
    if (body != "ok") {
        alert(body)
    } else {
        alert("Reposted")
    }
    location.reload()
}
