<!DOCTYPE public>
<html>
<head>
	<!--Web browser tab title-->
	<title>About Animals</title>
	<!--Getting web styling from css file -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/mycss.css">
</head>
<body>
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
					<h2>Propety Inspection Details</h2>					
				</div>				
			</div>
			
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
								if($GLOBALS['prpty_sizes'] == 'Small'){
									echo '<option selected>'.'Small'.'</option>';
									echo'<option>'.'Medium'.'</option>';
									echo'<option>'.'Large'.'</option>';
								}
								elseif($GLOBALS['prpty_sizes'] == 'Medium'){
									echo'<option>'.'Small'.'</option>';
									echo '<option selected>'.'Medium'.'</option>';
									echo'<option>'.'Large'.'</option>';
								}
								elseif($_POST['proprSize'] == 'Small'){
									echo '<option selected>'.'Small'.'</option>';
									echo'<option>'.'Medium'.'</option>';
									echo'<option>'.'Large'.'</option>';
								}
								elseif($_POST['proprSize'] == 'Medium'){
									echo'<option>'.'Small'.'</option>';
									echo '<option selected>'.'Medium'.'</option>';
									echo'<option>'.'Large'.'</option>';
								}
								else{
									echo'<option>'.'Small'.'</option>';
									echo'<option>'.'Medium'.'</option>';
									echo'<option>'.'Large'.'</option>';
								}
							?>
						</select>
						<input type = 'hidden' name = "property_size" id = "proprSize" 
						value = "<?php
						if(isset($GLOBALS['prpty_sizes'])){
							echo $GLOBALS['prpty_sizes'];
						}
						elseif(isset($_POST['proprSize'])){
							echo $_POST['proprSize'];
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
								if($GLOBALS['prpty_fences'] == 'Brick'){
									echo '<option selected>'.'Brick'.'</option>';
									echo'<option>'.'Electric'.'</option>';
									echo'<option>'.'Palisade'.'</option>';
								}
								elseif($GLOBALS['prpty_fences'] == 'Electric'){
									echo'<option>'.'Brick'.'</option>';
									echo '<option selected>'.'Electric'.'</option>';
									echo'<option>'.'Palisade'.'</option>';
								}
								elseif($_POST['proprFence'] == 'Brick'){
									echo '<option selected>'.'Brick'.'</option>';
									echo'<option>'.'Electric'.'</option>';
									echo'<option>'.'Palisade'.'</option>';
								}
								elseif($_POST['proprFence'] == 'Electric'){
									echo'<option>'.'Brick'.'</option>';
									echo '<option selected>'.'Electric'.'</option>';
									echo'<option>'.'Palisade'.'</option>';
								}
								else{
									echo'<option>'.'Brick'.'</option>';
									echo'<option>'.'Electric'.'</option>';
									echo'<option>'.'Palisade'.'</option>';
								}
							?>
						</select>
						<input type = 'hidden' name = "property_fences" id = "proprFence"
						value = "<?php
						if(isset($GLOBALS['prpty_fences'])){
							echo $GLOBALS['prpty_fences'];
						}
						elseif(isset($_POST['proprFence'])){
							echo $_POST['proprFence'];
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
								if($GLOBALS['prpty_shltr'] == 'Yes'){
									echo '<option selected>'.'Yes'.'</option>';
									echo'<option>'.'No'.'</option>';
								}
								elseif($GLOBALS['prpty_shltr'] == 'No'){
									echo'<option>'.'Yes'.'</option>';
									echo '<option selected>'.'No'.'</option>';
								}
								elseif($_POST['proprShlt'] == 'Yes'){
									echo '<option selected>'.'Yes'.'</option>';
									echo'<option>'.'No'.'</option>';
								}
								elseif($_POST['proprShlt'] == 'No'){
									echo'<option>'.'Yes'.'</option>';
									echo '<option selected>'.'No'.'</option>';
								}
								else{
									echo'<option>'.'Yes'.'</option>';
									echo'<option>'.'No'.'</option>';
								}
							?>
						</select>
						<input type = 'hidden' name = "prpty_shltr" id = "proprShlt" 
						value = "<?php
						if(isset($GLOBALS['prpty_shltr'])){
							echo $GLOBALS['prpty_shltr'];
						}
						elseif(isset($_POST['proprShlt'])){
							echo $_POST['proprShlt'];
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
								if($GLOBALS['prpty_gates'] == 'Yes'){
									echo '<option selected>'.'Yes'.'</option>';
									echo'<option>'.'No'.'</option>';
								}
								elseif($GLOBALS['prpty_gates'] == 'No'){
									echo'<option>'.'Yes'.'</option>';
									echo '<option selected>'.'No'.'</option>';
								}
								elseif($_POST['proprGate'] == 'Yes'){
									echo '<option selected>'.'Yes'.'</option>';
									echo'<option>'.'No'.'</option>';
								}
								elseif($_POST['proprGate'] == 'No'){
									echo'<option>'.'Yes'.'</option>';
									echo '<option selected>'.'No'.'</option>';
								}
								else{
									echo'<option>'.'Yes'.'</option>';
									echo'<option>'.'No'.'</option>';
								}
							?>
						</select>
						<input type = 'hidden' name = "property_gates" id = "proprGate" title="Secured perimeter"
						value = "<?php
						if(isset($GLOBALS['prpty_grass'])){
							echo $GLOBALS['prpty_grass'];
						}
						elseif(isset($_POST['proprGate'])){
							echo $_POST['proprGate'];
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
								if($GLOBALS['prpty_grass'] == 'Yes'){
									echo '<option selected>'.'Yes'.'</option>';
									echo'<option>'.'No'.'</option>';
								}
								elseif($GLOBALS['prpty_grass'] == 'No'){
									echo'<option>'.'Yes'.'</option>';
									echo '<option selected>'.'No'.'</option>';
								}
								elseif($_POST['proprGrass'] == 'Yes'){
									echo '<option selected>'.'Yes'.'</option>';
									echo'<option>'.'No'.'</option>';
								}
								elseif($_POST['proprGrass'] == 'No'){
									echo'<option>'.'Yes'.'</option>';
									echo '<option selected>'.'No'.'</option>';
								}
								else{
									echo'<option>'.'Yes'.'</option>';
									echo'<option>'.'No'.'</option>';
								}
							?>
						</select>
						<input type = 'hidden' name = "property_grassed" id = "proprGrass"
						value = "<?php
						if(isset($GLOBALS['prpty_grass'])){
							echo $GLOBALS['prpty_grass'];
						}
						elseif(isset($_POST['proprStats'])){
							echo $_POST['proprStats'];
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
								if($GLOBALS['prpty_suits'] == 'Small'){
									echo '<option selected>'.'Small'.'</option>';
									echo'<option>'.'Medium'.'</option>';
									echo'<option>'.'Large'.'</option>';
								}
								elseif($GLOBALS['prpty_suits'] == 'Medium'){
									echo'<option>'.'Small'.'</option>';
									echo '<option selected>'.'Medium'.'</option>';
									echo'<option>'.'Large'.'</option>';
								}
								elseif($_POST['proprSuited'] == 'Small'){
									echo '<option selected>'.'Small'.'</option>';
									echo'<option>'.'Medium'.'</option>';
									echo'<option>'.'Large'.'</option>';
								}
								elseif($_POST['proprSuited'] == 'Medium'){
									echo'<option>'.'Small'.'</option>';
									echo '<option selected>'.'Medium'.'</option>';
									echo'<option>'.'Large'.'</option>';
								}
								else{
									echo'<option>'.'Small'.'</option>';
									echo'<option>'.'Medium'.'</option>';
									echo'<option>'.'Large'.'</option>';
								}
							?>
						</select>
						<input type = 'hidden' name = "property_suitability" id = "proprSuited" title="Safe and suitable environment"
						value = "<?php
						if(isset($GLOBALS['prpty_suits'])){
							echo $GLOBALS['prpty_suits'];
						}
						elseif(isset($_POST['proprSuited'])){
							echo $_POST['proprSuited'];
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
								if($GLOBALS['prpty_state'] == 'Approved'){
									echo '<option selected>'.'Approved'.'</option>';
									echo'<option>'.'Rejected'.'</option>';
								}
								elseif($GLOBALS['prpty_state'] == 'Rejected'){
									echo'<option>'.'Approved'.'</option>';
									echo '<option selected>'.'Rejected'.'</option>';
								}
								elseif($_POST['proprStats'] == 'Approved'){
									echo '<option selected>'.'Approved'.'</option>';
									echo'<option>'.'Rejected'.'</option>';
								}
								elseif($_POST['proprStats'] == 'Rejected'){
									echo'<option>'.'Approved'.'</option>';
									echo '<option selected>'.'Rejected'.'</option>';
								}
								else{
									echo'<option>'.'Approved'.'</option>';
									echo'<option>'.'Rejected'.'</option>';
								}
							?>
						</select>
						<input type = 'hidden' name = "property_status" id = "proprStats"
						value = "<?php
						if(isset($GLOBALS['prpty_state'])){
							echo $GLOBALS['prpty_state'];
						}
						elseif(isset($_POST['proprStats'])){
							echo $_POST['proprStats'];
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
								if($GLOBALS['more_animals'] == 'Yes'){
									echo '<option selected>'.'Yes'.'</option>';
									echo'<option>'.'No'.'</option>';
								}
								elseif($GLOBALS['more_animals'] == 'No'){
									echo'<option>'.'Yes'.'</option>';
									echo '<option selected>'.'No'.'</option>';
								}
								elseif($_POST['morepets'] == 'Yes'){
									echo '<option selected>'.'Yes'.'</option>';
									echo'<option>'.'No'.'</option>';
								}
								elseif($_POST['morepets'] == 'No'){
									echo'<option>'.'Yes'.'</option>';
									echo '<option selected>'.'No'.'</option>';
								}
								else{
									echo'<option>'.'Yes'.'</option>';
									echo'<option>'.'No'.'</option>';
								}
							?>
						</select>
						<input type = 'hidden' name = "petAmnt" id = "morepets"  title="Additional pets"
						value = "<?php
						if(isset($GLOBALS['more_animals'])){
							echo $GLOBALS['more_animals'];
						}
						elseif(isset($_POST['morepets'])){
							echo $_POST['morepets'];
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
								if($GLOBALS['animals_condition'] == 'Good'){
									echo '<option selected>'.'Good'.'</option>';
									echo'<option>'.'Bad'.'</option>';
									echo'<option>'.'N/A'.'</option>';
								}
								elseif($GLOBALS['animals_condition'] == 'N/A'){
									echo'<option>'.'Good'.'</option>';
									echo'<option>'.'Bad'.'</option>';
									echo '<option selected>'.'N/A'.'</option>';
								}
								elseif($_POST['anmlcondit'] == 'Good'){
									echo '<option selected>'.'Good'.'</option>';
									echo'<option>'.'Bad'.'</option>';
									echo'<option>'.'N/A'.'</option>';
								}
								elseif($_POST['anmlcondit'] == 'N/A'){
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
						<input type = 'hidden' name = "anmlcondition" id = "anmlcondit"
						value = "<?php
						if(isset($GLOBALS['animals_condition'])){
							echo $GLOBALS['animals_condition'];
						}
						elseif(isset($_POST['anmlcondit'])){
							echo $_POST['anmlcondit'];
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
					</br><textarea rows="5" cols="30" name="treat" title="Improvement terms of resinspection"> Fencing, Gates, Grass</textarea>
				</div>	
			<div class="col-xs-2 col-md-3">	
					</br><button onclick ="window.location.href='adopt.html'" class="btn btn-primary" type="submit" title="Apply for adoption">Process</button>							
				</div>
		</div>
	</div>
	<!-- Scripts -->
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>