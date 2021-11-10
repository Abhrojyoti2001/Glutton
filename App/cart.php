<!DOCTYPE html>
<html>
<head>
	<title>Cart</title>
	<?php include "includes/html_head.php";?>
</head>

<script type="text/javascript">
	$(document).ready(function(){
		$('.change-quantity').click(function(){
			let btn_id = $(this);
			let sign = $(this).text();
			let quantity = $(this).siblings('span').text();
			let price = $(this).parent().siblings('.col-md-7').children('h5').children('i').text();
			let total = $('#total-price').text();
			let cart_id = $(this).val();
			if(sign === '-' && quantity === '1'){
				alert("Minimun quantity is 1")
			}else{
				if(sign === 'Remove from Cart'){
					$.ajax({
						url: 'db_control.php?topic=remove_from_cart',
						method:'POST',
						data: {'id':cart_id},
						success: function(data){
							btn_id.parent().parent().parent().hide();
						},
						error: function(error){
							alert("Some error occurred");
						}
					})
				}else{
					$.ajax({
						url: 'db_control.php?topic=add_to_cart',
						method:'POST',
						data: {'id':cart_id,'cost':price,'sign':sign},
						success: function(data){
							if(sign === '+'){
								btn_id.siblings('span').text(Number(quantity) + 1);
								$('#total-price').text(Number(total) + Number(price));
								$('#tax').text(((Number(total) + Number(price))*0.18).toFixed(2));
								$('#total-amount').text(((Number(total) + Number(price))*1.18).toFixed(2));
							}else{
								btn_id.siblings('span').text(Number(quantity) - 1);
								$('#total-price').text(Number(total) - Number(price));
								$('#tax').text(((Number(total) - Number(price))*0.18).toFixed(2));
								$('#total-amount').text(((Number(total) - Number(price))*1.18).toFixed(2));
							}
						},
						error: function(error){
							alert("Some error occurred");
						}
					})
				}
			}
		})
	})
</script>

<body>
	<?php include "includes/navbar.php";?>
	<div class="container col-md-12 col-sm-12 mt-4">
		<div class="row">
			<div class="card card-body col-md-9 col-sm-9 bg-medium-turquoise">
				<h1 class="mt-4 mb-4">Cart</h1>
				<?php $query = 'SELECT * FROM carts JOIN restaurants ON restaurants.restaurant_id = carts.restaurant_id WHERE carts.user_id = '.$_SESSION["user_id"];
				$result = mysqli_query($conn,$query);
				$num_rows = mysqli_num_rows($result);
				if($num_rows != 0){
					$_SESSION['total'] = 0;
					while($row = mysqli_fetch_assoc($result)){
						$_SESSION['total'] += ($row['cost'] * $row['quantity']);
						echo '<div class="card card-body mb-4">
							<div class="row">
								<div class="col-md-2 col-sm-2">
									<img src='.$row["img-sm"].' width="100%" height="118px">
								</div>
								<div class="col-md-7 col-sm-7">
									<h3 class="text-success font-Azeret_Mono">'.$row["dish_name"].'</h3>
									<a href="restaurante.php?restaurant_id='.$row["restaurant_id"].'"><h3 class="font-Dancing_Script">'.$row["name"].'</h3></a>
									<h5>Cost <i>'.$row["cost"].'.00</i></h5>
								</div>
								<div class="col-md-3 col-sm-3 text-center">
									<button class="btn btn btn-warning change-quantity" value="'.$row["cart_id"].'">-</button>
									<span class="font-Azeret_Mono ml-3 mr-3" style="font-size: 25px;">'.$row["quantity"].'</span>
									<button class="btn btn btn-warning change-quantity" value="'.$row["cart_id"].'">+</button>
									<button class="btn btn btn-danger change-quantity mt-3" value="'.$row["cart_id"].'">Remove from Cart</button>
								</div>
							</div>
						</div>';
					}
				}else{
					echo '<h1 class="text-danger text-center">Cart is emmty</h1>';
				}?>
			</div>
			
			<div class="card card-body col-md-3 col-sm-3 mt-4" style="background-color: #ACFA58;">
				<?php if($num_rows != 0){
					echo '<div class="row font-Azeret_Mono mt-5 pt-2" style="padding: 0px;">
						<div class="col-sm-6">Total Price</div>
						<div class="col-sm-6 mb-4 text-danger">Rs <span id="total-price">'.$_SESSION['total'].'</span></div>
						<div class="col-sm-6">Tax</div>
						<div class="col-sm-6 text-danger">Rs <span id="tax">'.$_SESSION['total'] * 0.18.'</span></div><br><br>
						<div class="col-md-6">Total Amount</div>
						<div class="col-sm-6 text-danger">Rs <span id="total-amount">'.$_SESSION['total'] * 1.18.'</span></div>
					</div><br><br>
					<form action="db_control.php?topic=add_orders" method="POST">
						<input type="submit" class="btn btn-danger btn-block button-text-hover" value="Place Order">
					</from>';
				}?>				
			</div>
		</div>
	</div>

	<script type="text/javascript" src="includes/app.js"></script>
</body>
</html>