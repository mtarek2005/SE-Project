<?php
require_once "./views/head.php";

$lbl_err = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $username = $_POST['username'];
    $display_name = $_POST['dn'];
    $about = $_POST['about'];


    $all_empty = true;
    if (!empty($username)) {
        $res = $user_manager->update_username($main_db, $username);
        if ($res) {
            //header("Location: index.php");
            $lbl_err = "Successfully changed username";
        } else {
            $lbl_err = "Username taken";
        }
        $all_empty = false;
    }
    if (!empty($display_name)) {
        $res = $user_manager->update_name($main_db, $display_name);
        $lbl_err = "Successfully updated display name";
        $all_empty = false;
    }
    if (!empty($about)) {
        $res = $user_manager->update_about($main_db, $about);
        $lbl_err = "Successfully updated biography";
        $all_empty = false;
    }
    if (!empty($_FILES["post-img"]["name"])) {
        $target_dir = "uploads/";
        $target_file = $target_dir .random_int(0, 65535). basename($_FILES["post-img"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["post-img"]["tmp_name"]);
            if ($check !== false) {
                $lbl_err = "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                $lbl_err = "File is not an image.";
                $uploadOk = 0;
            }
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $lbl_err = "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            $lbl_err = "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            $lbl_err = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $lbl_err = "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["post-img"]["tmp_name"], $target_file)) {
                $user_manager->update_pic($main_db, $target_file);
                $lbl_err = "The file " . htmlspecialchars(basename($_FILES["post-img"]["name"])) . " has been uploaded, successfully changed profile picture";
                $all_empty = false;
            } else {
                $lbl_err = "Sorry, there was an error uploading your file.".$_FILES["post-img"]["tmp_name"];
            }
        }
    }
    if ($all_empty) {
        $lbl_err = "Please enter input";
    }
}

?>

<main>
    <div>
        <form method="post" enctype="multipart/form-data">
            <p><img src="<?= $user_manager->user->profile_pic ?>" class="rounded-circle pfp-big" alt="..."></p>
            <label for="">Profile Picture: </label>
            <input type="file" name="post-img">
            <button type="submit">Change</button>
        </form>
        <form method="post">
            <label for="">Username</label>
            <input value="<?= $user_manager->user->username ?>" type="text" name="username">
            <button type="submit">Change</button>
        </form>
        <form method="post">
            <label for="">Display Name</label>
            <input value="<?= $user_manager->user->display_name ?>" type="text" name="dn">
            <button type="submit">Change</button>
        </form>
        <form method="post">
            <label for="">About</label>
            <textarea name="about" style="width:100%" id=""><?= $user_manager->user->about ?></textarea>
            <button type="submit">Change</button>
        </form>
        <p><?= $lbl_err ?></p>
    </div>
</main>

<?php
require_once "./views/foot.php";
?>