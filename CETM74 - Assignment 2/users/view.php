<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["active"]) || $_SESSION["active"] !== true || $_SESSION["type"] !=="user" ){
    header("location: index.php");
    exit;
}
$userid = $_SESSION["id"];
$fullName = $_SESSION["fullName"];
//$tickets = "<div class='row' style='text-align:center'>No record found</div><div><br/></div>";

// Include database connection file
require_once "../config/connect.php";

$query = mysqli_query($conn, "SELECT * FROM case_tbl WHERE caseid > '1000' AND userId = '$userid'");

 while ($row = mysqli_fetch_assoc($query)) {     
   $tickets .="<div class='row'><div style='padding: 20px'; class='col-lg-6'><p class='text-bold'><a href='edit.php?cid=".$row["caseid"]."'>".$row["caseSub"]."</a></p><p>Last Updated on: ".$row["lastUpdationDate"]."</p></div><div style='padding: 20px; text-align: center;margin-top: 15px;' class='col-lg-2 '><button type='button' class='btn btn-default'>".$row["statu"]."</button></div></div></div><div><br/></div>";
     
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

    <section id="container" style="margin-top: 50px; margin-left: 320px; margin-right: 100px;">
        <section id="main-content">
            <section class="wrapper">



            <div style="margin-top: 50px;" class="container ticket-box">

<?php echo $tickets; ?>




                </section>
            </section>
        </section>
        
    
    </form>
    <!-- jQuery -->
    <script src="../jscript/jquery.js"></script>
    
    <!-- Bootstrap Core JavaScript -->
    <script src="../jscript/bootstrap.min.js"></script>

    <script src="myscript.js"></script>
</body>

</html>