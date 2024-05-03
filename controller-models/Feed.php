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
        $stmt = $db->prepare("SELECT * FROM Post WHERE Poster = ?");
        $stmt->bind_param('i', $this->user->UUID);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            echo "errooor: " . $db->error . "\n";
        }
        $posts = [];
        while ($row = $result->fetch_assoc()) {
            print_r($row);
            $post_replied_to = null;
            if (!is_null($row["Post_replied_to"])) { //todo
                echo $row["Post_replied_to"];
                $stmt = $db->prepare("SELECT * FROM Post WHERE PostID = ?");
                $stmt->bind_param('i', $row["Post_replied_to"]);
                $stmt->execute();
                $result2 = $stmt->get_result();
                if (!$result2) {
                    echo "errooor: " . $db->error . "\n";
                }

                if ($irow = $result2->fetch_assoc()) {
                    $stmt = $db->prepare("SELECT * FROM Users WHERE UUID = ?");
                    $stmt->bind_param('i', $row["Poster"]);
                    $stmt->execute();
                    $result3 = $stmt->get_result();
                    if (!$result3) {
                        echo "errooor: " . $db->error . "\n";
                    }
                    $poster = null;
                    if ($row3 = $result3->fetch_assoc()) {
                        $poster = User::CreateFromArr($row3); // todo
                    }
                    $post_replied_to = Post::CreateFromArr($irow, $poster, null); // todo
                }
            }
            $post = Post::CreateFromArr($row, $this->user, $post_replied_to);
            print_r($post);
            $posts[] = $post;
        }
        $this->posts = $posts;
        $stmt = $db->prepare("SELECT * FROM Reposts WHERE User = ?");
        $stmt->bind_param('i', $this->user->UUID);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            echo "errooor: " . $db->error . "\n";
        }
        $reposts = [];
        while ($row = $result->fetch_assoc()) {
            echo $row["Post"];
            $stmt = $db->prepare("SELECT * FROM Post WHERE PostID = ?");
            $stmt->bind_param('i', $row["Post"]);
            $stmt->execute();
            $result2 = $stmt->get_result();
            if (!$result2) {
                echo "errooor: " . $db->error . "\n";
            }
            $post_replied_to = null;
            if ($irow = $result2->fetch_assoc()) {
                $stmt = $db->prepare("SELECT * FROM Users WHERE UUID = ?");
                $stmt->bind_param('i', $row["User"]);
                $stmt->execute();
                $result3 = $stmt->get_result();
                if (!$result3) {
                    echo "errooor: " . $db->error . "\n";
                }
                $poster = null;
                if ($row3 = $result3->fetch_assoc()) {
                    $poster = User::CreateFromArr($row3); // todo
                }
                $post_replied_to = Post::CreateFromArr($irow, $poster, null); // todo
            }
            $repost = Repost::CreateFromArr($row, $this->user, $post_replied_to);

            $reposts[] = $repost;
            print_r($row);
            print_r($repost);
        }
        $this->reposts = $reposts;
    }
}
class FollowingFeed extends Feed
{
    public User $viewer;
    function gatherFeed(mysqli $db)
    {
    }
}
class ChronoFeed extends Feed
{
    public User $viewer;
    function gatherFeed(mysqli $db)
    {
    }
}
class SearchFeed extends Feed
{
    public User $viewer;
    public string $query;
    function gatherFeed(mysqli $db)
    {
    }
}
class BookmarkFeed extends Feed
{
    public User $viewer;
    public array $bookmarks;
    function gatherFeed(mysqli $db)
    {
    }
}
