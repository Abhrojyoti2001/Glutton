<?php session_start();
if($_SESSION){
	header('Location:home.php');
	exit();
}?>
<!DOCTYPE html>
<html>
<head>
	<title>Glutton</title>
	<meta charset="utf-8">
	<meta name="description" content="A clone of Zomato, food delivering website">
	<meta name="keywords" content="">
	<meta name="author" content="Abhrojyoti Chatterjee">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@500&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Azeret+Mono:ital,wght@1,500&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
	<link rel="stylesheet" type="text/css" href="includes/style.CSS">

	<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
</head>

<body style="background: url(https://b.zmtcdn.com/web_assets/81f3ff974d82520780078ba1cfbd453a1583259680.png) no-repeat; background-size: cover 100% 100%;">
	<div class="navbar text-white">
		<h1 class="font-Lucida_Handwriting" style="margin: 5px">Glutton</h1>
		<div style="float: right;">
			<button class="btn button-text-hover btn-lg" style="margin-right: 25px;" data-toggle="modal" data-target="#Singup-Modal" id="Singup"><h4>Sing up</h4></button>
		</div>
	</div>
	
	<div class="container" style="margin-top: 50px;margin-bottom: 50px;">
		<div class="col-md-10 col-sm-10" style="margin: auto;">
			<h1 class="display-1 text-white text-center font-Dancing_Script">Glutton</h1>
			<h1 class="text-white text-center font-Azeret_Mono">Craving for food?<br>Look nowhere else. Explore Now!</h1><br><br>
        	<form action="db_control.php?topic=login" method="POST" class="was-validated">
        		<input class="form-control" type="email" name="email" placeholder="Email" required><br>	
        		<div style="display: flex;">
	        		<div class="col-md-8 col-sm-8">
	        			<input id="login_input_password" class="form-control" type="password" name="password" placeholder="Password" required>
        			</div>
        			<div class="col-md-2 col-sm-2">
        				<a id="login_input_show" class="form-control btn btn-info button-text-hover" onclick="showPassword('login')"><i class="far fa-eye"></i></a>
        			</div>
        			<div class="col-md-2 col-sm-2">
        				<input type="submit" value="Log in" class="form-control btn btn-danger btn-lg button-text-hover">
	        		</div>		        		
        		</div>
        	</form>
	    </div>
	</div>
	
	<div class="modal fade" id="Singup-Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog font-Azeret_Mono">
		    <div class="modal-content">
		    	<div class="modal-header">
		        	<h5 class="modal-title text-warning">Sing Up</h5>
		        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          	<span aria-hidden="true">&times;</span>
		        	</button>
		      	</div>
		      	<div class="modal-body">
		        	<form action="db_control.php?topic=singup" method="POST" class="was-validated">
		        		<input class="form-control" type="text" name="user_name" placeholder="Full Name" required><br>
		        		<input class="form-control" type="email" name="user_email" placeholder="Email" required><br>
		        		<div style="display: flex;">
			        		<div class="col-md-9 col-sm-9">
			        			<input id="singup_input_password" class="form-control" type="password" name="user_password" placeholder="Password" required>
			        		</div>
	        				<div class="col-md-3 col-sm-3">
	        					<a id="singup_input_show" class="form-control btn btn-info button-text-hover" onclick="showPassword('singup')"><i class="far fa-eye"></i></a>
	        				</div>
	        			</div><br><br>
		        		<input type="submit" value="Sing Up" class="btn btn-danger btn-block button-text-hover">
		        	</form>
		      	</div>
		  	</div>
		</div>
	</div>
	
	<script type="text/javascript" src="includes/app.js"></script>
	
	<script type="text/javascript">
		let page_name = location.href.split(".php")[1]
		if(page_name !== ''){
			let topic = location.href.split('?output=')[1];
			if(topic === 'email'){
				alert('Email already exists');
			}else if(topic === 'input'){
				alert('Incorrect email/password');
			}
		}
	</script>

</body>
</html>