<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["active"]) || $_SESSION["active"] !== true || $_SESSION["type"] !=="admin" ){
    header("location: index.php");
    exit;
}
$notification = ""; 
$fullName = $_SESSION["fullName"];
$userid = $_SESSION["id"];
$cid = "";
$clientid = $clientname = $userName = $category = $subcategory = $loc = $priority = $casesub = $casedesc = $status ="";
// Include database connection file
require_once "../config/connect.php";
 




if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET["cid"]) && isset($_POST["status"])){
    $cid =  trim($_GET["cid"]);

        // Prepare an insert statement
       $sql = "SELECT userid,category,subcategory,loc,priority,casesub,casedesc,statu FROM case_tbl WHERE caseid = ?";

       if($stmt = mysqli_prepare($conn, $sql)){

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $cid);

            // Attempt to execute the prepared query statement
            if(mysqli_stmt_execute($stmt)){
            
            // Retrieve the query result
            mysqli_stmt_store_result($stmt);
                
            // Check if username exists, if yes then verify password
            if(mysqli_stmt_num_rows($stmt) == 1){    

            // Bind query result variables
            mysqli_stmt_bind_result($stmt, $clientid, $category, $subcategory, $loc, $priority, $casesub, $casedesc, $status);
            mysqli_stmt_fetch($stmt);

        $sql2 = "SELECT fullName FROM users_tbl WHERE id = ?";

        if($stmt2 = mysqli_prepare($conn, $sql2)){
               // Bind variables to the prepared statement as parameters
               mysqli_stmt_bind_param($stmt2, "s", $clientid);
     
              // Attempt to execute the prepared query statement
               if(mysqli_stmt_execute($stmt2)){
                 
              // Retrieve the query result
              mysqli_stmt_store_result($stmt2);
                     
                 // Check if username exists, if yes then verify password
                 if(mysqli_stmt_num_rows($stmt2) == 1){    
     
                 // Bind query result variables
                 mysqli_stmt_bind_result($stmt2, $clientname);
                 mysqli_stmt_fetch($stmt2);
                 }
                }
            }
            
            $status = $_POST["status"]; 
            $sql3 = "UPDATE case_tbl SET statu = ? WHERE caseid = ?";
                    if($stmt3 = mysqli_prepare($conn, $sql3)){
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt3, "si", $status, $cid);
                            
                              
                    // Attempt to execute the prepared statement
                    if(mysqli_stmt_execute($stmt3)){
                        $notification = "<div class='success-box' style='text-align:center'> Case status has been updated successfully</div>";
                    } else{
                        $notification = "<div class='error-box' style='text-align:center'> Oops! Something went wrong. Please try again later.</div>";
                    }
                }


        } else{
        $notification = "<div class='error-box' style='text-align:center'> Oops! Something went wrong. Please try again later.</div>";
}

// Close statements
mysqli_stmt_close($stmt2);
}
}
}










if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["cid"])){
    $cid =  trim($_GET["cid"]);

        // Prepare an insert statement
       $sql = "SELECT userid,category,subcategory,loc,priority,casesub,casedesc,statu FROM case_tbl WHERE caseid = ?";

       if($stmt = mysqli_prepare($conn, $sql)){

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $cid);

            // Attempt to execute the prepared query statement
            if(mysqli_stmt_execute($stmt)){
            
            // Retrieve the query result
            mysqli_stmt_store_result($stmt);
                
            // Check if username exists, if yes then verify password
            if(mysqli_stmt_num_rows($stmt) == 1){    

            // Bind query result variables
            mysqli_stmt_bind_result($stmt, $clientid, $category, $subcategory, $loc, $priority, $casesub, $casedesc, $status);
            mysqli_stmt_fetch($stmt);

            $sql = "SELECT fullName FROM users_tbl WHERE id = ?";

            if($stmt = mysqli_prepare($conn, $sql)){
     
                 // Bind variables to the prepared statement as parameters
                 mysqli_stmt_bind_param($stmt, "s", $clientid);
     
                 // Attempt to execute the prepared query statement
                 if(mysqli_stmt_execute($stmt)){
                 
                 // Retrieve the query result
                 mysqli_stmt_store_result($stmt);
                     
                 // Check if username exists, if yes then verify password
                 if(mysqli_stmt_num_rows($stmt) == 1){    
     
                 // Bind query result variables
                 mysqli_stmt_bind_result($stmt, $clientname);
                 mysqli_stmt_fetch($stmt);
                 }
                }
            }

        } else{
        $notification = "<div class='error-box' style='text-align:center'> Oops! Something went wrong. Please try again later.</div>";
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
<body>
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
                    <a href="index.php">Admin Login</a>
                </li>

                <li>
                    <a href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<aside class="side-bar">
		<div class="container">
			<div style="text-align: center;"> 
				<img src="../img/user.png" width="128" height="128" alt=""/>
				<p><?php echo $fullName;?></p>
			
			</div>
		  <ul style="margin-top: 50px;">
				<li><a href="#">Account Settings</a></li>
				<li><a href="view.php">Case History</a></li>
			</ul>
		</div>
	</aside>
    


    <section id="container" style="margin-top: 50px; margin-left: 300px; margin-right: 100px;">
        <section id="main-content">
            <section class="wrapper">

                <form class="form-horizontal style-form" method="post" name="complaint">
                        
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label d-inline">Full Name</label>
                            <div class="col-sm-4">
                                <input type="text" name="name" required="required" value="<?php echo $clientname; ?>" required="" disabled class="form-control">
                            </div>
                        
                            <label class="col-sm-2 col-sm-2 control-label">Category</label>
                            <div class="col-sm-4">
                                <select name="category" disabled id="category" class="form-control">
                                <option value="" disabled selected hidden><?php echo $category; ?></option>
                                </select>
                            </div>
                        </div>
                        

                        <div class="form-group">
                            
                            <label class="col-sm-2 col-sm-2 control-label">Location</label>
                            <div class="col-sm-4">
                                <select name="location" disabled value="1" class="form-control">
                                    <option value="" disabled selected hidden><?php echo $loc; ?></option>
                                </select>
                            </div>

                            <label class="col-sm-2 col-sm-2 control-label">Sub Category </label>
                            <div class="col-sm-4">
                                <select name="subcategory" disabled id="subcategory" class="form-control">
                                    <option value="" disabled selected hidden><?php echo $subcategory; ?></option>
                                </select>
                            </div>
                        </div>
          
                    
                    
                    
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Subject</label>
                            <div class="col-sm-4">
                                <input type="text" name="subject" disabled required="" class="form-control" value="<?php echo $casesub; ?>">
                            </div>

                            <label class="col-sm-2 col-sm-2 control-label">Priority</label>
                            <div class="col-sm-4">
                                <select name="priority" disabled class="form-control" required="">
                                    <option value="" disabled selected hidden><?php echo $priority; ?></option>
                                </select>
                            </div>
                    
                            
                        </div>
                    
                    
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Description</label>
                            <div class="col-sm-5">
                                <textarea name="description" disabled cols="10" rows="10" class="form-control"
                                    maxlength="2000" style="resize: none;"><?php echo $casedesc; ?></textarea>
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Status </label>
                            <div class="col-sm-5">
                            <select name="status" class="form-control" required="">
                                    <option value="" disabled selected hidden><?php echo $status; ?></option>
                                    <option value="Open">Open</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Close">Close</option>
                                </select>
                            </div>
                        </div>
                    
                    
                        <div class="form-group">
                            <div class="col-sm-12 center" style="padding-left:50% ">
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </section>
            </section>
        </section>
        
    
    </form>
    <?php echo  $notification;?>
    <!-- jQuery -->
    <script src="../jscript/jquery.js"></script>
    
    <!-- Bootstrap Core JavaScript -->
    <script src="../jscript/bootstrap.min.js"></script>

    <script src="myscript.js"></script>
</body>

</html>