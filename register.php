<?php 

  require_once "./config/config.php";

  $username = $password = $confirm_password = "";
  $username_err = $password_err = $confirm_password_err = "";

//  echo '<pre>'; var_dump($_POST);  echo '</pre>';

  if($_SERVER['REQUEST_METHOD'] == "POST"){
    //   username testing
    if(empty(trim($_POST["username"]))){
        $username_err="Please enter a Username";
    }else{
        $sql = "SELECT id FROM users WHERE username=? ";

        if( $stmt = $link->prepare($sql) ){

            $stmt->bind_param("s", $param_username);

            $param_username = trim($_POST["username"]);

            if( $stmt->execute()){
                $stmt->store_result();

                if($stmt->num_rows == 1 ){
                    $username_err = "This username is already taken";
                }else{
                    $username = trim($_POST["username"]);
                }
            }else{
                echo "Something Went wrong.";
            }

            $stmt->close();
        }
    }

      // Validate password
      if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){

        $sql = "INSERT INTO users(username, password) VALUES (?, ?)";

        if( $stmt = $link->prepare($sql)){
            
            $stmt->bind_param("ss", $param_username, $param_password);

            $param_username = htmlspecialchars(trim($_POST['username']));
            $param_password = password_hash(htmlspecialchars(trim($_POST['password'])), PASSWORD_DEFAULT);

            if($stmt->execute()){
                header("location: login.php");
            }else{
                echo "Something went wrong. Please try again later";
            }

            $stmt->close();
        }
    }


  }

  $link->close();
?>

<!doctype html>
<html lang="en">
  <head>
    <title>Register</title>
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
                <h4>Registration Form</h4>
            </div>
            <div class="card-body mx-auto text-center">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  method="post">
                <div class="form-group">
                <input type="text" name="username" placeholder="User Name" class="form-control <?php echo (!empty($username_err)) ? 'border border-danger' : ''; ?>" id="username">
                <span class="text-danger"><?php echo $username_err; ?></span>
                </div>
                <div class="form-group">
                <input type="password" name="password" id="password" placeholder="Password" class="form-control <?php echo (!empty($password_err)) ? 'border border-danger' : ''; ?>">
                <span class="text-danger"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group">
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" class="form-control  <?php echo (!empty($confirm_password_err)) ? 'border border-danger' : ''; ?>">
                <span class="text-danger"><?php echo $confirm_password_err; ?></span>

                </div>
                <input type="submit" value="Register" class="btn btn-primary">
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