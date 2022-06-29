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
        switch ($_SESSION['option']) {
          case 'registeruser':
            if($realCode == $userCode) {
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
            break;
          case 'forgotpassword':
            if($realCode == $userCode) {
              $_SESSION['door'] = 'accessToChangeYourPass';
              header('Location: changepass.php');
            } else {
              $errorReporter = "Incorrect code";
            }
          break;
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
  <?php require_once './templates/head.php'; ?>
  <title>Verificate your email</title>
</head>
<body>
  <div class="container">

    <h1>Check your email and insert your code</h1>
    <hr class="hr">
  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <input type="number" placeholder="Set your code" name="code" value="<?php if($_SERVER['REQUEST_METHOD'] == 'POST') { echo $userCode; } ?>">
    <input type="submit" value="Verificate">
    <?php if(!empty($errorReporter)) {?>
      <p>
        <?php echo $errorReporter; ?>
      </p>
    <?php } ?>
  </form>
</div>
</body>
</html>