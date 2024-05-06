<?php
require_once "./views/head.php";

$lbl_err = null;
if ($_SERVER['REQUEST_METHOD'] == "POST") {

  $username = $_POST['username'];
  $pass = $_POST['password'];

  if (!empty($username) && !empty($pass) &&  !is_numeric($username)) {

    $res = $user_manager->login($main_db, $username, $pass);
    if ($res) {
      header("Location: index.php");
    } else {
      $lbl_err = "invalid username or password";
    }
  } else {
    $lbl_err = "please enter valid input";
  }
}
?>
<main>
  <form class="login2" method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
    <div class="row mb-3">
      <label for="inputEmail3" class="col-sm-2 col-form-label">Username</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="username" id="inputEmail3">
      </div>
    </div>
    <div class="row mb-3">
      <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
      <div class="col-sm-10">
        <input type="password" class="form-control" name="password" id="inputPassword3">
      </div>
    </div>

    <?php if (!is_null($lbl_err)) : ?>
      <div class="row mb-3 ">
        <div class="col-sm-10 offset-sm-2">
          <p><?= $lbl_err ?></p>
        </div>
      </div>
    <?php endif; ?>
    <button class="btn"><a href="signup.php">Sign up</a></button>
    <button type="submit" class="btn btn-primary">Log in</button>
  </form>
</main>
<?php
require_once "./views/foot.php";
?>