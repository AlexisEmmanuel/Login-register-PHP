<?php
include_once 'config/database.php'; // Get database connection
session_start();
/* verify if the account exist */
if (isset($_SESSION['accredited'])) {
  $verify = $conn->prepare("SELECT * FROM `users` WHERE email = :email LIMIT 1");
  $verify->execute(array(
    'email' => $_SESSION['accredited']
  ));
  $result = $verify->fetch();
  if($result == false) {
    header('Location: logout.php');
  }
  /* Get name of account */
  $getName = $conn->prepare("SELECT name FROM `users` WHERE email = :email");
  $getName->execute(array(
    'email' => $_SESSION['accredited']
  ));
  $nameUser = $getName->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Home Login & Register</title>
</head>
<body>
  <?php
  if (isset($_SESSION['accredited'])) { // Validate the session
    ?>
    <h1>You're logged</h1>
    <p>
      Hello 
      <span>
        <?php
          foreach($nameUser as $name) { 
            echo ucwords($name['name']); 
          } 
        ?>
     </span>
    </p>
    <a href="logout.php">Log Out</a>
    <?php
  } else {
    ?>
    <h1>Don't you're logged</h1>
    <p>Try <a href="login.php">Login</a> or <a href="register.php">Register</a></p>
      <?php
  }
  ?>
  <hr>
  <h1>Article</h1>
  <article>
    Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi architecto repellendus
    culpa, amet dolore ducimus magnam doloremque laboriosam eveniet doloribus dignissimos 
    possimus blanditiis optio facere labore quod dolores sed cupiditate.
  </article>
</body>
</html>