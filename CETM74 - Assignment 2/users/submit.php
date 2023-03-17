<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["active"]) || $_SESSION["active"] !== true || $_SESSION["type"] !=="user" ){
    header("location: index.php");
    exit;
}
$notification = ""; 
$fullName = $_SESSION["fullName"];
$userid = $_SESSION["id"];

// Include database connection file
require_once "../config/connect.php";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $category =  trim($_POST["category"]);
    $subcategory =  trim($_POST["subcategory"]);
    $location =  trim($_POST["location"]);
    $priority =  trim($_POST["priority"]);
    $casesub =  trim($_POST["subject"]);
    $casedesc =  trim($_POST["description"]);
        // Prepare an insert statement
        $sql = "INSERT INTO case_tbl (userid,category,subcategory,loc,priority,casesub,casedesc) VALUES (?, ?, ?, ?, ?, ?, ?)";
        if($stmt = mysqli_prepare($conn, $sql)){
            
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssss", $userid, $category, $subcategory, $location, $priority, $casesub, $casedesc);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $notification = "<div class='success-box' style='text-align:center'> Case submitted successfully</div>";

            } else{
                $notification = "<div class='error-box' style='text-align:center'> Oops! Something went wrong. Please try again later.</div>";
            }

            // Close statement
            mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($conn);
}
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
                    <a href="index.php">User Login</a>
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
				<li><a href="submit.php">Report a Case</a></li>
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
                                <input type="text" name="name" required="required" value="<?php echo $fullName?>" required="" disabled class="form-control">
                            </div>
                        
                            <label class="col-sm-2 col-sm-2 control-label">Category</label>
                            <div class="col-sm-4">
                                <select name="category" id="category" class="form-control" required="">
                                    <option value="" disabled selected hidden>Select Category</option>
                                    <option value="Software">Software</option>
                                    <option value="Hardware">Hardware</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                        </div>
                        

                        <div class="form-group">
                            
                            <label class="col-sm-2 col-sm-2 control-label">Location</label>
                            <div class="col-sm-4">
                                <select name="location" required="required" class="form-control">
                                    <option value="" disabled selected hidden>Select Location</option>
                                    <option value="GR-7">Grade 7</option>
                                    <option value="GR-8"> Grade 8</option>
                                    <option value="GR-9">Grade 9</option>
                                    <option value="GR-10"> Grade 10</option>
                                    <option value="GR-11">Grade 11</option>
                                    <option value="GR-12"> Grade 12</option>
                                </select>
                            </div>

                            <label class="col-sm-2 col-sm-2 control-label">Sub Category </label>
                            <div class="col-sm-4">
                                <select name="subcategory" id="subcategory" class="form-control">
                                    <option value="" disabled selected hidden>Select Subcategory</option>
                                    <option value="MS Word">MS Word</option>
                                    <option value="Moodle">Moodle</option>
                                    <option value="Email">Email</option>
                                    <option value="Projector">Projector</option>
                                    <option value="Computer">Computer</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                        </div>
          
                    
                    
                    
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Subject</label>
                            <div class="col-sm-4">
                                <input type="text" name="subject" required="required" value="" required="" class="form-control">
                            </div>

                            <label class="col-sm-2 col-sm-2 control-label">Priority</label>
                            <div class="col-sm-4">
                                <select name="priority" class="form-control" required="">
                                    <option value="" disabled selected hidden>Select Priority</option>
                                    <option value=" Critical"> Critical</option>
                                    <option value="Normal">Normal</option>
                                    <option value="Low"> Low</option>
                                </select>
                            </div>
                    
                            
                        </div>
                    
                    
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Description </label>
                            <div class="col-sm-5">
                                <textarea name="description" required="required" cols="10" rows="10" class="form-control"
                                    maxlength="2000" style="resize: none;"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Attachment </label>
                            <div class="col-sm-5">
                                <input type="file" name="compfile" class="form-control" value="">
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