<?php
include_once 'config/database.php'; // Get database connection
session_start();
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
    <p>Hello <span><?php echo $_SESSION['accredited']; ?></span></p>
    <a href="logout.php">Log Out</a>
    <?php
  } else {
    ?>
    <h1>don't you're logged</h1>
    <p>try <a href="login.php">Login</a> or <a href="register.php">Register</a></p>
      <?php
  }
  ?>
  <h1>Article</h1>
  <article>
    Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi architecto repellendus
    culpa, amet dolore ducimus magnam doloremque laboriosam eveniet doloribus dignissimos 
    possimus blanditiis optio facere labore quod dolores sed cupiditate.
  </article>
</body>
</html>