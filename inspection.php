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
if(isset($_POST['saveInspection'])){
	if(!isset($_SESSION['adoption_ID'])){
		$GLOBALS['Error'] = ' Adoption ID not set, please fill out the adopters details on the adoption page and try again';
	}
	else{
		SavePropertyInspection($db);
	}
}

function SavePropertyInspection($db){

if(empty($_POST['insptdate'])){
	$GLOBALS['Error'] = 'Please select an inspection date';
}
else if(empty($_POST['reinspection'])){
	$GLOBALS['Error'] = 'Please enter a re inspection comment, enter none if re inspection not required';
}
else{
//storing post data in variables
$inspectionDate 	= $_POST['insptdate'];
$PropertySize 		= $_POST['property_size'];
$PropertyFence 		= $_POST['property_fences'];
$PropertyShelter 	= $_POST['prpty_shltr'];
$PropertyGates 		= $_POST['property_gates'];
$PropertyGrass 		= $_POST['property_grassed'];
$PropertySuitability = $_POST['property_suitability'];
$PropertyStatus 	= $_POST['property_status'];
$OtherAnimals 		= $_POST['petAmnt'];
$OtherAnimalsCondition = $_POST['anmlcondition'];
$Reinspection 		= $_POST['reinspection'];
$adoptionID 		= $_SESSION['adoption_ID'];

$sql = "INSERT INTO tbl_PropertyInspection VALUES(NULL,'$inspectionDate','$PropertySize','$PropertyFence','$PropertyShelter','$PropertyGates','$PropertyGrass','$OtherAnimals','$OtherAnimalsCondition','$PropertySuitability','$PropertyStatus','$Reinspection','$adoptionID')";

		//runs the insert and displays an error if the insert is unsuccessful
		if(!$result = $db->query($sql)){
			$GLOBALS['Error'] = ' There was an error running the query['.$db->error.']';
		}
		//if the user was added successfully then display a success message
		else{
			$GLOBALS['Success'] = ' Adoption process complete';
		}		
		//close the db connection;
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
					<h2>Property Inspection Details</h2>					
				</div>				
			</div>
			<form action = "inspection.php" method = "post" name = "inspection_form" id = "inspection_form">
			<div class="row">								
				<div class="col-xs-3 col-md-2">
					</br><p class="labels" title="Next inspection date">Inspection Date:</p>
				</div>
				<div class="col-xs-3 col-md-2">
					</br><input type="date" name="insptdate" id="insptdate" title="Next inspection date"/>
				</div>		
				<div class="col-xs-3 col-md-2">
					</br><p class="labels" title="Sufficient space">Property Size:</p>
				</div>
				<div class="col-xs-3 col-md-2">
					</br><select class = "form-control" id = "proprSize" onchange = "changePropSize(this)" title="Sufficient space">
							<?php
							if($_POST['property_size'] == 'Small'){
									echo '<option selected>'.'Small'.'</option>';
									echo'<option>'.'Medium'.'</option>';
									echo'<option>'.'Large'.'</option>';
							}
							elseif($_POST['property_size'] == 'Medium'){
									echo'<option>'.'Small'.'</option>';
									echo '<option selected>'.'Medium'.'</option>';
									echo'<option>'.'Large'.'</option>';
							}
							elseif($_POST['property_size'] == 'Large'){
									echo'<option>'.'Small'.'</option>';
									echo '<option>'.'Medium'.'</option>';
									echo'<option selected>'.'Large'.'</option>';
							}
							else{
									echo'<option>'.'Small'.'</option>';
									echo'<option>'.'Medium'.'</option>';
									echo'<option>'.'Large'.'</option>';
							}
							?>
						</select>
						<input type = 'hidden' name = "property_size" id = "propertySize" 
						value = "<?php
						if(isset($_POST['property_size'])){
							echo $_POST['property_size'];
						}
						else{
							echo 'Small';
						}?>">
				</div>		
			</div>

			<div class="row">							
				<div class="col-xs-3 col-md-2">
					</br><p class="labels" title="Secure perimeter">Property Fencing:</p>
				</div>
				<div class="col-xs-3 col-md-2">
					</br><select class = "form-control" id = "proprFence" onchange = "changePropFenced(this)" title="Secure perimeter">
							<?php
								if($_POST['property_fences'] == 'Brick'){
									echo '<option selected>'.'Brick'.'</option>';
									echo'<option>'.'Electric'.'</option>';
									echo'<option>'.'Palisade'.'</option>';
								}
								elseif($_POST['property_fences'] == 'Electric'){
									echo'<option>'.'Brick'.'</option>';
									echo '<option selected>'.'Electric'.'</option>';
									echo'<option>'.'Palisade'.'</option>';
								}
								elseif($_POST['property_fences'] == 'Palisade'){
									echo'<option>'.'Brick'.'</option>';
									echo '<option>'.'Electric'.'</option>';
									echo'<option selected>'.'Palisade'.'</option>';
								}
								else{
									echo'<option>'.'Brick'.'</option>';
									echo'<option>'.'Electric'.'</option>';
									echo'<option>'.'Palisade'.'</option>';
								}
							?>
						</select>
						<input type = 'hidden' name = "property_fences" id = "propertyFence"
						value = "<?php
						if(isset($_POST['property_fences'])){
							echo $_POST['property_fences'];
						}
						else{
							echo 'Brick';
						}?>">
				</div>	
				<div class="col-xs-3 col-md-2">
					</br><p class="labels" title="Animals sheltered from bad weather">Property Shelter:</p>
				</div>	
				<div class="col-xs-3 col-md-2">
					</br><select class = "form-control" id = "proprShlt" onchange = "changePropShelter(this)" title="Animals sheltered from bad weather">
							<?php
								if($_POST['prpty_shltr'] == 'Yes'){
									echo '<option selected>'.'Yes'.'</option>';
									echo'<option>'.'No'.'</option>';
								}
								elseif($_POST['prpty_shltr'] == 'No'){
									echo'<option>'.'Yes'.'</option>';
									echo '<option selected>'.'No'.'</option>';
								}
								else{
									echo'<option>'.'Yes'.'</option>';
									echo'<option>'.'No'.'</option>';
								}
							?>
						</select>
						<input type = 'hidden' name = "prpty_shltr" id = "propertyShlt" 
						value = "<?php
						if(isset($_POST['prpty_shltr'])){
							echo $_POST['prpty_shltr'];
						}
						else{
							echo 'Yes';
						}?>">
				</div>														
			</div>

			<div class="row">	
				<div class="col-xs-3 col-md-2">
					</br><p class="labels" title="Secured perimeter">Property Gates:</p>
				</div>
				<div class="col-xs-3 col-md-2">
					</br><select class = "form-control" id = "proprGate" onchange = "changePropGated(this)">
							<?php
								if($_POST['property_gates'] == 'Yes'){
									echo '<option selected>'.'Yes'.'</option>';
									echo'<option>'.'No'.'</option>';
								}
								elseif($_POST['property_gates'] == 'No'){
									echo'<option>'.'Yes'.'</option>';
									echo '<option selected>'.'No'.'</option>';
								}
								else{
									echo'<option>'.'Yes'.'</option>';
									echo'<option>'.'No'.'</option>';
								}
							?>
						</select>
						<input type = 'hidden' name = "property_gates" id = "propertyGate" title="Secured perimeter"
						value = "<?php
						if(isset($_POST['property_gates'])){
							echo $_POST['property_gates'];
						}
						else{
							echo 'Yes';
						}?>">		
				</div>				
				<div class="col-xs-3 col-md-2">
					</br><p class="labels" title="Are there grassed areas?">Property Grass:</p>
				</div>
				<div class="col-xs-3 col-md-2">
					</br><select class = "form-control" id = "proprGrass" onchange = "changePropGrass(this)" title="Are there grassed areas?">
							<?php
								if($_POST['property_grassed'] == 'Yes'){
									echo '<option selected>'.'Yes'.'</option>';
									echo'<option>'.'No'.'</option>';
								}
								elseif($_POST['property_grassed'] == 'No'){
									echo'<option>'.'Yes'.'</option>';
									echo '<option selected>'.'No'.'</option>';
								}
								else{
									echo'<option>'.'Yes'.'</option>';
									echo'<option>'.'No'.'</option>';
								}
							?>
						</select>
						<input type = 'hidden' name = "property_grassed" id = "propertyGrass"
						value = "<?php
						if(isset($_POST['property_grassed'])){
							echo $_POST['property_grassed'];
						}
						else{
							echo 'Yes';
						}?>">	
				</div>					
			</div>

			<div class="row">			
			<div class="col-xs-3 col-md-2">
					</br><p class="labels" title="Safe and suitable environment">Property Suitability:</p>
				</div>	
				<div class="col-xs-3 col-md-2">
					</br><select class = "form-control" id = "proprSuited" onchange = "changePropSuitable(this)" title="Safe and suitable environment">
							<?php
								if($_POST['property_suitability'] == 'Small'){
									echo '<option selected>'.'Small'.'</option>';
									echo'<option>'.'Medium'.'</option>';
									echo'<option>'.'Large'.'</option>';
								}
								elseif($_POST['property_suitability'] == 'Medium'){
									echo'<option>'.'Small'.'</option>';
									echo '<option selected>'.'Medium'.'</option>';
									echo'<option>'.'Large'.'</option>';
								}
							    elseif($_POST['property_suitability'] == 'Large'){
									echo'<option>'.'Small'.'</option>';
									echo '<option>'.'Medium'.'</option>';
									echo'<option selected>'.'Large'.'</option>';
								}
								else{
									echo'<option>'.'Small'.'</option>';
									echo'<option>'.'Medium'.'</option>';
									echo'<option>'.'Large'.'</option>';
								}
							?>
						</select>
						<input type = 'hidden' name = "property_suitability" id = "propertySuited" title="Safe and suitable environment"
						value = "<?php
						if(isset($_POST['property_suitability'])){
							echo $_POST['property_suitability'];
						}
						else{
							echo 'Small';
						}?>">
				</div>		
				<div class="col-xs-3 col-md-2">
					</br><p class="labels" title="Acceptable property condition">Property Status:</p>
				</div>
				<div class="col-xs-3 col-md-2">
					</br><select class = "form-control" id = "proprStats" onchange = "changePropStats(this)" title="Acceptable property condition">
							<?php
								if($_POST['property_status'] == 'Approved'){
									echo '<option selected>'.'Approved'.'</option>';
									echo'<option>'.'Rejected'.'</option>';
								}
								elseif($_POST['property_status'] == 'Rejected'){
									echo'<option>'.'Approved'.'</option>';
									echo '<option selected>'.'Rejected'.'</option>';
								}
								else{
									echo'<option>'.'Approved'.'</option>';
									echo'<option>'.'Rejected'.'</option>';
								}
							?>
						</select>
						<input type = 'hidden' name = "property_status" id = "propertyStats"
						value = "<?php
						if(isset($_POST['property_status'])){
							echo $_POST['property_status'];
						}
						else{
							echo 'Approved';
						}?>">	
				</div>	
				
		</div>

		<div class="row">			
				<div class="col-xs-3 col-md-2">
					</br><p class="labels" title="Additional pets">Other animals:</p>
				</div>	
				<div class="col-xs-3 col-md-2">
					</br><select class = "form-control" id = "morepets" onchange = "changeNoPets(this)"  title="Additional pets">
							<?php
								if($_POST['petAmnt'] == 'Yes'){
									echo '<option selected>'.'Yes'.'</option>';
									echo'<option>'.'No'.'</option>';
								}
								elseif($_POST['petAmnt'] == 'No'){
									echo'<option>'.'Yes'.'</option>';
									echo '<option selected>'.'No'.'</option>';
								}
								else{
									echo'<option>'.'Yes'.'</option>';
									echo'<option>'.'No'.'</option>';
								}
							?>
						</select>
						<input type = 'hidden' name = "petAmnt" id = "morePets"  title="Additional pets"
						value = "<?php
						if(isset($_POST['petAmnt'])){
							echo $_POST['petAmnt'];
						}
						else{
							echo 'Yes';
						}?>">	
				</div>		
				<div class="col-xs-3 col-md-2">
					</br><p class="labels" title="All animals in healthy condition">Other Animal Conditions:</p>
				</div>
				<div class="col-xs-3 col-md-2">
					</br><select class = "form-control" id = "anmlcondit" onchange = "changeCondition(this)" title="All animals in healthy condition">
							<?php
								if($_POST['anmlcondition'] == 'Good'){
									echo '<option selected>'.'Good'.'</option>';
									echo'<option>'.'Bad'.'</option>';
									echo'<option>'.'N/A'.'</option>';
								}
								elseif($_POST['anmlcondition'] == 'Bad'){
									echo'<option>'.'Good'.'</option>';
									echo'<option selected>'.'Bad'.'</option>';
									echo '<option selected>'.'N/A'.'</option>';
								}
								elseif($_POST['anmlcondition'] == 'N/A'){
									echo'<option>'.'Good'.'</option>';
									echo'<option>'.'Bad'.'</option>';
									echo '<option selected>'.'N/A'.'</option>';
								}
								else{
									echo'<option>'.'Good'.'</option>';
									echo'<option>'.'Bad'.'</option>';
									echo'<option>'.'N/A'.'</option>';
								}
							?>
						</select>
						<input type = 'hidden' name = "anmlcondition" id = "animalcondition" value = "<?php
						if(isset($_POST['anmlcondition'])){
							echo $_POST['anmlcondition'];
						}
						else{
							echo 'Good';
						}?>">	
				</div>								
		</div>

		<div class="row">				
			<div class="col-xs-3 col-md-2">
					</br><p class="labels" title="Improvement terms of resinspection">Reinspections stipulations:</p>
				</div>
				<div class="col-xs-6 col-md-4">
					</br><textarea rows="5" cols="30" name="reinspection" title="Improvement terms of resinspection" placeholder="Fencing, Gates,Grass"></textarea>
				</div>	
			<div class="col-xs-2 col-md-3">	
					</br><button class="btn btn-primary" name = "saveInspection" type="submit" title="Apply for adoption">Process</button>							
				</div>
		</div>
		</form>
	</div>
	<!-- Scripts -->
		<script type = 'text/javascript'>
		function changePropSize(selection){
			var sizeVal = document.getElementById("propertySize");
			sizeVal.value = selection.value;
		}
		function changePropFenced(selection){
			var fenceVal = document.getElementById("propertyFence");
			fenceVal.value = selection.value;
		}
		function changePropShelter(selection){
			var shelterVal = document.getElementById("propertyShlt");
			shelterVal.value = selection.value;
		}
		function changePropGated(selection){
			var gateVal = document.getElementById("propertyGate");
			gateVal.value = selection.value;
		}
		function changePropGated(selection){
			var gateVal = document.getElementById("propertyGrass");
			gateVal.value = selection.value;
		}
		function changePropSuitable(selection){
			var suitableVal = document.getElementById("propertySuited");
			suitableVal.value = selection.value;
		}
		function changePropStats(selection){
			var appVal = document.getElementById("propertyStats");
			appVal.value = selection.value;
		}
		function changeNoPets(selection){
			var otherPetsVal = document.getElementById("morePets");
			otherPetsVal.value = selection.value;
		}
		function changeCondition(selection){
			var otherPetsCOnditionVal = document.getElementById("animalcondition");
			otherPetsCOnditionVal.value = selection.value;
		}
		
	</script>
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>