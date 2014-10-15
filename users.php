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
if(isset($_POST['addUser'])){
	AddNewUser($db);
}
//if the user clicks search
else if(isset($_POST['userFind'])){
	SearchForUser($db);
}
//if the user clicks update
else if(isset($_POST['updateUser'])){
	UpdateUser($db);
}
//validates and updates the users details
function UpdateUser($db){
//validating all fields are filled in
	if(empty($_POST['uname']) OR empty($_POST['uSname']) OR empty($_POST['email'])){
		$GLOBALS['Error'] = ' Please fill in all user details';
	}
	//validating the email address format
	else if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
		$GLOBALS['Error'] = ' Email address format is incorrect';
	}
	//validating passwords match
	else if(($_POST['pword'] != $_POST['cpword'])) {	
		$GLOBALS['Error'] = ' Passwords do not match';		
	}
	else{	
	
		//storing post data in variables
		$user_ID	= $_SESSION['user_ID'];		
		$uname 		= $_POST['uname'];
		$uSname 	= $_POST['uSname'];
		$email 		= $_POST['email'];
		
		if(empty($_POST['pword']) AND empty($_POST['cpword'])){

			
			//sql to update  user
			$sql = "UPDATE tbl_Users 
				SET 
				user_Name = '$uname',
				user_Surname = '$uSname',
				user_Email = '$email'
				WHERE user_ID = $user_ID";
				
			//runs the insert and displays an error if the insert is unsuccessful
			if(!$result = $db->query($sql)){
				$GLOBALS['Error'] = 'There was an error running the query['.$db->error.']';
			}
			//if the user was added successfully then display a success message
			else{
				$GLOBALS['Success'] = ' User details updated';
			}
		}
		else{
		$MD5Pass 	= md5($_POST['pword']);//turning password into MD5 hash
		//sql to update  user
			$sql = "UPDATE tbl_Users 
				SET 
				user_Name = '$uname',
				user_Surname = '$uSname',
				user_Email = '$email',
				user_Password = '$MD5Pass'
				WHERE user_ID = $user_ID";
				
			//runs the insert and displays an error if the insert is unsuccessful
			if(!$result = $db->query($sql)){
				$GLOBALS['Error'] = 'There was an error running the query['.$db->error.']';
			}
			//if the user was added successfully then display a success message
			else{
				$GLOBALS['Success'] = ' User details updated';
			}
		}				
		//close the db connection;
		$db->close();
	}	
}
//returns found users details
function SearchForUser($db){
	//validating the username field is filled in
	if(empty($_POST['userName'])){
		$GLOBALS['Error'] = 'Please fill in the required username field when searching for a user';
	}
	else{
		// selecting user details from the db 
		$sql = "SELECT * FROM tbl_Users WHERE user_Name = '".$_POST['userName']."'";
	
		//runs the query and displays an error if the statement is unsuccessful
		if(!$result = $db->query($sql)){
			$GLOBALS['Error'] = 'There was an error running the query['.$db->error.']';
		}
		else{
			//store returned values in the global variables
			while ($row = $result->fetch_assoc()){
				
				$_SESSION['user_ID'] 		= $row['user_ID'];
				$GLOBALS['user_Name'] 		= $row['user_Name'];
				$GLOBALS['user_Surname'] 	= $row['user_Surname'];
				$GLOBALS['user_Email'] 		= $row['user_Email'];	
			}
			
			//free the memory associated with $result and close the db connection;
			$result->free();
		$db->close();
		}
	}
}
//validates and inserts the new user
function AddNewUser($db){	
	//validating all fields are filled in
	if(empty($_POST['uname']) OR empty($_POST['uSname']) OR empty($_POST['email']) OR empty($_POST['pword']) OR empty($_POST['cpword'])){
		$GLOBALS['Error'] = 'Please fill in all user details';
	}
	//validating the email address format
	else if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
		$GLOBALS['Error'] = 'Email address format is incorrect';
	}
	//validating passwords match
	else if(($_POST['pword'] != $_POST['cpword'])) {	
		$GLOBALS['Error'] = ' Passwords do not match';		
	}
	else{
		//storing post data in variables
		$uname 		= $_POST['uname'];
		$uSname 	= $_POST['uSname'];
		$email 		= $_POST['email'];
		$MD5Pass 	= md5($_POST['pword']);//turning password into MD5 hash
		
		//sql to insert new user
		$sql = "INSERT INTO tbl_Users VALUES(NULL,'$uname','$uSname','$email','$MD5Pass')";
		
		//runs the insert and displays an error if the insert is unsuccessful
		if(!$result = $db->query($sql)){
			$GLOBALS['Error'] = ' There was an error running the query['.$db->error.']';
		}
		//if the user was added successfully then display a success message
		else{
			$GLOBALS['Success'] = ' User created';
		}		
		//close the db connection;
		$db->close();
	}
}
?>
<!DOCTYPE PUBLIC>
<html>
	<head>
		<title>The League</title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/mycss.css">
	<head/>
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
	
		<div class="container">
			<div class="jumbotron">
				<img src="images/aacl.png" alt="" class="pic image-responsive" align="left">
				<h1>Animal Anti-Cruelty League</h1>
				<h5>Est. 1956</h5>				
			</div>
			
			<div class="row">
				<div class="col-md-12"> 
					<ul class="nav nav-tabs" data-tabs="tabs" >
			  			<li><a href="home.php">Home</a></li>		  			
			  			<li><a href="animals.php">Animals</a></li>
			  			<li><a href="qrcode.php">QR Codes</a></li>
			  			<li class="active" data-toggle="tab"><a href="users.php">Users</a></li>
			  			<li><a href="inspectors.php">Inspectors</a></li>
			  			<li><a href="reportsd.php">Reports</a></li>

					</ul> 
				</div> 					
			</div>	
			
			<div class="row">
				<div class="col-xs-12 col-md-12">
					<h2> The League</h2>				
				</div>						
			</div>	
			
			<!-- start of user form --> 
			<form action = "users.php" method = "post">
				<div class="row">					
					<div class="col-xs-3 col-md-2">
						</br><p class="labels" title="First Name">User Name:</p>
					</div>
					<div class="col-xs-3 col-md-2">
						</br><input type="text" name="uname" id="uname" title="First Name"
						value = "<?php //keeps the username in the input if there are errors when clicking add
						if(isset($_POST['uname'])){
							echo $_POST['uname'];
						} //adds the username to the input when searching
						elseif(isset($GLOBALS['user_Name'])){ 
							echo $GLOBALS['user_Name'];
						}?>"/>
					</div>				
				</div>

				<div class="row">						
					<div class="col-xs-3 col-md-2">
						<p class="labels" title="Last Name">User Surname:</p>
					</div>
					<div class="col-xs-3 col-md-2">
						<input type="text" name="uSname" id="uSname" title="Last Name"
						value = "<?php //keeps the surname in the input if there are errors when clicking add
						if(isset($_POST['uSname'])){
							echo $_POST['uSname'];
						} //adds the surname to the input when searching 
						elseif(isset($GLOBALS['user_Surname'])){
							echo $GLOBALS['user_Surname'];
						}?>"/>
					</div>				
				</div>

				<div class="row">								
					<div class="col-xs-3 col-md-2">
						<p class="labels" title="i.e. animallover@gmail.com">Email Address:</p>
					</div>
					<div class="col-xs-3 col-md-2">
						<input type="text" name="email" id="email" title="i.e. animallover@gmail.com"
						value = "<?php //keeps the email in the input if there are errors when clicking add
						if(isset($_POST['email'])){
							echo $_POST['email'];
						} //adds the email to the input when searching 
						elseif(isset($GLOBALS['user_Email'])){
							echo $GLOBALS['user_Email'];
						}?>"/>
					</div>				
				</div>

				<div class="row">						
					<div class="col-xs-3 col-md-2">
						<p class="labels" title="For security purposes">Password:</p>
					</div>
					<div class="col-xs-3 col-md-2">
						<input type="password" name="pword" id="pword" title="the longer the better"
						value = "<?php //keeps the password in the input if there are errors when clicking add
						if(isset($_POST['pword'])) 
							echo $_POST['pword'];
						?>"/>
					</div>				
				</div>		

				<div class="row">			
					<div class="col-xs-3 col-md-2">
						<p class="labels" title="Must match above password">Confirm Password:</p>
					</div>								
					<div class="col-xs-3 col-md-2">
						<input type="password" name="cpword" id="cpword" title="Must match above password"
						value = "<?php //keeps the confirmation password in the input if there are errors when clicking add
						if(isset($_POST['cpword'])) 
							echo $_POST['cpword'];
						?>"/>
					</div>				
				</div>	

			<div class="col-xs-3 col-md-2">
				</br><button class="btn btn-primary center" name = "addUser" type="submit" title="Create user">Add</button>
			</div>
			<div class="col-xs-3 col-md-2">
				</br><button class="btn btn-primary center" name = "updateUser" type="submit" title="Edit user details">Update</button>
			</div>	
			</form>				
			<!-- End of user form -->	
			
				<div class="row">
				<div class="col-xs-3 col-md-2">
					<!-- Button to trigger modal -->
					<button class="btn btn-primary center" data-toggle="modal" data-target="#myModal" title="Searching for someone">
					  Search
					</button>

					<!-- Modal -->
					<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					  <div class="modal-dialog">
					    <div class="modal-content">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					        <h4 class="modal-title" id="myModalLabel">User Search</h4>
					      </div>
					      <div class="modal-body">
						  
							<!-- form used to submit the search data -->
							<form action = "users.php" method = "post">						  
								<div class="input-group">
									<input value="" autofocus type="text" name = "userName" class="form-control" >
									<span class="input-group-btn">
									<button class="btn btn-default" type="submit" name = "userFind" title="Start search">Find</button>
							</form>
								<!-- end of form -->
								
									</span>
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
			
		</div>
		<!-- Scripts -->
		<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
	</body>

</html>