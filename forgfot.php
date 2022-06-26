<?php
session_start();
/* Get important datas */
require_once 'config/database.php';
require_once 'config/functions.php';

$errorReporter = null;
if (isset($_SESSION['accredited'])) { /* If the user is accredited redirect to the index */
  header('Location: index.php');
}
if($_SERVER['REQUEST_METHOD']=='POST') {
  $emailRecuperate = strip_tags($_POST['email']);
  if(!empty($emailRecuperate)){
    $stmt = $conn->prepare("SELECT email FROM `users` WHERE email = :email"); /* Prepare the query */
    $stmt -> execute(array(
      ':email' => $emailRecuperate
    ));
    $result = $stmt->fetch();
    if ($result == true) {
      $code = rand(1000, 9999);
      $title = 'Password support';
      $subject = 'Recuperate your account';
      $reason = 'Recuperate your account with this code: ' . $code;
      verificateEmail($emailRecuperate, $reason, $subject, $title);
      $_SESSION['email'] = $emailRecuperate;
      $_SESSION['code'] = $code;
      $_SESSION['option'] = 'forgotpassword';
      header('Location: verificatecode.php');
    } else {
      $errorReporter = 'This email doesnt exist';
    }
  } else {
    $errorReporter = 'Dont set empty spaces';
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot password</title>
</head>
<body>
  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <input type="email" name="email" placeholder="Insert your email">
    <input type="submit" value="Recuperate">
    <? if($_SERVER['REQUEST_METHOD']=='POST'){ ?>
      <p>
        <?php echo $errorReporter; ?>
      </p>
    <? } ?>
  </form>
</body>
</html>