<?php
session_start();
require_once 'config/functions.php';
require_once 'config/database.php';

  if(empty($_SESSION['code'])){
    header('Location: index.php');
  }
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userCode = $_POST['code'];
    $errorReporter = null;
    if(!empty($userCode)) {
      if (strlen($userCode) == 4) {
        $realCode = $_SESSION['code'];
        if($realCode == $userCode) {
          /* Get Credentials */
          /* Set credentials */
          $stmt = $conn->prepare(
            "INSERT INTO `users` (`id`, `name`, `email`, `pass`) VALUES (NULL, :nameUser, :emailUser, :passUser);"
          );
          $stmt->execute(array(
            'nameUser' => $_SESSION['name'],
            'emailUser' => $_SESSION['email'],
            'passUser' => $_SESSION['password']
          ));
          $_SESSION = array();
          header('Location: index.php');
        } else {
          $errorReporter = "Incorrect code";
        }
      } else {
        $errorReporter = "Incomplete characters";
      }
    } else {
      $errorReporter = "Don't set empty spaces";
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verificate your email</title>
</head>
<body>
  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <input type="number" placeholder="Set your code" name="code" value="<?php if($_SERVER['REQUEST_METHOD'] == 'POST') { echo $userCode; } ?>">
    <input type="submit" value="Verificate">
    <?php if(!empty($errorReporter)) {?>
      <p>
        <?php echo $errorReporter; ?>
      </p>
    <?php } ?>
  </form>
</body>
</html>