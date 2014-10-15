include_once 'include/db.php';
//creating new db object
$db = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
 
//checking the connection to the db before user tries to add a new user
if($db -> connect_errno > 0){
                //setting the global variable to the error message
                $GLOBALS['Error'] = 'Unable to connect to database ['.$db->connect_error.']';   
}
                
function displayImages($db){
 
                $sql = "SELECT animal_ID FROM tbl_Animals ORDER BY animal_ID DESC LIMIT 1";
                $startAnimalID = $db->query($sql)->fetch_row()[0];
                
                for($count = 0;$count<=11;$count++){
                                $sql = "SELECT animal_Image FROM tbl_Animals WHERE animal_ID = $startAnimalID";
                                $imgArr[$count] = $db->query($sql)->fetch_row()[0];
                                $startAnimalID--;
                }
                
                echo"<div class=\"container\" id=\"pics\">";                                                      
                echo"<div class=\"post-box col-lg-3 col-md-3 col-xs-4\"> <img class=\"img-responsive img-thumbnail\"src='data:image/jpg;base64," . base64_encode($imgArr[0]) . "' alt = 'image'/></div>";
                echo"<div class=\"post-box col-lg-3 col-md-3 col-xs-4\"> <img class=\"img-responsive img-thumbnail\"src='data:image/jpg;base64," . base64_encode($imgArr[1]) . "' alt = 'image'/></div>";
                echo"<div class=\"post-box col-lg-3 col-md-3 col-xs-4\"> <img class=\"img-responsive img-thumbnail\"src='data:image/jpg;base64," . base64_encode($imgArr[2]) . "' alt = 'image'/></div>";
                
                echo"<div class=\"post-box col-lg-3 col-md-3 col-xs-4\"> <img class=\"img-responsive img-thumbnail\"src='data:image/jpg;base64," . base64_encode($imgArr[3]) . "' alt = 'image'/></div>";
                echo"<div class=\"post-box col-lg-3 col-md-3 col-xs-4\"> <img class=\"img-responsive img-thumbnail\"src='data:image/jpg;base64," . base64_encode($imgArr[4]) . "' alt = 'image'/></div>";
                echo"<div class=\"post-box col-lg-3 col-md-3 col-xs-4\"> <img class=\"img-responsive img-thumbnail\"src='data:image/jpg;base64," . base64_encode($imgArr[5]) . "' alt = 'image'/></div>";
                
                echo"<div class=\"post-box col-lg-3 col-md-3 col-xs-4\"> <img class=\"img-responsive img-thumbnail\"src='data:image/jpg;base64," . base64_encode($imgArr[6]) . "' alt = 'image'/></div>";
                echo"<div class=\"post-box col-lg-3 col-md-3 col-xs-4\"> <img class=\"img-responsive img-thumbnail\"src='data:image/jpg;base64," . base64_encode($imgArr[7]) . "' alt = 'image'/></div>";
                echo"<div class=\"post-box col-lg-3 col-md-3 col-xs-4\"> <img class=\"img-responsive img-thumbnail\"src='data:image/jpg;base64," . base64_encode($imgArr[8]) . "' alt = 'image'/></div>";
                
                echo"<div class=\"post-box col-lg-3 col-md-3 col-xs-4\"> <img class=\"img-responsive img-thumbnail\"src='data:image/jpg;base64," . base64_encode($imgArr[9]) . "' alt = 'image'/></div>";
                echo"<div class=\"post-box col-lg-3 col-md-3 col-xs-4\"> <img class=\"img-responsive img-thumbnail\"src='data:image/jpg;base64," . base64_encode($imgArr[10]) . "' alt = 'image'/></div>";
                echo"<div class=\"post-box col-lg-3 col-md-3 col-xs-4\"> <img class=\"img-responsive img-thumbnail\"src='data:image/jpg;base64," . base64_encode($imgArr[11]) . "' alt = 'image'/></div>";
                echo"</div>";
}
                                                
 
?>
<!DOCTYPE PUBLIC>
<html>
                <head>
                                <title>Animal Management</title>
                                <link rel="stylesheet" href="css/bootstrap.min.css">
                                <link rel="stylesheet" href="css/mycss.css">
                                <link rel="stylesheet" href="css/mycss.css">
                                                <link rel="icon" 
                  type="image/ico" 
                  href="images/favicon.ico">
                <head/>
                <body>
                                <div class="container">
                                                <div class="jumbotron">
                                                                <img src="images/aacl.png" alt="" class="pic image-responsive" align="left">
                                                                <h1>Animal Anti-Cruelty League</h1>
                                                                <h5>Est. 1956</h5>                                                        
                                                </div>
<!----------------------------------------------------------//ROW//---------------------------------------------------------------------------------->
                                
                                                <div class="row">
                                                                <div class="col-xs-12 col-md-12"> 
                                                                                <ul class="nav nav-tabs" data-tabs="tabs" >
                                                                                                <li class="active" data-toggle="tab"><a href="home.php" >Home</a></li>                                                                                
                                                                                                <li><a href="animals.php">Animals</a></li>
                                                                                                <li><a href="qrcode.php">QR Codes</a></li>
                                                                                                <li><a href="users.php">Users</a></li>
                                                                                                <li><a href="inspectors.php">Inspectors</a></li>
                                                                                                <li><a href="reportsd.php">Reports</a></li>
                                                                                </ul> 
                                                                </div>                                                                   
                                                </div>   
<!----------------------------------------------------------//ROW//---------------------------------------------------------------------------------->
                                                <div class="row">                                                            
                                                                <div class="col-xs-3 col-md-4">
                                                                </div>
                                                                <div class="col-xs-6 col-md-3">
                                                                                <h2>Welcome</h2>                                                                      
                                                                </div>                                                   
                                                </div>
                                                <div class="row">            
                                                <div class="col-xs-2 col-md-2">
                                                                </div>                                   
                                                                <div class="col-xs-12 col-md-7">
                                                                                <p class="colour" align="center"> These were the last 12 animals entered into or updated on the Animal Management System Database.</p>
                                                                </div>
                                                </div>
<!----------------------------------------------------------//ROW//---------------------------------------------------------------------------------->       
<?php
displayImages($db);
?>           
                
                                </div>
                </body>
</html>
 
