<?php 
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<div>
<?php
   if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] ===true){
?>
   
   <a href="dashboard.php">Dashboard</a>
   <a href="logout.php">Logout</a>
<?php }else { ?>

    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
    <?php } ?>
</div>
</body>
</html>