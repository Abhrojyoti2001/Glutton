<!DOCTYPE html>
<html>
<head>
	<title>Place Order</title>
	<?php include "includes/html_head.php";
	if ($_SESSION['order_id']){}
	else{
		
		header('Location:cart.php');
	}?>
</head>

<script type="text/javascript">
	$(document).ready(function(){
		$('#apply-giftcard').click(function(){
			let btn_id = $(this);
			let giftcard_code = $(this).siblings('input').val();
			$(this).siblings('input').val('');
			$.ajax({
				url: 'db_control.php?topic=apply_giftcard',
				method:'POST',
				data: {'giftcard_code':giftcard_code},
				success: function(data){
					if(data === 'invalid'){
						$('#discount-div').html("<p style='color:red'>Invalid Coupon code</p>");
					}else if(data === 'expired/inactive'){
						$('#discount-div').html("<p style='color:red'>Coupon expired/inactive</p>");
					}else{
						$('#giftcard-div').hide();
						let total = $('#total-amount').text();
						$('#orginal-amount').html(total);
						let discount_value = (Number(data)/100 * Number(total)).toFixed(2);
						let new_total = Math.round(total - discount_value);
						text = "<h5 style='color:green'>Coupon applied successfully. " + data + "% discount applied. Discounted amount Rs " + discount_value + ".</h5>";
						$('#discount-div').html(text);
						$('#total-amount').text(new_total);
						$('#total-pay').val(new_total);
					}
				},
				error: function(error){
					alert("Some error occurred");
				}
			})
		})
	})
</script>

<?php $status = $_GET['status'];
if ($status == 'no'){
	$query = 'SELECT * FROM address WHERE user_id = '.$_SESSION["user_id"];
	$result = mysqli_query($conn,$query);
	$num_rows = mysqli_num_rows($result);
	echo '<body class="payment-body">
		<div class="card card-body col-md-12 col-sm-12">
			<form action="db_control.php?topic=place_orders" method="POST" class="was-validated">
				<fieldset class="card card-body" style="border: 1px solid orange;">
					<legend>Billing</legend>
					<label for="name">Billing Name</label>
					<input type="text" class="form-control" name="name" value="'.$_SESSION["name"].'" required><br>
					<label for="address">Billing Address</label>';
					if($num_rows != 0){
						echo '<input list="all_addresss" class="form-control" name="address" required autofocus>
							<datalist id="all_addresss">';
							while($row = mysqli_fetch_assoc($result)){
								echo '<option value="'.$row["address"].'">';
							}
							echo '</datalist>';
					}else{
						echo '<h5 class="text-danger">No address founded add a new address</h5>';
							}
					echo '<div class="col-md-2 col-sm-2 mt-3">
						<a class="btn btn-lg btn-primary button-text-hover" data-toggle="modal" data-target="#add-address"><i class="fas fa-map-marked-alt"></i> Add Address</a>
					</div><br>					
				</fieldset><br>
				<fieldset class="card card-body" style="border: 1px solid orange;">
					<legend>Discount</legend>
					<label>Total Amount Rs '.$_SESSION['total'] * 1.18.'</label>
					<div id="giftcard-div">
						<input type="text" name="giftcard" for="giftcard" class="form-control" placeholder="Apply Giftcard"><br>
						<input type="button" id="apply-giftcard" for="apply-giftcard" name="apply-giftcard" class="btn btn-danger button-text-hover" value="Apply">
					</div>
					<div id="discount-div"></div>
				</fieldset><br>
				<fieldset class="card card-body" style="border: 1px solid orange;">
					<legend>Payment</legend>
					<label>Payment Amount Rs <strike id="orginal-amount"></strike> <span id="total-amount">'.$_SESSION['total'] * 1.18.'</span></label>
					<input type="hidden" id="total-pay" name="total-amount" value="'.$_SESSION['total'] * 1.18.'">				
					<div class="display-flex">
						<input type="radio" name="payment" value="Credit Cards" required>
						<label>Credit Cards</label>					
					</div>
					<div class="display-flex">
						<input type="radio" name="payment" value="Dedit Cards">
						<label>Dedit Cards</label>					
					</div>
					<div class="display-flex">
						<input type="radio" name="payment" value="UPI">
						<label>UPI</label>					
					</div>
					<div class="display-flex">
						<input type="radio" name="payment" value="NEFT">
						<label>NEFT</label>
					</div>
					<div class="display-flex">
						<input type="radio" name="payment" value="Wallet">
						<label>Wallet</label>
					</div><br><br>
						<input type="submit" class="btn btn-lg btn-block btn-danger button-text-hover" value="Payment">
				</fieldset>
			</form>
		</div>';
}elseif ($status == 'yes'){
	echo '<body style="background-color: #8484">
		<div id="transactions-loding">
			<div class="d-flex justify-content-center mt-5 mb-5">
				<div class="spinner-border text-info"></div>
			</div><br><br><br>
			<h1 class="text-danger text-center">During transactions do not escape or prees back</h1>
		</div>
		
		<div id="transactions-success" class="mb-5" style="display: none;">
			<div class="d-flex justify-content-center mb-5">
				<img id="success_img" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQgWkOR5_QJ6kTP3XLZCniiu7nNY7RzyYZ2Yw&usqp=CAU">
			</div>
				<h1 class="text-success text-center mt-5">Transaction Successfully</h1>
			<div class="row mt-5">
				<div class="col-md-6 col-sm-6">
					<h2 class="text-success text-center">Order ID: '.$_SESSION["order_id"].'</h1>
				</div>
				<div class="col-md-6 col-sm-6">
					<h2 class="text-success text-center">Transaction ID: '.$_SESSION["transaction_id"].'</h1>
				</div>
			</div><br><br>
			<div class="d-flex justify-content-center mt-4">
				<a class="btn btn-lg btn-secondary button-text-hover mr-2" href="db_control.php?topic=go_back&destination=home"><i class="fas fa-home"></i> Go to Home</a>
				<a class="btn btn-lg btn-primary button-text-hover ml-2" href="db_control.php?topic=go_back&destination=view"><i class="fas fa-shopping-basket"></i> View Orders</a>
			</div>
		</div>
		
		<script>
			setTimeout(showSuccess, 4500);
			function showSuccess(){
				document.getElementById("transactions-loding").style.display = "none";
				document.getElementById("transactions-success").style.display = "block";
			}
		</script>';
}else{
	header('Location:cart.php');
}?>
		<div class="modal fade" id="add-address" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog font-Azeret_Mono">
			    <div class="modal-content">
			    	<div class="modal-header">
			        	<h5 class="modal-title text-warning">Add Address</h5>
			        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          	<span aria-hidden="true">&times;</span>
			        	</button>
			      	</div>
			      	<div class="modal-body">
			        	<form action="db_control.php?topic=add_address" method="POST" class="was-validated">
							<input type="textarea" class="form-control" for="address" name="new-address" placeholder="New Address" required><br>
							<input type="number" class="form-control" for="pin" name="pin" placeholder="Pin" required><br>
							<input type="text" class="form-control" for="landmark" name="landmark" placeholder="Landmark" required><br>
							<input type="number" class="form-control" for="mobile" name="mobile" placeholder="Mobile" required><br>
							<input type="submit" class="form-control" value="Add">
						</form>
			      	</div>
			  	</div>
			</div>
		</div>

		<script type="text/javascript" src="includes/app.js"></script>
	</body>
</html>