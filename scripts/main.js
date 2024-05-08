let retweet_id = null



async function bookmark(id) {
    url = "new-bookmark.php";
    const response = await fetch(url, {
        method: "POST",
        body: "id=" + id,
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
        body: "id=" + id + "&follow=" + follow,
        headers: {
            //"Content-Type": "application/json",
            'Content-Type': 'application/x-www-form-urlencoded',
        }
    })
    const body = await response.text();
    if (body != "ok") {
        alert(body)
    } else {
        alert((follow) ? "Unfollowed" : "Followed")
    }
    location.reload()
}
async function like(id) {
    url = "new-like.php";
    const response = await fetch(url, {
        method: "POST",
        body: "id=" + id,
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
        body: "id=" + id,
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
async function ban(id) {
    if (confirm("Are you sure you want to ban this user?")) {
        url = "ban-redir.php";
        const response = await fetch(url, {
            method: "POST",
            body: "id=" + id,
            headers: {
                //"Content-Type": "application/json",
                'Content-Type': 'application/x-www-form-urlencoded',
            }
        })
        const body = await response.text();
        if (body != "ok") {
            alert(body)
        } else {
            alert("Banned.")
        }
        location.reload()
    }
}
async function global_mute(id) {
    if (confirm("Are you sure you want to mute this user?")) {
        url = "global-mute-redir.php";
        const response = await fetch(url, {
            method: "POST",
            body: "id=" + id,
            headers: {
                //"Content-Type": "application/json",
                'Content-Type': 'application/x-www-form-urlencoded',
            }
        })
        const body = await response.text();
        if (body != "ok") {
            alert(body)
        } else {
            alert("Muted.")
        }
        location.reload()
    }
}
async function delete_post(id) {
    if (confirm("Delete post?")) {
        url = "delete-post-redir.php";
        const response = await fetch(url, {
            method: "POST",
            body: "id=" + id,
            headers: {
                //"Content-Type": "application/json",
                'Content-Type': 'application/x-www-form-urlencoded',
            }
        })
        const body = await response.text();
        if (body != "ok") {
            alert(body)
        } else {
            alert("Deleted post")
        }
    }
    location.reload()
}
function quote_repost(retweet_id) {
    location = "quote-repost.php?id="+retweet_id+"&rd="+encodeURIComponent(location.href)
}