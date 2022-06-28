<?php

session_start();
$errorReporter = null;
require_once 'config/database.php';
if(empty($_SESSION['door'])) {
  header('Location: index.php');
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $passwordNew = $_POST['pass'];
  $passwordNewRepeat = $_POST['repeatPass'];
  $passwordNew = hash('sha512', $passwordNew); /* Hash password */
  $passwordNewRepeat = hash('sha512', $passwordNewRepeat); /* Hash password */
  if(!empty($passwordNew) && !empty($passwordNewRepeat)){
    $emailToChangePass =  $_SESSION['email'];
    $stmt = $conn->prepare(
      "UPDATE `users` SET `pass` = :newPass WHERE `users`.`email` = :email"
    );
    $stmt -> execute(array(
      ':email' => $emailToChangePass,
      ':newPass' => $passwordNewRepeat
    ));
    $_SESSION[] = array();
    header('Location: index.php');
  } else {
    $errorReporter = "Don't leave empty spaces";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create your new password</title>
</head>
<body>
  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <input type="password" name="pass" placeholder="Password">
    <input type="password" name="repeatPass" placeholder="Repeat password">
    <input type="submit" value="Change password">
  </form>
  <?php if($_SERVER['REQUEST_METHOD'] == 'POST'){ ?>
    <p>
      <?php echo $errorReporter; ?>
    </p>
  <?php } ?>
</body>
</html>