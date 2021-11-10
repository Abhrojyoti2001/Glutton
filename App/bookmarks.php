<!DOCTYPE html>
<html>
<head>
	<title>Bookmarks</title>
	<?php include "includes/html_head.php";?>
</head>

<body>
	<?php include "includes/navbar.php";?>	
	<div class="container card card-body col-md-12 col-sm-12 mt-5 pt-3 bg-medium-turquoise">
		<h1 class="mt-4 mb-4">Bookmarks</h1>
		<?php $query = 'SELECT * FROM bookmarks JOIN restaurants ON restaurants.restaurant_id = bookmarks.restaurant_id WHERE bookmarks.user_id = '.$_SESSION["user_id"];
		$result = mysqli_query($conn,$query);
		$num_rows = mysqli_num_rows($result);
		if($num_rows != 0){
			while($row = mysqli_fetch_assoc($result)){
				echo '<div class="card card-body col-md-12 col-sm-12 mb-4">
					<div class="row">
						<div class="col-md-2 col-sm-2">
							<img src='.$row["img-sm"].' width="100%">
						</div>
						<div class="col-md-7 col-sm-7">
							<a href="restaurante.php?restaurant_id='.$row["restaurant_id"].'"><h2 class="font-Dancing_Script">'.$row["name"].'</h2></a>
							<h5 class="font-Azeret_Mono text-danger">'.$row["cuisines"].'</h5>
							<h6 class="font-Azeret_Mono text-muted ">'.$row["city"].'</h6>
						</div>
						<div class="card-body col-md-3 col-sm-3">
							<a class="btn btn-lg button-text-hover btn-danger" href="db_control.php?topic=remove_bookmarks&bookmarks_id='.$row["bookmarks_id"].'"><i class="fad fa-book-open"></i> Remove Bookmarks</a>
						</div>
					</div>
				</div>';
			}
		}else{
			echo '<h1 class="text-danger text-center">No bookmarks added</h1>';
		}?>
	</div>
	
	<script type="text/javascript" src="includes/app.js"></script>
</body>
</html>