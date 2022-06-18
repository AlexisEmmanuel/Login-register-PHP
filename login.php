<?php
session_start();
require_once 'config/database.php';
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
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login for users</title>
</head>
<body>
  <h1>Login for users</h1>
  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <input type="email" placeholder="Intert you email" name="userEmail">
    <input type="password" placeholder="Intert you password" name="userPass">
    <input type="submit" value="Login">
    <?php if(!empty($errorReporter)){
      ?>
      <p>
        <?php echo $errorReporter; ?>
      </p>
      <?php
    } ?>
  </form>
</body>
</html>