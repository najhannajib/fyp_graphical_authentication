<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = $reset_password = $img1 ="";
$username_err = $password_err = $confirm_password_err = $reset_password_err = $image_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
        alert($username_err);
        echo"<script>window.location.href='register.php'</script>";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                    alert($username_err);
                    echo"<script>window.location.href='register.php'</script>";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
        alert($password_err);
        echo"<script>window.location.href='register.php'</script>";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
        alert($password_err);
        echo"<script>window.location.href='register.php'</script>";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";
        alert($confirm_password_err);
        echo"<script>window.location.href='register.php'</script>";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
            alert($confirm_password_err);
            echo"<script>window.location.href='register.php'</script>";
        }
    }

    //check gambar
    if(empty(trim(implode(" ", $_POST["image1"])))){
        $image_err = "Please choose image";   
        alert($image_err);
        echo"<script>window.location.href='register.php'</script>";
        //header("location: register.php");
    } else{
        $process = implode(" ", $_POST["image1"]);
        }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($image_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password, image,clickpoint) VALUES (?, ?, ?, ?)";

 //   alert($sql);
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_username, $param_password, $img1, $cp);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_process = implode(" ", $_POST["image1"]);
            $img1 = trim($param_process);
            $cp = $_POST["cp"];

            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: passpoint2.php?name=".$username);
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
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
    <title>Sign Up</title>
    <link rel="stylesheet" href="style1.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px;  }
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
<table style="margin: auto; margin-top:50px;">
<tr>
<td>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        
        <form name="myRegForm" action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" onsubmit="return validateRegForm()" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>" required>
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Min 6-character" value="<?php echo $password; ?>" minlength="6" required>
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>" minlength="6" required>
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <h3>  </h3>

            <h4>For Reset Password Authentication</h4>
            <input type="radio" id="satu" name="gender" onclick="if(this.checked){ limiter()} document.getElementById('clickpoint').value=id;" required>
            <label for="male">1 image, 8 click</label><br>
            <input type="radio" id="dua" name="gender" onclick="if(this.checked){limiter()}document.getElementById('clickpoint').value=id;" required>
            <label for="female">2 image, 4 click</label><br>
            <input type="radio" id="empat" name="gender" onclick="if(this.checked){ limiter()}document.getElementById('clickpoint').value=id;" required>
            <label for="other">4 image, 2 click</label>
            <h3>  </h3>
</td>
<td style="width:50px;">
</td>
<td>
            <div id="checkboxes" class="form-group">
                
                <label for="image1">Choose image:</label>
                <table>
                    <?php // Using database connection file here
                        $records = mysqli_query($link,"select * from image");  // Use select query here 

                        $count =0;

                        while($data = mysqli_fetch_array($records))
                        {
                            $kira =0;
                            if($count ==0){
                                echo "<tr>"; 
                            }
                            echo "<td>";

                            echo "
                            <input class='c_list[]' type='checkbox' id='". $data['img_id'] ."' name='image1[]' value='". $data['img_id'] ."'>
                            <label for='". $data['img_id'] ."'>
                                <img src='" . $data['image'] ."' width='150' height='150'>
                            </label>
                            </td>";
                            $count++;
                            $kira++;
                            if($count ==3)
                            {
                             echo "</tr>";
                             $count = 0; 
                            } 
                            
                            
                        }
                    ?> 
                </table>
            </div>
</td>
</tr>
<tr>
<td>
            <div class="form-group">
            <input type="hidden" id="clickpoint" name="cp" />
                <input type="submit" class="btn btn-primary" value="Next">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>
</td>
</tr>   
</table>
    <script type="text/javascript">
function validateRegForm() {

    if(document.getElementById("satu").checked){
                var limit = 1;
    }
    else if(document.getElementById("dua").checked){
        var limit = 2;
    }
    else if(document.getElementById("empat").checked){
        var limit = 4;
    }

    var x = document.getElementsByClassName("c_list[]");
    console.log(x.length);
    var i;
    var count =0;

    for(i=0;i<x.length;i++){
        if(x[i].checked)
        {count++;}
    }
    
    if(count == 0){
        alert('Choose Image');
        return false;
    }
    else if(count>0 && count<limit){alert('Choose '+limit +' images');clear();return false;}

}
    function limiter(str) {
       

        if(document.getElementById("satu").checked){
                var limit = 1;
            }
            else if(document.getElementById("dua").checked){
                var limit = 2;
            }
            else if(document.getElementById("empat").checked){
                var limit = 4;
            }
        //alert('here');
        //var checkboxgroup = document.getElementById('checkboxes').getElementsByTagName("input");
        var checkboxgroup = document.getElementsByClassName('c_list[]');
        //var limit = 3;
        
        for (var i = 0; i < checkboxgroup.length; i++) {
            checkboxgroup[i].onclick = function() {
                var checkedcount = 0;
                    for (var i = 0; i < checkboxgroup.length; i++) {
                    checkedcount += (checkboxgroup[i].checked) ? 1 : 0;
                }
                if (checkedcount > limit) {
                    console.log("You can select maximum of " + limit + " checkbox.");
                    clear();
                    alert("You can select maximum of " + limit + " image(s)");
                    this.checked = false;
                }
            }
        }
        
    }

    function clear(){
        var checkboxgroup = document.getElementsByClassName('c_list[]');
        //var limit = 3;
        
        for (var j = 0; j < checkboxgroup.length; j++) {
            checkboxgroup[j].checked = false;
        }
    }
    </script>
</body>
</html>