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
  <?php require_once './templates/head.php'; ?>
  <title>Home Login & Register</title>
</head>
<body>
  <div class="container">
    <div class="text-content">
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
    </div>
    <hr>
    <div class="text-content">
      <h1>Article</h1>
      <article>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas repellendus sit, iste laboriosam, reprehenderit accusamus minima quos aperiam quae pariatur distinctio quibusdam voluptatibus sint culpa, necessitatibus aspernatur dolorum ipsa ex exercitationem officia? Rem repudiandae vel aut autem, numquam libero corrupti, deserunt consectetur alias nam illum maxime eum veniam recusandae temporibus ipsam totam, itaque laudantium distinctio ab dolor. Recusandae voluptatem saepe dolores provident nobis. Recusandae vero rem quis ab odit eveniet sit aliquam temporibus illum a blanditiis ut tenetur suscipit ea labore, corrupti, nobis cumque amet delectus architecto error quae id perferendis ducimus! Quibusdam ad tempore nostrum obcaecati voluptatibus minima, iusto, quis iste dignissimos ex eligendi maxime eveniet inventore adipisci atque porro alias facilis, nobis repudiandae nisi dolorem doloremque deleniti? Tempora.
      </article>
    </div>
  </div>
</body>
</html>