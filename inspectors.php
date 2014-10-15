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

//if the user clicks add
if(isset($_POST['addInspector'])){
	AddNewInspector($db);
}
//if the user clicks search
else if(isset($_POST['inspectorFind'])){
	SearchForInspector($db);
}
//if the user clicks update
else if(isset($_POST['updateInspector'])){
	UpdateInspector($db);
}
// validates entered details and updates the inspector
function UpdateInspector($db){
	//validating all fields are filled in
	if(empty($_POST['iName']) OR empty($_POST['iSname']) OR empty($_POST['iLeagueid']) OR empty($_POST['iRank'])){
		$GLOBALS['Error'] = 'Please fill in all user details';
	}
	else{	
		//storing post data in variables
		$inspector_ID = $_SESSION['inspectors_ID'];
		$iName 		= $_POST['iName'];
		$iSname 	= $_POST['iSname'];
		$iLeagueid 	= $_POST['iLeagueid'];
		$iRank 		= $_POST['iRank'];
		
		//sql to update new inspector
		$sql = "UPDATE tbl_Inspectors 
				SET 
				inspectors_Name = '$iName',
				inspectors_Surname = '$iSname',
				inspectors_Rank = '$iRank',
				inspectors_LeagueID = '$iLeagueid'
				WHERE inspectors_ID = $inspector_ID";
		
		//runs the insert and displays an error if the insert is unsuccessful
		if(!$result = $db->query($sql)){
			$GLOBALS['Error'] = 'There was an error running the query['.$db->error.']';
		}
		//if the user was added successfully then display a success message
		else{
			$GLOBALS['Success'] = ' User details updated';
		}		
		//close the db connection;
		$db->close();
	}
}

//validates search critera and stores found inspector details
function SearchForInspector($db){
	//validating the username field is filled in
	if(empty($_POST['inspectorLeagueID'])){
		$GLOBALS['Error'] = 'Please fill in the required league id field when searching for a user';
	}
	else{
		// selecting user details from the db 
		$sql = "SELECT * FROM tbl_Inspectors WHERE inspectors_LeagueID = '".$_POST['inspectorLeagueID']."'";
	
		//runs the query and displays an error if the statement is unsuccessful
		if(!$result = $db->query($sql)){
			$GLOBALS['Error'] = 'There was an error running the query['.$db->error.']';
		}
		else{
			//store returned values in the global variables
			while ($row = $result->fetch_assoc()){
			
				$_SESSION['inspectors_ID'] 		= $row['inspectors_ID'];
				$GLOBALS['inspectors_LeagueID'] = $row['inspectors_LeagueID'];
				$GLOBALS['inspectors_Name'] 	= $row['inspectors_Name'];
				$GLOBALS['inspectors_Surname'] 	= $row['inspectors_Surname'];
				$GLOBALS['inspectors_Rank'] 	= $row['inspectors_Rank'];	
			}
			
			//free the memory associated with $result and close the db connection;
			$result->free();
		$db->close();
		}
	}
}

//validates and inserts the new user
function AddNewInspector($db){	

	//validating all fields are filled in
	if(empty($_POST['iName']) OR empty($_POST['iSname']) OR empty($_POST['iLeagueid']) OR empty($_POST['iRank'])){
		$GLOBALS['Error'] = 'Please fill in all user details';
	}

	else{
		//storing post data in variables
		$iName 		= $_POST['iName'];
		$iSname 	= $_POST['iSname'];
		$iLeagueid 	= $_POST['iLeagueid'];
		$iRank 		= $_POST['iRank'];
		
		//sql to insert new user
		$sql = "INSERT INTO tbl_Inspectors VALUES(NULL,'$iName','$iSname','$iRank','$iLeagueid')";
		
		//runs the insert and displays an error if the insert is unsuccessful
		if(!$result = $db->query($sql)){
			$GLOBALS['Error'] = ' There was an error running the query['.$db->error.']';
		}
		//if the user was added successfully then display a success message
		else{
			$GLOBALS['Success'] = ' Inspector created';
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
	<title>Inspectors</title>
	<!--Getting web styling from css file -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/mycss.css">
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
				  		<li><a href="animals.php">Animals</a></li>
				  		<li><a href="qrcode.php">QR Codes</a></li>
				  		<li><a href="users.php">Users</a></li>
				  		<li class="active" data-toggle="tab"><a href="inspectors.php">Inspectors</a></li>
				  		<li><a href="reportsd.php">Reports</a></li>

					</ul> 
				</div> 					
			</div>

			<div class="row">				
				<div class="col-xs-12 col-md-12">
					<h2>Inspector Information</h2>					
				</div>				
			</div>		

			<form action = "inspectors.php" method = "post" name = "inspector_form" id = "inspector_form">
				<div class="row">	
					<div class="col-xs-7 col-md-2">
						</br><p class="labels" title="First Name">Inspector Name:</p>
					</div>
					<div class="col-xs-4 col-md-3">
						</br><input type="text" name="iName" id="iName" title="First Name"
						value = "<?php //keeps the name in the input if there are errors when clicking add
						if(isset($_POST['iName'])){
							echo $_POST['iName'];
						} //adds the name to the input when searching
						elseif(isset($GLOBALS['inspectors_Name'])){ 
							echo $GLOBALS['inspectors_Name'];
						}?>"/></br>
					</div>		
					<div class="col-xs-7 col-md-2">
						</br><p class="labels" title="Last Name">Inspector Surname:</p>
					</div>
					<div class="col-xs-3 col-md-3">
						</br><input type="text" name="iSname" id="iSname" title="Last Name"
						value = "<?php //keeps the surname in the input if there are errors when clicking add
						if(isset($_POST['iSname'])){
							echo $_POST['iSname'];
						} //adds the surname to the input when searching
						elseif(isset($GLOBALS['inspectors_Surname'])){ 
							echo $GLOBALS['inspectors_Surname'];
						}?>"/>
					</div>								
				</div>

				<div class="row">		
					<div class="col-xs-7 col-md-2">
						</br><p class="labels" title="Unique Identifier Number">Inspector League ID:</p>
					</div>
					<div class="col-xs-4 col-md-3">
						</br><input type="text" name="iLeagueid" id="iLeagueid" title="Unique Identifier Number"
						value = "<?php //keeps the league id in the input if there are errors when clicking add
						if(isset($_POST['iLeagueid'])){
							echo $_POST['iLeagueid'];
						} //adds the league id to the input when searching
						elseif(isset($GLOBALS['inspectors_LeagueID'])){ 
							echo $GLOBALS['inspectors_LeagueID'];
						}?>"/>
					</div>

					<div class="col-xs-7 col-md-2">
						</br><p class="labels" title="Authority level">Rank:</p>
					</div>
					<div class="col-xs-3 col-md-2">
							</br><select class="form-control " id = "rank" onchange ="changeRank(this)" title="Authority level">
								<?php
								if($GLOBALS['inspectors_Rank'] == 'Junior'){
									echo '<option selected>'.'Junior'.'</option>';
									echo '<option>'.'Senior'.'</option>';
								}
								elseif($GLOBALS['inspectors_Rank'] == 'Senior'){
									echo '<option>'.'Junior'.'</option>';
									echo '<option selected>'.'Senior'.'</option>';
								}
								elseif($_POST['iRank'] == 'Junior'){
									echo '<option selected>'.'Junior'.'</option>';
									echo '<option>'.'Senior'.'</option>';
								}
								elseif($_POST['iRank'] == 'Senior'){
									echo '<option>'.'Junior'.'</option>';
									echo '<option selected>'.'Senior'.'</option>';
								}
								else{
									echo'<option>'.'Junior'.'</option>';
									echo'<option>'.'Senior'.'</option>';
								}
							?>
							  <!--<?php //setting the selection option 
								//for($cnt = 1;$cnt <=5;$cnt++){
								//	if($GLOBALS['inspectors_Rank'] == $cnt){
								//		echo'<option selected>'.$cnt.'</option>';
								//	}
								//	elseif($_POST['iRank'] == $cnt){
								//		echo'<option selected>'.$cnt.'</option>';;
								//	}
								//	else{
								//	echo'<option>'.$cnt.'</option>';
								//	}
								//}
							  //?>-->
							</select>
							<input type = 'hidden' name = "iRank" id ="rankLevel" 
							value = "<?php
							if(isset($GLOBALS['inspectors_Rank'])){
								echo $GLOBALS['inspectors_Rank'];
							}
							elseif(isset($_POST['iRank'])){
								echo $_POST['iRank'];
							}
							else{
								echo 'Junior';
							}?>">
					</div>					
				</div>
				<div class="col-xs-4 col-md-2">
					</br><button class="btn btn-primary center" name = "addInspector" type="submit" title="Create new inspector">Add</button>
				</div>
				<div class="col-xs-3 col-md-2">
					</br><button class="btn btn-primary center" name = "updateInspector" type="submit" title="Edit inspector's details">Update</button>		
				</div>
			</form>
			

			<div class="row">
				<div class="col-xs-4 col-md-2">
					<!-- Button trigger modal -->
					</br><button class="btn btn-primary center" data-toggle="modal" data-target="#myModal" title="Search for an inspector">
					  Search
					</button>

					<!-- Modal -->
					<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					  <div class="modal-dialog">
					    <div class="modal-content">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					        <h4 class="modal-title" id="myModalLabel">Inspector Search</h4>
					      </div>
					      <div class="modal-body">

						<!-- form used to submit the search data -->
							<form action = "inspectors.php" method = "post">						  
								<div class="input-group">
									<input type="text" name = "inspectorLeagueID" class="form-control">
									<span class="input-group-btn">
									<button class="btn btn-default" type="submit" name = "inspectorFind" title="Start search">Find</button>
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
		function changeRank(selection){
			var rankVal = document.getElementById("rankLevel");
			rankVal.value = selection.value;
		}
	</script>	
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>