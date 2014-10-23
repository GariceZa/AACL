<?php
session_start();
//including the db connection variables
include_once 'include/db.php';

//creating new db object
$db = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);

//checking the connection to the db before user tries to add a new user
if($db -> connect_errno > 0){
	//setting the global variable to the error message
	$GLOBALS['Error'] = 'Unable to connect to database ['.$db->connect_error.']';
}

//if the user clicks adopt
if(isset($_POST['saveAdopter'])){
	if(!isset($_SESSION['animal_ID'])){
	$GLOBALS['Error'] = ' Animal ID not set, please search for an animal on the animal page and try again';
}
else{
	SaveAdopter($db);
}
}
function SaveAdopter($db){

//validating all fields have been set
if(empty($_POST['adptName']) OR empty($_POST['adptSname']) OR empty($_POST['adptrid']) OR empty($_POST['adptdate']) OR empty($_POST['telnum']) OR empty($_POST['cellnum']) OR empty($_POST['email']) OR empty($_POST['worknum']) OR empty($_POST['Addr'])){

	$GLOBALS['Error'] = ' Please fill in all adopter details';
}
else if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
		$GLOBALS['Error'] = ' Email address format is incorrect';
	}
else{
	//storing post data 
	$adopterName 	= $_POST['adptName'];
	$adopterSName 	= $_POST['adptSname'];
	$adopterID 		= $_POST['adptrid'];
	$adoptionDate 	= $_POST['adptdate'];
	$adopterTel 	= $_POST['telnum'];
	$adopterCell 	= $_POST['cellnum'];
	$adopterEmail 	= $_POST['email'];
	$adopterWorkTel = $_POST['worknum'];
	$adopterAddress = $_POST['Addr'];
	$animalID 		= $_SESSION['animal_ID'];
	
	$insertSQL = "INSERT INTO tbl_Adoptions VALUES('$adopterName','$adopterSName','$adopterID','$adopterAddress','$adopterTel','$adopterWorkTel','$adopterCell','$adopterEmail','$animalID',NULL,'$adoptionDate')";
	
	//runs the query and displays an error if the statement is unsuccessful
	if(!$result = $db->query($insertSQL)){
		$GLOBALS['Error'] = ' There was an error running the query['.$db->error.']';
	}
	//open the property inspection page
	else{
		$sql = "SELECT adoptions_ID FROM tbl_Adoptions WHERE animal_ID = '$animalID'";
		$_SESSION['adoption_ID'] = $db->query($sql)->fetch_row()[0];
		header('Location: inspection.php');
		//echo $_SESSION['adoption_ID'];
	}
	//close db connection
	$db->close();
}
} 

?>
<!DOCTYPE public>
<html>
<head>
	<!--Web browser tab title-->
	<title>About Animals</title>
	<!--Getting web styling from css file -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/mycss.css">
	<link rel="stylesheet" href="css/mycss.css">
			<link rel="icon" 
      	  type="image/ico" 
      	  href="images/favicon.ico">
</head>
<body>
		<!-- Displaying any system messages in an alert message -->
		<?php
		if(isset($GLOBALS['Error'])){
				echo "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">";
				echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\"><span aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span></button>";
				echo "<strong>Warning!</strong>".$GLOBALS['Error'];
				echo "</div>";
		}
		else if(isset($GLOBALS['Success'])){
				echo "<div class=\"alert alert-Success alert-dismissible\" role=\"alert\">";
				echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\"><span aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span></button>";
				echo "<strong>Success!</strong>".$GLOBALS['Success'];
				echo "</div>";
		}		
		?>
		<!-- end of alert message -->
	<!--Creates a border around entire web page-->
	<div class="container">
		<!--Bootstrap feature-->		
		<div class="jumbotron">
				<img src="images/aacl.png" alt="" class="pic image-responsive" align="left">
				<h1>Animal Anti-Cruelty League</h1>
				<h5>Est. 1956</h5>								
		</div>
		<!--Navigation bar across the top of the webpage-->
			<div class="row">
				<div class="col-md-12"> 
					<ul class="nav nav-tabs" data-tabs="tabs" >
			  			<li><a href="home.php">Home</a></li>		  			
				  		<li class="active" data-toggle="tab"><a href="animals.php">Animals</a></li>
				  		<li><a href="qrcode.php">QR Codes</a></li>
				  		<li><a href="users.php">Users</a></li>
				  		<li><a href="inspectors.php">Inspectors</a></li>
				  		<li><a href="reportsd.php">Reports</a></li>
					</ul> 
				</div> 					
			</div>

			<div class="row">				
				<div class="col-xs-12 col-md-12">
					<h2>Adoption Form</h2>					
				</div>				
			</div>
			
			<form action = "adopt.php" method = "post" name = "adopt_form" id = "adopt_form">	
			
			<div class="row">				
				<div class="col-xs-7 col-md-2">
					<p class="labels" title="Potential Owner's First Name">Adopter Name:</p>
				</div>
				<div class="col-xs-3 col-md-3">
					<input type="text" name="adptName" id="adptName" title="Potential Owner's First Name"
					value ="<?php
						if(isset($_POST['adptName'])){
							echo $_POST['adptName'];
						}
					?>"/>
				</div>				
				<div class="col-xs-7 col-md-2">
					<p class="labels" title="Potential Owner's Last Name">Adopter Surname:</p>
				</div>
				<div class="col-xs-3 col-md-3">
					<input type="text" name="adptSname" id="adptSname" title="Potential Owner's Last Name"
					value ="<?php
						if(isset($_POST['adptSname'])){
							echo $_POST['adptSname'];
						}
					?>"/>
				</div>				
				
			</div>

			<div class="row">							
				<div class="col-xs-7 col-md-2">
					</br><p class="labels" title="13 digits">Adopter's ID Number:</p>
				</div>
				<div class="col-xs-3 col-md-3">
					</br><input type="text" name="adptrid" id="adptrid" title="13 digits"value ="<?php
						if(isset($_POST['adptrid'])){
							echo $_POST['adptrid'];
						}
					?>"/>
				</div>	
				<div class="col-xs-7 col-md-2">
					</br><p class="labels" title="Date adoption initiated">Adoption Date:</p>
				</div>
				<div class="col-xs-3 col-md-3">
					</br><input type="date" name="adptdate" id="adptdate" title="Date adoption initiated" value ="<?php
						if(isset($_POST['adptdate'])){
							echo $_POST['adptdate'];
						}
					?>"/>
				</div>											
			</div>		

			<div class="row">
				<div class="col-xs-7 col-md-2">
					</br><p class="labels" title="Home contact number">Telephone:</p>
				</div>	
				<div class="col-xs-3 col-md-3">
					</br><input type="text" name="telnum" id="telnum" title="Home contact number" value ="<?php
						if(isset($_POST['telnum'])){
							echo $_POST['telnum'];
						}
					?>"/>
				</div>	
				<div class="col-xs-7 col-md-2">
					</br><p class="labels" title="Cellphone number">Mobile:</p>
				</div>	
				<div class="col-xs-3 col-md-2">
					</br><input type="text" name="cellnum" id="cellnum" title="Cellphone number" value ="<?php
						if(isset($_POST['cellnum'])){
							echo $_POST['cellnum'];
						}
					?>"/>
				</div>
			</div>		

			<div class="row">			
				<div class="col-xs-7 col-md-2">
						</br><p class="labels" title="Potential owner's email details">Email:</p>
				</div>
				<div class="col-xs-3 col-md-3">
					</br><input type="text" name="email" id="email" title="Potential owner's email details" value ="<?php
						if(isset($_POST['email'])){
							echo $_POST['email'];
						}
					?>"/>
				</div>
				<div class="col-xs-7 col-md-2">
						</br><p class="labels" title="Potential owner's work contact details">Work Number:</p>
					</div>	
					<div class="col-xs-3 col-md-3">
						</br><input type="text" name="worknum" id="worknum" title="Potential owner's work contact details" value ="<?php
						if(isset($_POST['worknum'])){
							echo $_POST['worknum'];
						}
					?>"/>
					</div>
			</div>

			<div class="row">				
				<div class="col-xs-5 col-md-2">
					</br><p class="labels" title="Potential owner's place of residence">Address:</p>
				</div>	
				<div class="col-xs-5 col-md-3">
						</br><textarea rows="5" cols="30" name="Addr" title="Potential owner's place of residence"><?php
						if(isset($_POST['Addr'])){
								echo $_POST['Addr'];
							}?></textarea>
				</div>
				<div class="col-xs-2 col-md-1">
					</br><button  class="btn btn-primary center" type="submit" name = "saveAdopter" title="Property inspection form">Inspections</button>
				</div>												
			</div>	
			<div class="row">
				<div class="col-md-12">
				</div>
			</div>
	</div>
	</form>
	<!-- Scripts -->
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>