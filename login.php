<?php
session_start();
require_once 'config/database.php';
/* Verify if the user has logged in */
if (isset($_SESSION['accredited'])) {
  header('Location: index.php');
}
if($_SERVER['REQUEST_METHOD']=='POST'){
  $userEmail = $_POST['userEmail']; // Compile credentials
  $userPass = $_POST['userPass'];
  if(empty($userEmail) || empty($userPass)){
    $errorReporter = 'Dont set empty spaces';
  } else {
    $userPass = hash('sha512', $userPass);
    $stmt = $conn->prepare('SELECT * FROM `users` WHERE email = :email AND pass = :pass');  // Search credential from database
    $stmt->execute(array(
      'email' => $userEmail,
      'pass' => $userPass
    ));
    $result = $stmt->fetch(); // this save true or false depending of the consult
    if($result !== false){ // Validate login
      $_SESSION['accredited'] = $userEmail;
      header('Location: index.php');
    } else {
      $errorReporter = 'Email or password incorrect';
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require_once './templates/head.php'; ?>
  <title>Login for users</title>
</head>
<body>
  <div class="container">

    <h1>Login for users</h1>
    <hr class="hr">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <input type="email" placeholder="Intert your email" name="userEmail">
    <input type="password" placeholder="Intert your password" name="userPass">
    <input type="submit" value="Login">
    <?php if(!empty($errorReporter)){
      ?>
      <p>
        <?php echo $errorReporter; ?>
      </p>
      <?php
    } ?>
    <a href="forgot.php">I don't remember my password</a>
  </form>
</div>
</body>
</html>