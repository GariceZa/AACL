<?php
session_start();
//including the db connection variables
include_once 'include/db.php';
//including the qrcode library
include_once 'phpqrcode/qrlib.php';

//creating new db object
$db = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);

//checking the connection to the db before user tries to add a new user
if($db -> connect_errno > 0){
	//setting the global variable to the error message
	$GLOBALS['Error'] = 'Unable to connect to database ['.$db->connect_error.']';
}

//if the user clicks add
if(isset($_POST['addAnimal'])){
	AddNewAnimal($db);
}
else if(isset($_POST['animalFind'])){
	SearchForAnimal($db);
}
else if(isset($_POST['updateAnimal'])){

	UpdateAnimal($db);
}
else if(isset($_POST['adoptAnimal'])){
		if(!isset($_SESSION['animal_ID'])){
		$GLOBALS['Error'] = ' No animal selected';
	}
	else{
		header('Location:adopt.php');
	}
}
//updates the animal details without a new image 
function UpdateAnimalWithoutImage($db,$animal_ID,$aName,$aSpecies,$aBreed,$aGender,$rDate,$aInjuries,$aTreatments){
			
		//sql to update new inspector
		$sql = "UPDATE tbl_Animals
				SET 
				animal_Name = '$aName',
				animal_Type = '$aSpecies',
				animal_Breed = '$aBreed',
				animal_Gender = '$aGender',
				animal_RescueDate = '$rDate',
				animal_Injuries = '$aInjuries',
				animal_Treatments = '$aTreatments'
				WHERE animal_ID = $animal_ID";
				
		//runs the insert and displays an error if the insert is unsuccessful
		if(!$result = $db->query($sql)){
			$GLOBALS['Error'] = 'There was an error running the query['.$db->error.']';
		}
		//if the user was added successfully then display a success message
		else{
			//check if euthenized
			if(isset($_POST['euth'])){
			$insertEuthSQL = "INSERT INTO tbl_Euthenasias VALUES(NULL,'$animal_ID',(SELECT CURDATE()))"; 
				if(!$result = $db->query($insertEuthSQL)){
				$GLOBALS['Error'] = ' There was an error running the query['.$db->error.']';
				}	
		}
		//---------------------	 
	
		//check if sterilized
			if(isset($_POST['sterl'])){
			$insertSterSQL = "INSERT INTO tbl_Sterilizations VALUES(NULL,'$animal_ID',(SELECT CURDATE()))";
				if(!$result = $db->query($insertSterSQL)){
				$GLOBALS['Error'] = ' There was an error running the query['.$db->error.']';
				}
			}			
			$GLOBALS['Success'] = ' Animal details updated';
		}		
}

//updates the animal details if a new image has been selected
function UpdateAnimalWithImage($db,$animal_ID,$aName,$aSpecies,$aBreed,$aGender,$aImage,$rDate,$aInjuries,$aTreatments){
			
		//sql to update new inspector
		$sql = "UPDATE tbl_Animals
				SET 
				animal_Name = '$aName',
				animal_Type = '$aSpecies',
				animal_Breed = '$aBreed',
				animal_Gender = '$aGender',
				animal_Image = '$aImage',
				animal_RescueDate = '$rDate',
				animal_Injuries = '$aInjuries',
				animal_Treatments = '$aTreatments'
				WHERE animal_ID = $animal_ID";
				
		//runs the insert and displays an error if the insert is unsuccessful
		if(!$result = $db->query($sql)){
			$GLOBALS['Error'] = 'There was an error running the query['.$db->error.']';
		}
		//if the user was added successfully then display a success message
		else{
			//check if euthenized
			if(isset($_POST['euth'])){
			$insertEuthSQL = "INSERT INTO tbl_Euthenasias VALUES(NULL,'$animal_ID',(SELECT CURDATE()))" ;
				if(!$result = $db->query($insertEuthSQL)){
				$GLOBALS['Error'] = ' There was an error running the query['.$db->error.']';
				}	
		}
		//---------------------	 
	
		//check if sterilized
			if(isset($_POST['sterl'])){
			$insertSterSQL = "INSERT INTO tbl_Sterilizations VALUES(NULL,'$animal_ID',(SELECT CURDATE()))" ;
				if(!$result = $db->query($insertSterSQL)){
				$GLOBALS['Error'] = ' There was an error running the query['.$db->error.']';
				}
			}
			$GLOBALS['Success'] = ' Animal details updated';
		}		
}

//Validates and updates the animals details
function UpdateAnimal($db){

//validating all fields have been set
if(empty($_POST['pname']) OR empty($_POST['species']) OR empty($_POST['breed']) or empty($_POST['gender'])
	or empty($_POST['rdate']) or empty ($_POST['inj']) or empty ($_POST['treat'])){
		$GLOBALS['Error'] = ' Please fill in all animal details';
}
elseif(!empty($_FILES['animalImage']['name'])){
	
		if(pathinfo($_FILES['animalImage']['name'],PATHINFO_EXTENSION) != "jpg"){
			
			$GLOBALS['Error'] = ' Image is not in the correct format, please select a jpg file';						
		}
		else{
			$aImage = addslashes(file_get_contents($_FILES['animalImage']['tmp_name']));//saving image as binary data
			UpdateAnimalWithImage($db,$_SESSION['animal_ID'],$_POST['pname'],$_POST['species'],$_POST['breed'],$_POST['gender'],$aImage,$_POST['rdate'],$_POST['inj'],$_POST['treat']);
		}
}
else{	
		UpdateAnimalWithoutImage($db,$_SESSION['animal_ID'],$_POST['pname'],$_POST['species'],$_POST['breed'],$_POST['gender'],$_POST['rdate'],$_POST['inj'],$_POST['treat']);
}
//close the db connection;
$db->close();
}

//validates search criteria and stores animal details
function SearchForAnimal($db){
//validating the required input is not blank
if(empty($_POST['animalName'])){
	$GLOBALS['Error'] = 'Please fill in the animal name field when searching for an animal';
}
else{
	$sql = "SELECT * FROM tbl_Animals WHERE animal_Name = '".$_POST['animalName']."'";
	
	//runs the query and displays an error if the statement is unsuccessful
	if(!$result = $db->query($sql)){
		$GLOBALS['Error'] = 'There was an error running the query['.$db->error.']';
	}
	//if there are no results returned
	elseif($result->num_rows == 0){
			$GLOBALS['Error'] = ' Animal does not exist';
	}
	else{
		while ($row = $result->fetch_assoc()){
		
				$_SESSION['animal_ID'] 			= $row['animal_ID'];
				$GLOBALS['animal_Name'] 		= $row['animal_Name'];
				$GLOBALS['animal_Type'] 		= $row['animal_Type'];
				$GLOBALS['animal_Breed'] 		= $row['animal_Breed'];
				$GLOBALS['animal_Gender'] 		= $row['animal_Gender'];
				$GLOBALS['animal_RescueDate'] 	= $row['animal_RescueDate'];
				$GLOBALS['animal_Injuries'] 	= $row['animal_Injuries'];
				$GLOBALS['animal_Treatments'] 	= $row['animal_Treatments'];
		}
		CheckIfSterilized($db);
		CheckIfEuthanized($db);		
		
		//free the memory associated with $result and close the db connection;
		$result->free();
	$db->close();
	}
}
}

function CheckIfSterilized($db){
	$sql = "SELECT * FROM tbl_Sterilizations where sterlization_AnimalID = '".$_SESSION['animal_ID']."'";
	if(!$result = $db->query($sql)){
	}
	else{
		if(mysqli_num_rows($result)){
			$GLOBALS['sterilized'] = 'true';
		}
	}
}

function CheckIfEuthanized($db){
	$sql = "SELECT * FROM tbl_Euthenasias where euthenasia_AnimalID = '".$_SESSION['animal_ID']."'";
	if(!$result = $db->query($sql)){
	}
	else{
		if(mysqli_num_rows($result)){
			$GLOBALS['euthanized'] = 'true';
		}
	}
}

//creates the qrcode and saves it to the db
function AddQRCode($aName,$db){

	
	$tempDir = dirname(__FILE__).DIRECTORY_SEPARATOR.'phpqrcode'.DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR; //setting the tempory directory to store the qrcode
	$fileName = $tempDir.$aName.'.png';//naming the qrcode file 
	$errorCorrectionLevel = 'Q'; //setting the error correction level of the qrcode
	$matrixPointSize = 5; //setting the size of the generated qrcode
	$generationDate =  date('Y/m/d');//setting the date
	
	//generating the qrcode and saving it to the temp folder
	QRcode::png($aName,$fileName,$errorCorrectionLevel,$matrixPointSize, 2);
		
	//gets the animals animal_ID
	$sql = "SELECT animal_ID FROM tbl_Animals WHERE animal_Name ='".$aName."'";
	
	if(!$result = $db->query($sql)){
		$GLOBALS['Error'] = 'There was an error running the query['.$db->error.']';
	}
	else{
		while ($row = $result->fetch_assoc()){
			$animal_ID = $row['animal_ID'];
		}
			//storing qrcode image as binary
			$QRImage = addslashes(file_get_contents($fileName));
			
			//sql to insert qrcode into tbl_QRCodes
			$insertQRCodeSQL = "INSERT INTO tbl_QRCodes VALUES(NULL,'$QRImage','$generationDate','$animal_ID')";
			
				if(!$result = $db->query($insertQRCodeSQL)){
					$GLOBALS['Error'] = 'There was an error running the query['.$db->error.']';
				}
				else{
					if(DeleteTempQRCode($fileName)){
						$GLOBALS['Success'] = ' Animal Added';
					}
					else{
						$GLOBALS['Warning'] = ' Animal added but there was an error deleting the QRCode';
					}
			}
	}
	
}
//deletes the tempory qrcode image, returns a boolean
function DeleteTempQRCode($fileName){
	return unlink($fileName);
}

//validates and inserts new animal
function AddNewAnimal($db){

//validating all fields have been set
if(empty($_POST['pname']) OR empty($_POST['species']) OR empty($_POST['breed']) or empty($_POST['gender'])
	or empty($_POST['rdate']) or empty ($_POST['inj']) or empty ($_POST['treat'])){
		$GLOBALS['Error'] = ' Please fill in all animal details';
}
//validating an image has been selected
elseif(empty($_FILES['animalImage']['name'])){
	$GLOBALS['Error'] = ' Please select an image for the animal';
}
//validating the image is a jpg
elseif(pathinfo($_FILES['animalImage']['name'],PATHINFO_EXTENSION) != "jpg"){
	$GLOBALS['Error'] = ' Image is not in the correct format, please select a jpg file';
}
else{

	//storing post data 
	 $aName 	= $_POST['pname'];
	 $aSpecies 	= $_POST['species'];
	 $aBreed 	= $_POST['breed'];
	 $aGender 	= $_POST['gender'];
	 $aImage 	= addslashes(file_get_contents($_FILES['animalImage']['tmp_name']));//saving image as binary data
	 $rDate 	= $_POST['rdate'];
	 $aInjuries     = $_POST['inj'];
	 $aTreatments   = $_POST['treat'];
	 

	
	//sql to insert values into animals table
	$insertSQL = "INSERT INTO tbl_Animals VALUES(NULL,'$aName','$aSpecies','$aBreed','$aGender','$aImage','$rDate','$aInjuries','$aTreatments')";
	
	//runs the insert and displays an error if the insert is unsuccessful
	if(!$result = $db->query($insertSQL)){
		$GLOBALS['Error'] = ' There was an error running the query['.$db->error.']';
	}
	 //-------------------
	else{
	
			//check if euthenized
		if(isset($_POST['euth'])){
		$insertEuthSQL = "INSERT INTO tbl_Euthenasias VALUES(NULL,(SELECT animal_ID FROM tbl_Animals WHERE animal_Name = '$aName'),'$rDate')";
			if(!$result = $db->query($insertEuthSQL)){
			$GLOBALS['Error'] = ' There was an error running the query['.$db->error.']';
			}	
		}
		//---------------------	 
	
		//check if sterilized
		if(isset($_POST['sterl'])){
		$insertSterSQL = "INSERT INTO tbl_Sterilizations VALUES(NULL,(SELECT animal_ID FROM tbl_Animals WHERE animal_Name = '$aName'),'$rDate')" ;
			if(!$result = $db->query($insertSterSQL)){
			$GLOBALS['Error'] = ' There was an error running the query['.$db->error.']';
			}
		}
	
		//create and add the animals qrcode
		AddQRCode($aName,$db);		
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
<!----------------------------------------------------------//ROW//---------------------------------------------------------------------------------->
			<!--Navigation bar across the top of the webpage-->
			<div class="row">
				<div class="col-xs-12 col-md-12"> 
					<ul class="nav nav-tabs" data-tabs="tabs" >
			  			<li><a href="home.php">Home</a></li>		  			
				  		<li class="active" data-toggle="tab"><a href="animals.php">Animals</a></li>
				  		<li><a href="qrcode.php">QR Codes</a></li>
				  		<li><a href="users.php">Users</a></li>
				  		<li><a href="inspectors.php">Inspectors</a></li>
				  		<li><a href="reportsd.php">Reports</a></li>
				  		<!--<li><a href="gallery.html">Gallery</a></li>
				  		<li><a href="help.html">Help</a></li>-->				  		
					</ul> 
				</div> 					
			</div>
<!----------------------------------------------------------//ROW//---------------------------------------------------------------------------------->			
			<div class="row">				
				<div class="col-xs-12 col-md-12">
					<h2>Animals Details</h2>					
				</div>				
			</div>
			
			<form action = "animals.php" method = "post" name = "animals_form" id = "animals_form" enctype="multipart/form-data">
<!----------------------------------------------------------//ROW//---------------------------------------------------------------------------------->			
				<div class="row">				
					<div class="col-xs-7 col-md-2">
						<p class="labels" title="i.e. Mr.Whiskers">Pet Name:</p>
					</div>
					<div class="col-xs-3 col-md-2">
						<input type="text" name="pname" id="pname" title="i.e. Mr.Whiskers"
						value = "<?php
							if(isset($_POST['pname'])){
								echo $_POST['pname'];
							}
							elseif(isset($GLOBALS['animal_Name'])){
								echo $GLOBALS['animal_Name'];
							}
						?>"/>
					</div>
					<div class="col-xs-7 col-md-2">
						<p class="labels" title="Species">Pet Type:</p>
					</div>
					<div class="col-xs-4 col-md-2">
						<select class = "form-control" id = "species" onchange = "changeSpecies(this)" title="Species">
							<?php
								if($GLOBALS['animal_Type'] == 'Dog'){
									echo '<option selected>'.'Dog'.'</option>';
									echo '<option>'.'Cat'.'</option>';
								}
								elseif($GLOBALS['animal_Type'] == 'Cat'){
									echo '<option>'.'Dog'.'</option>';
									echo '<option selected>'.'Cat'.'</option>';
								}
								elseif($_POST['species'] == 'Dog'){
									echo '<option selected>'.'Dog'.'</option>';
									echo '<option>'.'Cat'.'</option>';
								}
								elseif($_POST['species'] == 'Cat'){
									echo '<option>'.'Dog'.'</option>';
									echo '<option selected>'.'Cat'.'</option>';
								}
								else{
									echo'<option>'.'Dog'.'</option>';
									echo'<option>'.'Cat'.'</option>';
								}
							?>
						</select>
						<input type = 'hidden' name = "species" id = "animalSpecies"
						value = "<?php
						if(isset($GLOBALS['animal_Type'])){
							echo $GLOBALS['animal_Type'];
						}
						elseif(isset($_POST['species'])){
							echo $_POST['species'];
						}
						else{
							echo 'Dog';
						}?>">
					</div>										
				</div>
<!----------------------------------------------------------//ROW//---------------------------------------------------------------------------------->			
				<div class="row">			
					<div class="col-xs-7 col-md-2">
						</br><p class="labels" title="i.e. Staffie, Siamese">Breed:</p>
					</div>
					<div class="col-xs-3 col-md-2">
						</br><input type="text" name="breed" id="breed" title="i.e. Staffie, Siamese"
						value = "<?php
						if(isset($_POST['breed'])){
							echo $_POST['breed'];
						}
						elseif(isset($GLOBALS['animal_Breed'])){
							echo $GLOBALS['animal_Breed'];
						}
						?>"/>
					</div>
					<div class="col-xs-7 col-md-2">
						</br><p class="labels" title="Sex">Gender:</p>
					</div>
					<div class="col-xs-4 col-md-2">
					</br><select class = "form-control" id = "gender" onchange = "changeGender(this)" title="Sex">
							<?php
								if($GLOBALS['animal_Gender'] == 'Male'){
									echo '<option selected>'.'Male'.'</option>';
									echo'<option>'.'Female'.'</option>';
								}
								elseif($GLOBALS['animal_Gender'] == 'Female'){
									echo'<option>'.'Male'.'</option>';
									echo '<option selected>'.'Female'.'</option>';
								}
								elseif($_POST['gender'] == 'Male'){
									echo '<option selected>'.'Male'.'</option>';
									echo'<option>'.'Female'.'</option>';
								}
								elseif($_POST['gender'] == 'Female'){
									echo'<option>'.'Male'.'</option>';
									echo '<option selected>'.'Female'.'</option>';
								}
								else{
									echo'<option>'.'Male'.'</option>';
									echo'<option>'.'Female'.'</option>';
								}
							?>
						</select>
				
						<input type = 'hidden' name = "gender" id = "animalGender"
						value = "<?php
						if(isset($GLOBALS['animal_Gender'])){
							echo $GLOBALS['animal_Gender'];
						}
						elseif(isset($_POST['gender'])){
							echo $_POST['gender'];
						}
						else{
							echo 'Male';
						}?>">	
					</div>												
				</div>
<!----------------------------------------------------------//ROW//---------------------------------------------------------------------------------->			
				<div class="row">
					<div class="col-xs-7 col-md-2">
						</br><p class="labels" title="Month and year of rescue">Rescue Date:</p>
					</div>				
					<div class="col-xs-3 col-md-2">
						</br><input type="date" name="rdate" id="rdate" value ="<?php
						if(isset($_POST['rdate'])){
							echo $_POST['rdate'];
						}
						elseif(isset($GLOBALS['animal_RescueDate'])){
							echo $GLOBALS['animal_RescueDate'];
						}
						?>" title="Focus on the month and year of rescue"/>
					</div>	
					<div class="col-xs-12 col-md-4">
					</br><p class="upload">Select image</p>				  
						<!--uploading an image of the animal -->						
							<table border = "0" >						
								<tr>
									<td><strong>Image:</strong></td>
									<td><input name = "animalImage" id = "animalImage" type = "file" title="Locate an recent image"></td>
								</tr>																																
							</table>						
					</div>
				</div>
<!----------------------------------------------------------//ROW//---------------------------------------------------------------------------------->			
			<div class="row">
				<div class="col-xs-5 col-md-2">
						</br><p class="labels" title="Mange, rabies, cuts, bites, scratches, broken limb etc.">Injuries:</p>
					</div>
					<div class="col-xs-6 col-md-3">
						</br><textarea placeholder ="Enter the animals injuries" rows="5" cols="30" name="inj" title="Mange, rabies, cuts, bites, scratches, broken limb etc."><?php 
							if(isset($_POST['inj'])){
								echo $_POST['inj'];
							}
							elseif(isset($GLOBALS['animal_Injuries'])){
								echo $GLOBALS['animal_Injuries'];
							}
						?></textarea>
					</div>			
					<div class="col-xs-5 col-md-2">
						</br><p class="labels" title="Mange,rabies, spay/neuter etc">Treatments:</p>
					</div>			
					<div class="col-xs-6 col-md-2">
						</br><textarea placeholder ="Enter the treatments the animal will receive" rows="5" cols="30" name="treat" title="Mange,rabies, spay/neuter etc"><?php 
							if(isset($_POST['treat'])){
								echo $_POST['treat'];
							}
							elseif(isset($GLOBALS['animal_Treatments'])){
								echo $GLOBALS['animal_Treatments'];
							}
						?></textarea>
					</div>	
			</div>
<!----------------------------------------------------------//ROW//---------------------------------------------------------------------------------->		
			<div class="row">
				<div class="col-xs-2 col-md-2">
					</br><p class="labels" title="Check if animal needs euthenasia.">Euthenasia:</p>
				</div>
				<div class="col-xs-2 col-md-1">
					</br><input type="checkbox" name="euth" id="euthenasia" title="Check if animal needs euthenasia."<?php
					if(isset($_POST['euth'])){
						echo 'checked';
					}
					elseif(isset($GLOBALS['euthanized'])){
						echo 'checked';
					}
					?>/>
				</div>
				<div class="col-xs-2 xol-md-2">
					</br><p class="labels" title="Check if sterilization is required!">Sterilization:</p>
				</div>
				<div class="col-xs-2 col-md-2">
					</br><input type="checkbox" name="sterl" id="sterilization" title="Check if sterilization is required!"<?php
					if(isset($_POST['sterl'])){
						echo 'checked';
					}
					elseif(isset($GLOBALS['sterilized'])){
						echo 'checked';
					}					
					?>/>
				</div>
			</div>
<!----------------------------------------------------------//ROW//---------------------------------------------------------------------------------->					
			<div class="row">
				<div class="col-xs-6 col-md-2">
						</br><button class="btn btn-primary center" type="submit" name = "addAnimal" title="Add an animal">Add</button>
				</div>	
				<div class="col-xs-6 col-md-2">
						</br><button class="btn btn-primary center" type="submit" name = "updateAnimal" title="Edit animal's details">Update</button>
				</div>
				<div class="col-xs-6 col-md-2">	
				<form action = "adopt.php">
					</br><button class="btn btn-primary center" type="submit" name = "adoptAnimal"  title="Adoption form">Adopt</button>						
				</div>					
			</div>
				</form>	
<!----------------------------------------------------------//ROW//---------------------------------------------------------------------------------->					
				<div class="row">
				<div class="col-xs-4 col-md-2">
					<!-- Button trigger modal -->
					</br><button class="btn btn-primary center" datea-keyboard="true" data-toggle="modal" data-target="#myModal" title="Search for an inspector">
					  Search
					</button>
					<!-- Modal -->
					<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					  <div class="modal-dialog">
					    <div class="modal-content">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					        <h4 class="modal-title" id="myModalLabel">Enter Animal Name</h4>
					      </div>
					      <div class="modal-body">

						<!-- form used to submit the search data -->
							<form action = "animals.php" method = "post">						  
								<div class="input-group">
									<input type="text" name = "animalName" class="form-control" autofocus>
									<span class="input-group-btn">
									<button class="btn btn-default" type="submit" name = "animalFind" title="Start search">Find</button>
									</span>
							</form>
						<!-- end of form -->
						  						      
						    </div><!-- /input-group -->	
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-default" data-dismiss="modal" title="Escape">Close</button>					    
					      </div>
					    </div><!-- /.modal-content -->
					  </div><!-- /.modal-dialog -->
					</div><!-- /.modal -->	
				</div>	
			</div>
	</div>

	<!-- Scripts -->
		<script type = 'text/javascript'>
		function changeSpecies(selection){
			var species = document.getElementById("animalSpecies");
			species.value = selection.value;
		}
	</script>
		<script type = 'text/javascript'>
		function changeGender(selection){
			var gender = document.getElementById("animalGender");
			gender.value = selection.value;
		}
	</script>
		<script type = 'text/javascript'>
		function changePage(){
			location.href = "adopt.php";
		}
	</script>	
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>