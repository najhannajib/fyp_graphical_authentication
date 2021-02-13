<?Php
// Initialize the session
session_start();
// Include config file
require_once "config.php";
$username = $_REQUEST['name'];
$dbpoints="";
$uuu = '';
$uuu= rand();

//echo $uuu;
$sql = "UPDATE users SET random = '$uuu' WHERE username = '$username'";
            $run=mysqli_query($link, $sql);
//echo $username;

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $sql = "select * from users where username='".$username."'";
    $records = mysqli_query($link,$sql);  // Use select query here 
            //echo $sql;
    while($data = mysqli_fetch_array($records))
    {$id=$data['id'];
        $pp1=$data['pp1'];
        $pp2=$data['pp2'];
        $pp3=$data['pp3'];
        $pp4=$data['pp4'];
    }

    $dbpoints .= $pp1;

    //$upoints .= $pp1."||".$pp2."||".$pp3."||".$pp4;
    if($pp2 != ""){
        $dbpoints .= "||".$pp2;
        if($pp3 != ""){
            $dbpoints .= "||".$pp3;
            if($pp4 != ""){
                $dbpoints .= "||".$pp4;
            }
        }
    }

    $arrayPoint = array();
    $num = 0;
    $user = "user".$num;
    while(isset($_POST[$user])){
        $input = $_POST[$user];
        array_push($arrayPoint, $input);
        $num++;
        $user = "user".$num;
    }

    $upoints = implode("||", $arrayPoint); 
    
    print <<<HERE
    <script src="passpoint.js"></script>
    <script type="text/javascript">
    
    check('$dbpoints','$upoints','$username','$uuu');
    </script>
    HERE;

    //alert("RUN");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="logonn.png" type="image">
    <link rel="icon" href="logonn.png" type="image">
    <title>Reset Password</title>
    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 100%; margin-left: 50px; height: 600px; }
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
        .mySlides {display:none; cursor: crosshair;}

        
div.clickEffect{
	position:fixed;
	box-sizing:border-box;
	border-style:solid;
	border-color:#000000;
	border-radius:50%;
	animation:clickEffect 0.4s ease-out;
	z-index:99999;
    cursor: crosshair;
}
@keyframes clickEffect{
	0%{
		opacity:1;
		width:0.5em; height:0.5em;
		margin:-0.25em;
		border-width:0.5rem;
	}
	100%{
		opacity:0.2;
		width:15em; height:15em;
		margin:-7.5em;
		border-width:0.03rem;
	}
}

    </style>
</head>
<body>
<form name="myForm" action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" onsubmit="return validateForm()" method="post">
    
    <div class="wrapper">
        <h2>Click-based Image Authentication</h2>
        <p>Please click on the image.</p>
        <div class="w3-content w3-display-container" id="pointerr" style="height: 100%">
        <div class="w3-display-middle">
        <?php 
            $sql = "select * from users where username='".$username."'";
            $records = mysqli_query($link,$sql);  // Use select query here 
            //echo $sql;
                            while($data = mysqli_fetch_array($records))
                            {$id=$data['id'];
                                $img=$data['image'];
                                $cp = $data['clickpoint'];
                            }
            $imgArr = explode(" ", $img);

            for($i=0;$i<count($imgArr);$i++){
                $sql = "select * from image where img_id='".$imgArr[$i]."'";
                $records = mysqli_query($link,$sql);  // Use select query here 
                //echo $sql;
                
                while($data = mysqli_fetch_array($records))
                {$imgbetul=$data['image'];}
                echo '<img class="mySlides" src="'.$imgbetul.'" width="500" height="500" onClick="trigger(event, '.$i.')" />';

                echo '
                <input id="user'.$i.'" type="hidden" name="user'.$i.'" class="user"  />
                ';
            }
            ?>
            </div>

            <button type="button" class="w3-button w3-black w3-display-left" onclick="plusDivs(-1)">&#10094;</button>
            <button type="button" class="w3-button w3-black w3-display-right" onclick="plusDivs(1)">&#10095;</button>
            <input type="hidden" value="'.$username.'"/>
            <input type="hidden" id="cp2" value="<?php echo $cp; ?>"/>
                <div class="form-group w3-display-bottommiddle">
                    <input type="submit" class="btn btn-primary" value="Submit" name="submit" />
                </div>
        </div>
              
        </form>
    </div>
    
    <!--<button type="button" onclick="check()">CLickMe</button> -->
    <script src="passpoint.js"></script>

        <script>
var slideIndex = 1;
showDivs(slideIndex);

function plusDivs(n) {
  showDivs(slideIndex += n);
}

function showDivs(n) {
  var i;
  var x = document.getElementsByClassName("mySlides");
  if (n > x.length) {slideIndex = 1}
  if (n < 1) {slideIndex = x.length}
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  x[slideIndex-1].style.display = "block";  
}

function clickEffect(e){
	var d=document.createElement("div");
	//var d=document.getElementById("test");
	d.className="clickEffect";
	d.style.top=e.clientY+"px";d.style.left=e.clientX+"px";
	document.body.appendChild(d);
	d.addEventListener('animationend',function(){d.parentElement.removeChild(d);}.bind(this));
}
document.getElementById("pointerr").addEventListener('click',clickEffect);
</script>

</body>
</html>