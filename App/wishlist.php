<!DOCTYPE html>
<html>
<head>
	<title>Wishlist</title>
	<?php include "includes/html_head.php";?>
</head>

<body>
	<?php include "includes/navbar.php";?>
	<div class="container card card-body col-md-12 col-sm-12 mt-5 pt-3 bg-medium-turquoise">
		<h1 class="mt-4 mb-4">Wishlist</h1>
		<?php $query = 'SELECT * FROM wishlist JOIN restaurants ON restaurants.restaurant_id = wishlist.restaurant_id WHERE wishlist.user_id = '.$_SESSION["user_id"];
		$result = mysqli_query($conn,$query);
		$num_rows = mysqli_num_rows($result);
		if($num_rows != 0){
			while($row = mysqli_fetch_assoc($result)){
				echo '<div class="card card-body mb-4">
					<div class="row">
						<div class="col-md-2 col-sm-2">
							<img src='.$row["img-sm"].' width="100%" height="118px">
						</div>
						<div class="col-md-5 col-sm-5">
							<h3 class="text-success font-Azeret_Mono">'.$row["dish_name"].'</h3>
							<a href="restaurante.php?restaurant_id='.$row["restaurant_id"].'"><h3 class="font-Dancing_Script">'.$row["name"].'</h3></a>
							<h5>Cost <i>'.$row["cost"].'.00</i></h5>
						</div>
						<div class="card-body col-md-3 col-sm-3">
							<a class="btn btn-lg button-text-hover btn-danger" href="db_control.php?topic=remove_from_wishlist&wishlist_id='.$row["wishlist_id"].'"><i class="fas fa-heart-broken"></i> Remove from Wishlist</a>
						</div>
						<div class="card-body col-md-2 col-sm-2">
							<a class="btn btn-lg button-text-hover btn-primary" href="db_control.php?topic=add_to_cart&restaurant_id='.$row["restaurant_id"].'&dish_name='.$row["dish_name"].'"><i class="fas fa-cart-plus"></i> Add to Cart</a>
						</div>
					</div>
				</div>';
			}
		}else{
			echo '<h1 class="text-danger text-center">No wishlist added</h1>';
		}?>			
	</div>

	<script type="text/javascript" src="includes/app.js"></script>
</body>
</html>