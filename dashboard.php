<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "config/pdodb.php";
// require_once "config/DBclass.php";

// $link = new DBClass("localhost", "root", "", "loginsystem");

// var_dump($link);
$title = $name = $salary= $msg= "";
$title_err = $name_err = $salary_err= "";
 
if($_SERVER['REQUEST_METHOD'] == "POST"){

  $title = $_POST['title'];
  $name = $_POST['name'];
  $salary = $_POST['salary'];

  $sql = "INSERT INTO data (`title`, `name`, `salary`) 
          VALUES (:title, :name, :salary)";

  if( $stmt = $link->prepare($sql) ){

    $stmt->bindParam(":title", $param_title, PDO::PARAM_STR);
    $stmt->bindParam(":name", $param_name, PDO::PARAM_STR);
    $stmt->bindParam(":salary", $param_salary, PDO::PARAM_STR);

    $param_title =$title;
    $param_name =$name;
    $param_salary =$salary;

    if($stmt->execute()){
      $msg ="Data inserted successfully";
    }else{
      $msg="Something is wrong try later";
    }

    unset($stmt);
  }
  
  unset($link);
}


?>

<!doctype html>
<html lang="en">
  <head>
    <title>Dashboard</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
  </head>
  <body>
      <header class="container-fluid">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Features</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Pricing</a>
      </li>
    
    </ul>
  </div>
</nav> 
      </header>
      <div class="jumbotron text-center">
        <h1><?php echo $_SESSION["username"]; ?></h1>
      </div>
      <div class="container"> 
      <div class="row">
        <div class="col-md-6">
         <form style="width:300px" action="" method="post">
         <div class="form-group">
            <input type="text" name="title" placeholder="Title" class="form-control"><br/>
            <input type="text" name="name" placeholder="Name" class="form-control"><br/>
            <input type="text" name="salary" placeholder="Salary" class="form-control"><br/>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
         </div>
         
         </form>
        
        
        
        </div>
        <div class="col-md-6">
        
          
        <?php
         try{

          $sql ="SELECT * FROM `data`";
          $res= $link->query($sql);
          if($res->rowCount()>0){
?>
       <table class="table" id="mytable">
       <thead>
          <tr>
            <th>S.No</th>
            <th>Title</th>
            <th>Name</th>
            <th>Salary</th>
          </tr>
       </thead>
        <tbody>
<?php 
          while($row = $res->fetch()): 
?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['salary']; ?></td>
        </tr>
<?php
         endwhile;
         echo "</tbody></table>";
          }else{
            echo "<p>No record Found.</p>";
          }          
         }catch(Exception $e){
          die("ERROR: Could not able to execute $sql. " . $e->getMessage());
        }
      
        ?>    
        </div>
      </div>
    </div>  
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" integrity="sha512-+NqPlbbtM1QqiK8ZAo4Yrj2c4lNQoGv8P79DPtKzj++l5jnN39rHA/xsqn8zE9l0uSoxaCdrOgFs6yjyfbBxSg==" crossorigin="anonymous"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready( function () {
    $('#mytable').DataTable();
} );
    
    </script>
  </body>
</html>