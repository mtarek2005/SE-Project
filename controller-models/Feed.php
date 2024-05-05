<?php
require_once "./include.php";
abstract class Feed
{
    public array $posts; // Post[]
    public array $reposts; // Repost[]
    abstract function gatherFeed(mysqli $db);
    function getPost(mysqli $db, $index)
    {
    }
}
class UserFeed extends Feed
{
    public User $user;
    function gatherFeed(mysqli $db)
    {
        $stmt = $db->prepare("SELECT * FROM Post WHERE Poster = ? ORDER BY Post_date DESC");
        $stmt->bind_param('i', $this->user->UUID);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            dd("errooor: " . $db->error . "\n");
        }
        $posts = [];
        while ($row = $result->fetch_assoc()) {
            dd($row);
            $post_replied_to = null;
            if (!is_null($row["Post_replied_to"])) { //todo
                dd($row["Post_replied_to"]);
                $stmt = $db->prepare("SELECT * FROM Post WHERE PostID = ?");
                $stmt->bind_param('i', $row["Post_replied_to"]);
                $stmt->execute();
                $result2 = $stmt->get_result();
                if (!$result2) {
                    dd("errooor: " . $db->error . "\n");
                }

                if ($irow = $result2->fetch_assoc()) {
                    $stmt = $db->prepare("SELECT * FROM Users WHERE UUID = ?");
                    $stmt->bind_param('i', $irow["Poster"]);
                    $stmt->execute();
                    $result3 = $stmt->get_result();
                    if (!$result3) {
                        dd("errooor: " . $db->error . "\n");
                    }
                    $poster = null;
                    if ($row3 = $result3->fetch_assoc()) {
                        $poster = User::CreateFromArr($row3); // todo
                    }
                    $post_replied_to = Post::CreateFromArr($irow, $poster, null); // todo
                }
            }
            $post = Post::CreateFromArr($row, $this->user, $post_replied_to);
            dd($post);
            $posts[] = $post;
        }
        $this->posts = $posts;
        $stmt = $db->prepare("SELECT * FROM Reposts WHERE User = ? ORDER BY Date DESC");
        $stmt->bind_param('i', $this->user->UUID);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            dd("errooor: " . $db->error . "\n");
        }
        $reposts = [];
        while ($row = $result->fetch_assoc()) {
            dd($row["Post"]);
            $stmt = $db->prepare("SELECT * FROM Post WHERE PostID = ?");
            $stmt->bind_param('i', $row["Post"]);
            $stmt->execute();
            $result2 = $stmt->get_result();
            if (!$result2) {
                dd("errooor: " . $db->error . "\n");
            }
            $post_replied_to = null;
            if ($irow = $result2->fetch_assoc()) {
                $stmt = $db->prepare("SELECT * FROM Users WHERE UUID = ?");
                $stmt->bind_param('i', $irow["Poster"]);
                $stmt->execute();
                $result3 = $stmt->get_result();
                if (!$result3) {
                    dd("errooor: " . $db->error . "\n");
                }
                $poster = null;
                if ($row3 = $result3->fetch_assoc()) {
                    $poster = User::CreateFromArr($row3); // todo
                }
                $post_replied_to = Post::CreateFromArr($irow, $poster, null); // todo
            }
            $repost = Repost::CreateFromArr($row, $this->user, $post_replied_to);

            $reposts[] = $repost;
            dd($row);
            dd($repost);
        }
        $this->reposts = $reposts;
    }
}
class FollowingFeed extends Feed
{
    public User $viewer;
    function gatherFeed(mysqli $db)
    {
        $stmt = $db->prepare("SELECT * FROM Post JOIN Follows ON Follows.Followed = Post.Poster WHERE Post_type != 'reply' AND Follows.Follower = ? ORDER BY Post_date DESC");
        $stmt->bind_param('i', $this->viewer->UUID);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            dd("errooor: " . $db->error . "\n");
        }
        $posts = [];
        while ($row = $result->fetch_assoc()) {
            dd($row);
            $post_replied_to = null;
            if (!is_null($row["Post_replied_to"])) { //todo
                dd($row["Post_replied_to"]);
                $stmt = $db->prepare("SELECT * FROM Post WHERE PostID = ?");
                $stmt->bind_param('i', $row["Post_replied_to"]);
                $stmt->execute();
                $result2 = $stmt->get_result();
                if (!$result2) {
                    dd("errooor: " . $db->error . "\n");
                }

                if ($irow = $result2->fetch_assoc()) {
                    $stmt = $db->prepare("SELECT * FROM Users WHERE UUID = ?");
                    $stmt->bind_param('i', $irow["Poster"]);
                    $stmt->execute();
                    $result3 = $stmt->get_result();
                    if (!$result3) {
                        dd("errooor: " . $db->error . "\n");
                    }
                    $poster = null;
                    if ($row3 = $result3->fetch_assoc()) {
                        $poster = User::CreateFromArr($row3); // todo
                    }
                    $post_replied_to = Post::CreateFromArr($irow, $poster, null); // todo
                }
            }
            $stmt = $db->prepare("SELECT * FROM Users WHERE UUID = ?");
            $stmt->bind_param('i', $row["Poster"]);
            $stmt->execute();
            $result3 = $stmt->get_result();
            if (!$result3) {
                dd("errooor: " . $db->error . "\n");
            }
            $poster = null;
            if ($row3 = $result3->fetch_assoc()) {
                $poster = User::CreateFromArr($row3); // todo
            }
            $post = Post::CreateFromArr($row, $poster, $post_replied_to);
            dd($post);
            $posts[] = $post;
        }
        $this->posts = $posts;
        $stmt = $db->prepare("SELECT * FROM Reposts JOIN Follows ON Follows.Followed = Reposts.User WHERE Follows.Follower = ? ORDER BY Reposts.Date DESC");
        $stmt->bind_param('i', $this->viewer->UUID);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            dd("errooor: " . $db->error . "\n");
        }
        $reposts = [];
        while ($row = $result->fetch_assoc()) {
            dd($row["Post"]);
            $stmt = $db->prepare("SELECT * FROM Post WHERE PostID = ?");
            $stmt->bind_param('i', $row["Post"]);
            $stmt->execute();
            $result2 = $stmt->get_result();
            if (!$result2) {
                dd("errooor: " . $db->error . "\n");
            }
            $post_replied_to = null;
            if ($irow = $result2->fetch_assoc()) {
                $stmt = $db->prepare("SELECT * FROM Users WHERE UUID = ?");
                $stmt->bind_param('i', $irow["Poster"]);
                $stmt->execute();
                $result3 = $stmt->get_result();
                if (!$result3) {
                    dd("errooor: " . $db->error . "\n");
                }
                $poster = null;
                if ($row3 = $result3->fetch_assoc()) {
                    $poster = User::CreateFromArr($row3); // todo
                }
                $post_replied_to = Post::CreateFromArr($irow, $poster, null); // todo
            }
            $stmt = $db->prepare("SELECT * FROM Users WHERE UUID = ?");
            $stmt->bind_param('i', $row["User"]);
            $stmt->execute();
            $result3 = $stmt->get_result();
            if (!$result3) {
                dd("errooor: " . $db->error . "\n");
            }
            $poster = null;
            if ($row3 = $result3->fetch_assoc()) {
                $poster = User::CreateFromArr($row3); // todo
            }
            $repost = Repost::CreateFromArr($row, $poster, $post_replied_to);
            $reposts[] = $repost;
            dd($row);
            dd($repost);
        }
        $this->reposts = $reposts;
    }
}
class ChronoFeed extends Feed
{
    public User|null $viewer;
    function gatherFeed(mysqli $db)
    {
        $stmt = $db->prepare("SELECT * FROM Post WHERE Post_type = 'main' OR Post_type = 'quote' ORDER BY Post_date DESC");
        //$stmt->bind_param('i', $this->user->UUID);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            dd("errooor: " . $db->error . "\n");
        }
        $posts = [];
        while ($row = $result->fetch_assoc()) {
            dd($row);
            $post_replied_to = null;
            if (!is_null($row["Post_replied_to"])) { //todo
                dd($row["Post_replied_to"]);
                $stmt = $db->prepare("SELECT * FROM Post WHERE PostID = ?");
                $stmt->bind_param('i', $row["Post_replied_to"]);
                $stmt->execute();
                $result2 = $stmt->get_result();
                if (!$result2) {
                    dd("errooor: " . $db->error . "\n");
                }

                if ($irow = $result2->fetch_assoc()) {
                    $stmt = $db->prepare("SELECT * FROM Users WHERE UUID = ?");
                    $stmt->bind_param('i', $irow["Poster"]);
                    $stmt->execute();
                    $result3 = $stmt->get_result();
                    if (!$result3) {
                        dd("errooor: " . $db->error . "\n");
                    }
                    $poster = null;
                    if ($row3 = $result3->fetch_assoc()) {
                        $poster = User::CreateFromArr($row3); // todo
                    }
                    $post_replied_to = Post::CreateFromArr($irow, $poster, null); // todo
                }
            }
            $stmt = $db->prepare("SELECT * FROM Users WHERE UUID = ?");
            $stmt->bind_param('i', $row["Poster"]);
            $stmt->execute();
            $result3 = $stmt->get_result();
            if (!$result3) {
                dd("errooor: " . $db->error . "\n");
            }
            $poster = null;
            if ($row3 = $result3->fetch_assoc()) {
                $poster = User::CreateFromArr($row3); // todo
            }
            $post = Post::CreateFromArr($row, $poster, $post_replied_to);
            dd($post);
            $posts[] = $post;
        }
        $this->posts = $posts;
        $stmt = $db->prepare("SELECT * FROM Reposts ORDER BY Date DESC");
        //$stmt->bind_param('i', $this->user->UUID);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            dd("errooor: " . $db->error . "\n");
        }
        $reposts = [];
        while ($row = $result->fetch_assoc()) {
            dd($row["Post"]);
            $stmt = $db->prepare("SELECT * FROM Post WHERE PostID = ?");
            $stmt->bind_param('i', $row["Post"]);
            $stmt->execute();
            $result2 = $stmt->get_result();
            if (!$result2) {
                dd("errooor: " . $db->error . "\n");
            }
            $post_replied_to = null;
            if ($irow = $result2->fetch_assoc()) {
                $stmt = $db->prepare("SELECT * FROM Users WHERE UUID = ?");
                $stmt->bind_param('i', $irow["Poster"]);
                $stmt->execute();
                $result3 = $stmt->get_result();
                if (!$result3) {
                    dd("errooor: " . $db->error . "\n");
                }
                $poster = null;
                if ($row3 = $result3->fetch_assoc()) {
                    $poster = User::CreateFromArr($row3); // todo
                }
                $post_replied_to = Post::CreateFromArr($irow, $poster, null); // todo
            }
            $stmt = $db->prepare("SELECT * FROM Users WHERE UUID = ?");
            $stmt->bind_param('i', $row["User"]);
            $stmt->execute();
            $result3 = $stmt->get_result();
            if (!$result3) {
                dd("errooor: " . $db->error . "\n");
            }
            $poster = null;
            if ($row3 = $result3->fetch_assoc()) {
                $poster = User::CreateFromArr($row3); // todo
            }
            $repost = Repost::CreateFromArr($row, $poster, $post_replied_to);
            $reposts[] = $repost;
            dd($row);
            dd($repost);
        }
        $this->reposts = $reposts;
    }
}
class SearchFeed extends Feed
{
    public User $viewer;
    public string $query;
    function gatherFeed(mysqli $db)
    {
        $query = "%".$this->query."%";
        $stmt = $db->prepare("SELECT * FROM Post WHERE Content LIKE ? ORDER BY Post_date DESC");
        $stmt->bind_param('s', $query);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            dd("errooor: " . $db->error . "\n");
        }
        $posts = [];
        while ($row = $result->fetch_assoc()) {
            dd($row);
            $post_replied_to = null;
            if (!is_null($row["Post_replied_to"])) { //todo
                dd($row["Post_replied_to"]);
                $stmt = $db->prepare("SELECT * FROM Post WHERE PostID = ?");
                $stmt->bind_param('i', $row["Post_replied_to"]);
                $stmt->execute();
                $result2 = $stmt->get_result();
                if (!$result2) {
                    dd("errooor: " . $db->error . "\n");
                }

                if ($irow = $result2->fetch_assoc()) {
                    $stmt = $db->prepare("SELECT * FROM Users WHERE UUID = ?");
                    $stmt->bind_param('i', $irow["Poster"]);
                    $stmt->execute();
                    $result3 = $stmt->get_result();
                    if (!$result3) {
                        dd("errooor: " . $db->error . "\n");
                    }
                    $poster = null;
                    if ($row3 = $result3->fetch_assoc()) {
                        $poster = User::CreateFromArr($row3); // todo
                    }
                    $post_replied_to = Post::CreateFromArr($irow, $poster, null); // todo
                }
            }
            $stmt = $db->prepare("SELECT * FROM Users WHERE UUID = ?");
            $stmt->bind_param('i', $row["Poster"]);
            $stmt->execute();
            $result3 = $stmt->get_result();
            if (!$result3) {
                dd("errooor: " . $db->error . "\n");
            }
            $poster = null;
            if ($row3 = $result3->fetch_assoc()) {
                $poster = User::CreateFromArr($row3); // todo
            }
            $post = Post::CreateFromArr($row, $poster, $post_replied_to);
            dd($post);
            $posts[] = $post;
        }
        $this->posts = $posts;
        $reposts = [];
        $this->reposts = $reposts;
    }    
}
class BookmarkFeed extends Feed
{
    public User $viewer;
    public array $bookmarks;
    function gatherFeed(mysqli $db)
    {
        $stmt = $db->prepare("SELECT * FROM Post JOIN Bookmarks ON Bookmarks.Post = Post.PostID WHERE Bookmarks.User = ? ORDER BY Bookmarks.Date DESC");
        $stmt->bind_param('i', $this->viewer->UUID);
        $stmt->execute();
        $result = $stmt->get_result();
        dd($result);
        if (!$result) {
            dd("errooor: " . $db->error . "\n");
        }
        $posts = [];
        $bookmarks = [];
        while ($row = $result->fetch_assoc()) {
            dd($row);
            $post_replied_to = null;
            if (!is_null($row["Post_replied_to"])) { //todo
                dd($row["Post_replied_to"]);
                $stmt = $db->prepare("SELECT * FROM Post WHERE PostID = ?");
                $stmt->bind_param('i', $row["Post_replied_to"]);
                $stmt->execute();
                $result2 = $stmt->get_result();
                if (!$result2) {
                    dd("errooor: " . $db->error . "\n");
                }

                if ($irow = $result2->fetch_assoc()) {
                    $stmt = $db->prepare("SELECT * FROM Users WHERE UUID = ?");
                    $stmt->bind_param('i', $irow["Poster"]);
                    $stmt->execute();
                    $result3 = $stmt->get_result();
                    if (!$result3) {
                        dd("errooor: " . $db->error . "\n");
                    }
                    $poster = null;
                    if ($row3 = $result3->fetch_assoc()) {
                        $poster = User::CreateFromArr($row3); // todo
                    }
                    $post_replied_to = Post::CreateFromArr($irow, $poster, null); // todo
                }
            }
            $stmt = $db->prepare("SELECT * FROM Users WHERE UUID = ?");
            $stmt->bind_param('i', $row["Poster"]);
            $stmt->execute();
            $result3 = $stmt->get_result();
            if (!$result3) {
                dd("errooor: " . $db->error . "\n");
            }
            $poster = null;
            if ($row3 = $result3->fetch_assoc()) {
                $poster = User::CreateFromArr($row3); // todo
            }
            $post = Post::CreateFromArr($row, $poster, $post_replied_to);
            dd($post);
            $posts[] = $post;
            $bookmark = new Bookmark;
            $bookmark->post=$post;
            $bookmark->date=DateTime::createFromFormat("Y-m-d G:i:s", $row["Date"]);
            $bookmarks[] = $bookmark;
        }
        $this->posts = $posts;
        $this->bookmarks = $bookmarks;
        $reposts = [];
        $this->reposts = $reposts;
    }    
}
class ReplyFeed extends Feed {
    public User $viewer;
    public Post $post;
    public PostTypeEnum $type;
    function gatherFeed(mysqli $db)
    {
        $stmt = null;
        if ($this->type == PostTypeEnum::reply) {
            $stmt = $db->prepare("SELECT * FROM Post WHERE Post_type = 'reply' AND Post_replied_to = ? ORDER BY Post_date DESC");
        } else if ($this->type == PostTypeEnum::quote) {
            $stmt = $db->prepare("SELECT * FROM Post WHERE Post_type = 'quote' AND Post_replied_to = ? ORDER BY Post_date DESC");
        } else {
            dd("Type cannot be 'main'");
        }
        $stmt->bind_param('i', $this->post->post_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            dd("errooor: " . $db->error . "\n");
        }
        $posts = [];
        while ($row = $result->fetch_assoc()) {
            dd($row);
            $post_replied_to = $this->post;
            $stmt = $db->prepare("SELECT * FROM Users WHERE UUID = ?");
            $stmt->bind_param('i', $row["Poster"]);
            $stmt->execute();
            $result3 = $stmt->get_result();
            if (!$result3) {
                dd("errooor: " . $db->error . "\n");
            }
            $poster = null;
            if ($row3 = $result3->fetch_assoc()) {
                $poster = User::CreateFromArr($row3); // todo
            }
            $post = Post::CreateFromArr($row, $poster, $post_replied_to);
            dd($post);
            $posts[] = $post;
        }
        $this->posts = $posts;
        $stmt = $db->prepare("SELECT * FROM Reposts");
        //$stmt->bind_param('i', $this->user->UUID);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            dd("errooor: " . $db->error . "\n");
        }
        $reposts = [];
        $this->reposts = $reposts;
    }
}