<?php 
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] ===true){
  header("location: dashboard.php");
  exit;
}

require_once "config/config.php";

$username=$password="";
$username_err=$password_err="";

if($_SERVER['REQUEST_METHOD']== "POST"){
    
  if(empty(trim($_POST["username"]))){
      $username_err="Kuch naam to daal.";
  }else{
      $username = trim($_POST["username"]);
  }
  if(empty(trim($_POST["password"]))){
        $password_err="Password khali hai tere dimag ki tarah.";
    }else{
        $password = trim($_POST["password"]);
    }

    if(empty($username_err) && empty($password_err)){

      $sql = "SELECT id, username, password FROM users WHERE username = ?";

      if($stmt=$link->prepare($sql)){

        $stmt->bind_param("s", $param_username);

        $param_username = $username;

        if($stmt->execute()){

          $stmt->store_result();

          if($stmt->num_rows == 1){

            $stmt->bind_result($id, $username, $hashed_password);

            if( $stmt->fetch() ){

                if(password_verify($password, $hashed_password)){

                   // Store data in session variables
                   $_SESSION["loggedin"] = true;
                   $_SESSION["id"] = $id;
                   $_SESSION["username"] = $username;  

                   header("location: dashboard.php");

                }else{
                  $password_err="The password you entered was not valid";
                }
            }
          }else{
            echo "Something went wrong.";
          }
          $stmt->close();
        }
      }


    }

    $link->close();
}
?>

<!doctype html>
<html lang="en">
  <head>
    <title>Login Page</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
      
      <div class="container">
          <div class="card col-md-8">
            <div class="card-header">
                <h4>Login Form</h4>
            </div>
            <div class="card-body mx-auto text-center">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  method="post">
                <div class="form-group">
                <input type="text" name="username" placeholder="User Name" class="form-control <?php echo (!empty($username_err)) ? 'border border-danger' : ''; ?>" id="username" value="<?php echo $username; ?>">
                <span class="text-danger"><?php echo $username_err; ?></span>
                </div>
                <div class="form-group">
                <input type="text" name="password" id="password" placeholder="Password" class="form-control <?php echo (!empty($password_err)) ? 'border border-danger' : ''; ?>">
                <span class="text-danger"><?php echo $password_err; ?></span>
                </div>
                <input type="submit" value="Login" class="btn btn-primary">
                </form>
            </div>
          </div>
      </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>