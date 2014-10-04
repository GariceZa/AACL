<?php
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
if(isset($_POST['QRCodeSearch'])){
	SearchForQRCode($db);
}

function SearchForQRCode($db){

if(empty($_POST['animalName'])){
	$GLOBALS['Error'] = ' Please fill in the required animal name field';
}
else{
	//selecting the animal name,image and qrcode
	$sql = "SELECT a.animal_Name,a.animal_Image,q.qr_Image 
	FROM tbl_Animals a JOIN tbl_QRCodes q
	ON a.animal_ID = q.animal_ID
	WHERE a.animal_Name = '".$_POST['animalName']."'";
	
		//runs the query and displays an error if the statement is unsuccessful
		if(!$result = $db->query($sql)){
			$GLOBALS['Error'] = 'There was an error running the query['.$db->error.']';
		}
		//if there are no results returned
		elseif($result->num_rows == 0){
			$GLOBALS['Error'] = ' Animal does not exist';
		}		
		else{	
			$row = mysqli_fetch_array($result);//receives query results
			imagepng(imagecreatefromstring($row['qr_Image']));//creates png image of qrcode
			//forces the file to be downloaded
			header('content-Disposition:Attachment;filename=image.png');
			header("content-type:image/png");
			//----------------			
			//free the memory associated with $result and close the db connection;
			$result->free();
		$db->close();
		}
	}
}

?>

<!DOCTYPE PUBLIC>
<html>
	<head>
		<title>QR Codes</title>
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
		elseif(isset($_POST['QRCodeSearch'])){

		}
				
		?>
		<!-- end of alert message -->
	
		<div class="container">
			<div class="jumbotron">
				<img src="images/aacl.png" alt="" class="pic image-responsive" align="left">
				<h1>Animal Anti-Cruelty League</h1>
				<h5>Est. 1956</h5>				
			</div>
<!----------------------------------------------------------//ROW//---------------------------------------------------------------------------------->

			<div class="row">
				<div class="col-md-12"> 
					<ul class="nav nav-tabs" data-tabs="tabs" >
			  			<li><a href="home.html">Home</a></li>		  			
			  			<li><a href="animals.php">Animals</a></li>
			  			<li class="active" data-toggle="tab"><a href="qrcode.php">QR Codes</a></li>
			  			<li><a href="users.php">Users</a></li>
			  			<li><a href="inspectors.php">Inspectors</a></li>
			  			<li><a href="reportsd.php">Reports</a></li>
			  			<!--<li><a href="gallery.html">Gallery</a></li>
			  			<li ><a href="help.html">Help</a></li>-->
					</ul> 
				</div> 					
			</div>	
<!----------------------------------------------------------//ROW//---------------------------------------------------------------------------------->						
			<div class="row">				
				<div class="col-xs-12 col-md-12">
					<h2> QRCode Search</h2>				
				</div>						
			</div>	
<!----------------------------------------------------------//ROW//---------------------------------------------------------------------------------->						
				
			<div class="row">	
				<div class="col-xs-5 col-md-5">
				</div>		
				<div class="col-xs-4 col-md-6">
					<!-- Button trigger modal -->
					<button class="btn btn-primary center" data-toggle="modal" title="Search using QR Code" data-target="#myModal" title="Open Search Window">
					  Search
					</button>
					<!-- Modal -->
					<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					  <div class="modal-dialog">
					    <div class="modal-content">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					        <h4 class="modal-title" id="myModalLabel">QR Code Search</h4>
					      </div>
					      <div class="modal-body">
						  
					        <!-- form used to submit the search data -->
							<form action = "qrcode.php" method = "post">					
								<div class="input-group">
									<input type="text" name = "animalName" class="form-control" autofocus>
									<span class="input-group-btn">
										<button class="btn btn-default" type="submit" name = "QRCodeSearch" title="Start search">Search</button>
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
	<!-- Scripts -->
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	</body>

</html>
