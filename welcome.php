<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
$username =$_GET['name'];
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="style1.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
        /* width */
        ::-webkit-scrollbar {
          width: 10px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
          background: inset 0 0 5px grey; 
          border-radius: 10px;
        }
        
        /* Handle */
        ::-webkit-scrollbar-thumb {
          background: #da6827; 
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
          background: #ae531e; 
        }
    </style>
</head>
<body>
    <div class="page-header">
    <img src="image\logonn.png" alt="logo" width="150" height="150">
        <h1>Congrats, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. You successfully finished the user testing!</h1>
    </div>
    <p>
        <h4>This is a project about password reset authentication using graphical method by Najhan Najib for final year project.
            <br>Thank you for your cooperation.
            <br>We really appreciate your feedback in the <a href="https://forms.gle/kn9PYSAXDtLPSYRo8">feedback form</a> provided.
            <br> 
        </h4>
        <h4><br></h4>
        <a href="resetafterlogin.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
        <h4><br></h4>
        <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSdBEA38b766OkT5rOtrL4CDyByKmrnCECj0JABVcTdXlRSCIQ/viewform?embedded=true" width="640" height="2700" frameborder="0" marginheight="0" marginwidth="0">Loading…</iframe>
    </p>
</body>
</html>