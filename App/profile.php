<!DOCTYPE html>
<html>
<head>
	<title>Profile</title>
	<?php include "includes/html_head.php";?>
</head>

<body>
	<?php include "includes/navbar.php";
	if($_GET['update'] == 'name'){
		echo '<script type="text/javascript">
		    alert("Name update successfully");
		</script>';
	}elseif($_GET['update'] == 'password'){
		echo '<script type="text/javascript">
		    alert("Password update successfully");
		</script>';
	}
	$query = "SELECT * FROM users WHERE user_id = ".$_SESSION['user_id'];
	$result = mysqli_query($conn,$query);
	$data = mysqli_fetch_assoc($result);
	echo '<div class="card card-body" style="margin-top: 66px">
		<div class="row">
			<div class="col-md-3 col-sm-12">
				<div class="card">
					<div class="card-body">
						<img src="'.$data["pic"].'" height=150px width=100%>
					</div>
				</div>
			</div>
			<div class="col-md-9 col-sm-12">
				<h1 class="text-success text-center font-Dancing_Script">
					<i class="fas fa-user"></i> '.$data["name"].' 
					<a class="btn button-text-hover btn-danger" data-toggle="collapse" data-target="#change-name"><i class="fas fa-edit"></i></a>
				</h1>
				<h1 class="text-success text-center font-Dancing_Script">
					<i class="fas fa-at"></i> '.$data["email"].'
				</h1>
				<a class="btn btn-lg btn-primary button-text-hover" data-toggle="collapse" data-target="#change-password" href="details.html?page=Extra-Curricular">
					<h6 class="text-center font-Azeret_Mono"><i class="fas fa-key-skeleton"></i> Change Password</h6>
				</a>
			</div>			
		</div>';?>

		<div class="row" style="margin-top: 60px; margin-bottom: 40px">			
			<div class="card-body col-lg-3 col-md-6 col-sm-12">
				<a class="btn btn-lg btn-primary button-text-hover m-auto" href="orders.php?delivery=no">
					<h6 class="text-center font-Azeret_Mono"><i class="fas fa-shipping-fast"></i> Ongoing Delivery</h6>
				</a>
			</div>
			
			<div class="card-body col-lg-3 col-md-6 col-sm-12 text-center">
				<a class="btn btn-lg btn-primary button-text-hover" href="orders.php?delivery=yes">
					<h6 class="text-center font-Azeret_Mono"><i class="fas fa-handshake"></i> Delivered</h6>
				</a>
			</div>

			<div class="card-body col-lg-3 col-md-6 col-sm-12">
				<a class="btn btn-lg btn-primary button-text-hover m-auto" href="bookmarks.php">
					<h6 class="text-center font-Azeret_Mono"><i class="fad fa-bookmark"></i> Bookmarks</h6>
				</a>
			</div>
		
			<div class="card-body col-lg-3 col-md-6 col-sm-12">
				<a class="btn btn-lg btn-primary button-text-hover m-auto" href="wishlist.php">
					<h6 class="text-center font-Azeret_Mono"><i class="fas fa-heart"></i> Wishlist</h6>
				</a>
			</div>
		
			<div class="card-body col-lg-3 col-md-6 col-sm-12">
				
			</div>
		</div>
	</div>

	<div class="container" style="margin-top: 20px">
		<div id="change-name" class="collapse card-body">
			<form action="db_control.php?topic=change_name" method="POST" class="was-validated">
				<input type="text" class="form-control" name="new-name" placeholder="New name" required><br>
				<input type="submit" value="Change" class="form-control btn btn-warning btn-lg button-text-hover" required>
			</form>
		</div>

		<div id="change-password" class="collapse card-body">
			<form id="change-password-form" action="db_control.php?topic=change_password" method="POST" class="was-validated">
        		<input type="hidden" name="original_password" value="<?php echo $data["password"]?>">
				<div style="display: flex;">
	        		<div class="col-md-10 col-sm-10">
	        			<input id="old_input_password" class="form-control" type="password" name="old_password" placeholder="Enter Old Password" required>
        			</div>
        			<div class="col-md-2 col-sm-2">
        				<a id="old_password_show" class="form-control btn btn-info button-text-hover" onclick="showPassword('old')"><i class="far fa-eye"></i></a>
        			</div>
        		</div><br>
        		
        		<div style="display: flex;">
	        		<div class="col-md-10 col-sm-10">
	        			<input id="new_input_password" class="form-control" type="password" name="new_password" placeholder="Enter New Password" required>
        			</div>
        			<div class="col-md-2 col-sm-2">
        				<a id="new_password_show" class="form-control btn btn-info button-text-hover" onclick="showPassword('new')"><i class="far fa-eye"></i></a>
        			</div>
        		</div><br>

        		<div style="display: flex;">
	        		<div class="col-md-10 col-sm-10">
	        			<input id="re_input_password" class="form-control" type="password" name="re_password" placeholder="Re-Enter New Password" required>
        			</div>
        			<div class="col-md-2 col-sm-2">
        				<a id="re_password_show" class="form-control btn btn-info button-text-hover" onclick="showPassword('re')"><i class="far fa-eye"></i></a>
        			</div>
        		</div><br>
          		<input type="button" value="Confirm" class="form-control btn btn-warning btn-lg button-text-hover" onclick="passwordChangeValidation()">
        	</form>
		</div>
	</div>
	
	<script type="text/javascript" src="includes/app.js"></script>
</body>
</html>