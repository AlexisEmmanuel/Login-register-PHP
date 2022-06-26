<?php

session_start();
$errorReporter = null;
if(empty($_SESSION['door'])) {
  header('Location: index.php');
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
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
    <input type="password" name="pass">
    <input type="password" name="repeatPass">
    <input type="submit" value="Change password">
  </form>
  <?php if($_SERVER['REQUEST_METHOD'] == 'POST'){ ?>
    <p>
      <?php echo $errorReporter; ?>
    </p>
  <?php } ?>
</body>
</html>