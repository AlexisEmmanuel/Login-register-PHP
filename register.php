<?php
session_start();
require_once 'config/database.php'; // Get database connection
/* Verify if the user has logged in */
if (isset($_SESSION['accredited'])) {
  header('Location: index.php');
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $errorReporter = null;
  $userName = strip_tags($_POST['userName']); // Register credentials
  $userEmail = strip_tags($_POST['userEmail']);
  $userPass = strip_tags($_POST['userPass']);
  $userPassRepeat = strip_tags($_POST['userPassRepeat']);
  if (empty($userName) || empty($userEmail) || empty($userPass) || empty($userPassRepeat)) {
    $errorReporter = 'Dont set empty spaces';
  } else {
    $userPassRepeat = hash('sha512', $userPassRepeat);
    $userPass = hash('sha512', $userPass);
    if ($userPass != $userPassRepeat) {
      $errorReporter = 'The password dont is correct';
    } else {
      $stmt = $conn->prepare("SELECT * FROM `users` WHERE email = :email LIMIT 1");
      $stmt -> execute(array(
        ':email' => $userEmail
      ));
      $result = $stmt->fetch();
      if($result != false) {
        $errorReporter = 'This email already registered';
      } else { // Push credentials
        $stmt = $conn->prepare(
          "INSERT INTO `users` (`id`, `name`, `email`, `pass`) VALUES (NULL, :nameUser, :emailUser, :passUser);"
        );
        $stmt->execute(array(
          'nameUser' => $userName,
          'emailUser' => $userEmail,
          'passUser' => $userPassRepeat
        ));
        header('Location: index.php');
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register for Users</title>
</head>
<body>
  <h1>Register Page</h1>
  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
    <input type="text" placeholder="User name" name="userName">
    <input type="email" placeholder="User email" name="userEmail">
    <input type="password" placeholder="User password" name="userPass">
    <input type="password" placeholder="Repeat user password" name="userPassRepeat">
    <input type="submit" value="Register">
    <?php
    if (!empty($errorReporter)) {
      echo $errorReporter;
    }
    ?>
  </form>
</body>
</html>