<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $image2 = $image1 =  "";
$username_err =  $image1_err = $image2_err ="";

$verify = false;


 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(isset($_POST["username"])){
        $username = ($_POST["username"]);
        
    } else{
        $username_err = "Please enter username.";
    }

    if(isset($_POST["image1"])){
        $process = implode(" ", $_POST["image1"]);
        $image1 = trim($process);
    } else{
        
        $image1_err = "Please choose image 1.";
    }
    
    // Validate credentials
    if(empty($username_err) && empty($image1_err)){
        // Prepare a select statement
        $records = mysqli_query($link,"select * from users WHERE username = '$username'");

        while($data = mysqli_fetch_array($records))
        {
            if(($data['image'] == $image1)){
                $verify = true;
            }
        }	
    }

    //echo "verify ".$verify;

    if($verify == true){
        $_SESSION["username"] = $username; 
        alert("Image matched");
        PRINT <<<sini
        <script>window.location.href='verifypp1.php?name=$username'</script>
        sini;
        exit;
    }else{
        alert("Image not matched!");
        PRINT <<<sini
        <script>window.location.href='reset.php'</script>
        sini;
        //echo "Penipu";
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="logonn.png" type="image">
    <title>Reset Password</title>
    <link rel="stylesheet" href="style1.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 640px; padding: 20px; margin: auto;}

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
    <div class="wrapper">
        <h2>Reset Password Authentication</h2>
        <p>Please fill in your details to continue rest password.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" style="width: 300px;">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div> 
            <div id="checkboxes" class="form-group">
                <h4>For Reset Password</h4>
                <label for="image1">Choose Image</label>
                <table >
                    <?php // Using database connection file here
                        $records = mysqli_query($link,"select * from image");  // Use select query here 

                        $count =0;
                        
                            

                        while($data = mysqli_fetch_array($records))
                        {
                            if($count ==0){
                                echo "<tr>"; 
                            }
                            echo "<td>";

                            echo "
                            <input type='checkbox' id='". $data['img_id'] ."' name='image1[]' value='". $data['img_id'] ."'>
                            <label for='". $data['img_id'] ."'>
                                <img src='" . $data['image'] ."' width='200' height='200'>
                            </label>
                            </td>";
                            $count++;
                            if($count ==3)
                            {
                             echo "</tr>";
                             $count = 0; 
                            } 
                            
                            
                        }
                        
                        
                    ?> 
                </table>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Next">  
            </div>
            <p><a href="login.php">back</a></p>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>    
</body>
</html>