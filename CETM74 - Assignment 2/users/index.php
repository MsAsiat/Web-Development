<?php
// Initialize the session to managed logged in user
session_start();
 
// Redirect user to submit.php if user is already logged in
if(isset($_SESSION["active"]) && $_SESSION["active"] === true  && $_SESSION["type"] ==="user"){
    header("location: submit.php");
    exit;
}
 
// Include database connection file
require_once "../config/connect.php";
 
// Declare the PHP variables for authentication
$username = $password = "";
$login_err = ""; 

// Pass the login form values into variables
if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);
   
    
    // Validate login credentials
    if(isset($username) && isset($password)){

        // Prepare the SQL select query statement
        $sql = "SELECT id, fullName, username, password FROM users_tbl WHERE username = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared query statement
            if(mysqli_stmt_execute($stmt)){
                // Retrieve the query result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){    

                    // Bind query result variables
                    mysqli_stmt_bind_result($stmt, $id, $fullName, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["active"] = true;
                            $_SESSION["type"] = "user";
                            $_SESSION["id"] = $id;
                            $_SESSION["fullName"] = $fullName;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to submit.php page
                            header("location: submit.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "<div class='error-box' style='text-align:center'> Invalid username or password.</div>";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "<div class='error-box' style='text-align:center'> Invalid username or password.</div>";
                }
            } else{
                $login_err = "<div class='error-box' style='text-align:center'> Oops! Something went wrong. Please try again later.</div>";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
}
// Close connection
mysqli_close($conn);
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WearView IT Complaint Desk</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/half-slider.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/mystyle.css">
   
</head>

<!-- Navigation -->
<nav class="navbar navbar-inverse " role="navigation">
    <div class="container">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="../index.html"><img src="../img/logo.jpg" width="70" height="70" alt=""/></a>
        </div>
        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href="index.php">User Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<body>

    <div class="container col-lg-12 block">
    
        <div class="row col-xs-6 block2 center">
    
            <form method="post" action="" class="form-horizontal" role="form" align="center">
                <div class="form-group">
                    <label class="control-label col-sm-3" for="username">Username</label>
                    <div class="col-sm-8 col-xs-12">
                        <input type="text" name="username" id="username" placeholder="Username" required="true"
                            class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="password">Password</label>
                    <div class="col-sm-8 col-xs-12">
                        <input type="password" name="password" id="password" required="true" placeholder="Password" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-8">
                        <input type="submit" name="signin" id="signin" value="Sign in" class="btn btn-default" />
                        
                    </div>
                </div>
            </form>
            <?php echo  $login_err;?>
        </div>
    
    </div><!-- /.container -->


    <!-- Footer -->
    <footer class="site-footer">
        <div class="text-center">
            2021 - WearView Academy
            <a href="#" class="go-top">
                <i class="fa fa-angle-up"></i>
            </a>
        </div>
    
    </footer>
    
    </div>
    
    
    <!-- jQuery -->
    <script src="../jscript/jquery.js"></script>
    
    <!-- Bootstrap Core JavaScript -->
    <script src="../jscript/bootstrap.min.js"></script>

</body>

</html>