<!DOCTYPE html>
<html>
<head>
	<title>My Orders</title>
	<?php include "includes/html_head.php";?>
</head>

<body>
	<?php include "includes/navbar.php";?>
	<div class="container card card-body col-md-12 col-sm-12 bg-medium-turquoise">
		<h1 class="mt-5 pt-3 mb-4">My Orders</h1>
		<?php $delivery = $_GET['delivery'];
		if($delivery == 'no'){
			$query = 'SELECT * FROM orders WHERE delivery_status LIKE 0 AND user_id LIKE '.$_SESSION["user_id"];
		}elseif($delivery == 'yes'){		
			$query = 'SELECT * FROM orders WHERE delivery_status LIKE 1 AND user_id LIKE '.$_SESSION["user_id"];
		}else{
			header('Location:cart.php');
		}
		$result = mysqli_query($conn,$query);
		$num_rows = mysqli_num_rows($result);
		if($num_rows != 0){
			while($row = mysqli_fetch_assoc($result)){
				echo '<div class="row col-md-12 col-sm-12 text-center">
					<div class="card card-body mb-4">
						<div class="row">
							<div class="card-body col-md-6 col-sm-6">
								<h5>Order ID '.$row["orders_id"].'</h5>
								<h5>Order Date '.$row["orders_date"].'</h5>
							</div>
							<div class="card-body col-md-6 col-sm-6">
								<h5>Transaction ID '.$row["transaction_id"].'</h5>
								<h5>Payment Method '.$row["payment_method"].'</h5>
							</div>';
							$query1 = 'SELECT * FROM orders JOIN orders_details ON orders_details.orders_id = orders.orders_id WHERE orders.orders_id LIKE "'.$row["orders_id"].'"';
							$result1 = mysqli_query($conn,$query1);
							$total = 0;
							while($row1 = mysqli_fetch_assoc($result1)){
								$total += ($row1["cost"] * $row1["quantity"]);
								echo '<div class="card-body row col-md-11 col-sm-11 m-auto" style="border: 1px dashed grey;">
									<div class="col-md-2 col-sm-2">
										<img src='.$row1["img-sm"].' width="100%" height="118px">
									</div>
									<div class="col-md-5 col-sm-5">
										<h3 class="text-success font-Azeret_Mono">'.$row1["dish_name"].'</h3>
										<a href="restaurante.php?restaurant_id='.$row1["restaurant_id"].'"><h3 class="font-Dancing_Script">'.$row1["name"].'</h3></a>
										<h5>Cost <i>'.$row1["cost"].'.00</i></h5>
									</div>
									<div class="col-md-3 col-sm-3 text-center">
										<span class="font-Azeret_Mono ml-3 mr-3" style="font-size: 25px;">'.$row1["quantity"].'</span>
									</div>
									<div class="card-body col-md-2 col-sm-2">
										<a class="btn btn-lg button-text-hover btn-primary" href="db_control.php?topic=add_to_cart&restaurant_id='.$row1["restaurant_id"].'&dish_name='.$row1["dish_name"].'"><i class="fas fa-cart-plus"></i> Add to Cart</a>
									</div>
								</div>';			
							}
							echo '<div class="card-body col-md-6 col-sm-6">
								<h5>'.$row["name"].'</h3>
								<address>'.$row["address"].'</address>
							</div>
							<div class="card-body col-md-6 col-sm-6">
								<h5>Total Price '.$total.'</h5>
								<h5>Tax '.$total * 0.18.'</h5>
								<h5>Discount '.(($total * 1.18) - $row["amount"]).'</h5>
								<h5>Total Amount '.$row["amount"].'</h5>
							</div>
						</div>
					</div>
				</div>';
			}
		}else{
			echo '<h1 class="text-danger text-center">No order found</h1>';
		}?>
	</div>
	
	<script type="text/javascript" src="includes/app.js"></script>
</body>
</html>