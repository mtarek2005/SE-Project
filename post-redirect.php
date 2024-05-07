<?php
require_once "./views/head.php";

echo "echo 1";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
echo "echo 2";
    $content = $_POST['post-text'];
    $type = $_POST['type'];
    $img = $_FILES['post-img']['name'];

    echo "echo 3";

    if (!empty($content)) {
        echo "echo 4";
        $upload_flag = false;
        $target_file = null;
        if (!empty($img)) {
            echo "echo 5";
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["post-img"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            if (isset($_POST["submit"])) {
                $check = getimagesize($_FILES["post-img"]["tmp_name"]);
                if ($check !== false) {
                    echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    echo "File is not an image.";
                    $uploadOk = 0;
                }
            }

            // Check if file already exists
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 500000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if (
                $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif"
            ) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["post-img"]["tmp_name"], $target_file)) {
                    echo "The file " . htmlspecialchars(basename($_FILES["post-img"]["name"])) . " has been uploaded.";
                    $upload_flag = true;
                } else {
                    echo "Sorry, there was an error uploading your file.";
                    echo $_FILES["post-img"]["tmp_name"];
                }
            }
        } else {
            echo "echo 6";
            $upload_flag = true;
        }
        if ($upload_flag) {
            echo "echo 7";
            $upload_post = new Post;
            $upload_post->post_id = random_int(0, 2147483647);
            $upload_post->poster = $user_manager->user;
            $upload_post->post_replied_to = (empty($_POST["post-id"])) ? null : new Post;
            $upload_post->post_type = Post::PostTypeEnumFromString($type);
            $upload_post->content = $content;
            $upload_post->date = new DateTime;
            $upload_post->image = $target_file;
            echo "echo 8";
            if ($upload_post->post_type == PostTypeEnum::main) {
                $user_manager->post($main_db, $upload_post);
            } else {
                $replied_to_post = new Post;
                $replied_to_post->post_id = intval($_POST["post-id"]);
                $user_manager->reply($main_db, $replied_to_post, $upload_post);
            }
            echo "echo 9";
            if (isset($_GET["rd"])) {
                header("Location: ".$_GET["rd"]);
            } else {
                header("Location: index.php");
            }
            echo "echo 10";
        }
    } else {
        echo "please enter valid input";
    }
}


require_once "./views/foot.php";
