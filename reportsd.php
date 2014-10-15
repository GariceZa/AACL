<!DOCTYPE PUBLIC>
<html>
	<head>
		<title>Reports</title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="styles/bootstrap.css"/>
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
			  			<li><a href="users.php">Users</a></li>
			  			<li><a href="inspectors.php">Inspectors</a></li>
			  			<li class="active" data-toggle="tab"><a href="reportsd.php">Reports</a></li>

					</ul> 
				</div> 					
			</div>						
			<div class="row">				
				<div class="col-xs-12 col-md-12">
					<h2> Monthly Report</h2>					
				</div>										
			</div>
			<div class="row">				
				<div class="col-xs-6 col-md-2">
					<p class="labels" title="Month and Year of report required">Report Date:</p>
				</div>	
				<div class="col-xs-6 col-md-4">	
					<input type="date" name="mreport" id="mreport" title="Month and Year of report required" value ="<?php
						if(isset($_POST['mreport'])){
							echo $_POST['mreport'];
						}
						elseif(isset($GLOBALS['monthly_report'])){
							echo $GLOBALS['monthly_report'];
						}
						?>"/>
				</div>							
			</div>
			
			<div class="row">				
				<div class="col-xs-7 col-md-2">
					</br><h5 class="report" title="Per month">Animals rescued</h5>
				</div>
				<div class="col-xs-4 col-md-2">
					</br><p class="stats" title="Total">60</p>
				</div>
				<div class="col-xs-7 col-md-2">
					</br><h5 class="report" title="Per month">Properties inspected</h5>					
				</div>
				<div class="col-xs-4 col-md-2">
					</br><p class="stats" title="Total">25</p>					
				</div>
				<div class="col-xs-7 col-md-2">
					</br><h5 class="report" title="Per month">Animals adopted</h5>					
				</div>
				<div class="col-xs-4 col-md-2">
					</br><p class="stats" title="Total">20</p>					
				</div>				
			</div>

			<div class="row">								
				<div class="col-xs-7 col-md-2">
					</br><h5 class="report" title="Per month">Sterilizations</h5>
				</div>	
				<div class="col-xs-4 col-md-2">
					</br><p class="stats" title="Total">10</p>
				</div>
				<div class="col-xs-7 col-md-2">
					</br><h5 class="report" title="Per month">Euthenasias</h5>
				</div>												
				<div class="col-xs-4 col-md-2">
					</br><p class="stats" title="Total">3</p>
				</div>
			</div>	

			<div class="row">
				<div class="col-xs-6 col-md-4">
					</br><button class="btn btn-primary center" type="submit" title="Produce specified report">Print</button>
				</div>
			</div>
		</div>
	</body>
	<!-- Scripts -->
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</html>