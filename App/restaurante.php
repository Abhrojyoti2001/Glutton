<!DOCTYPE html>
<html>
<head>
	<title>Glutton</title>
	<?php include "includes/html_head.php";?>
</head>

<body style='background-color: #BDBDBD';>
	<?php include "includes/navbar.php";
	$_SESSION['restaurant_id'] = $_GET['restaurant_id'];
	$query = "SELECT * FROM restaurants WHERE restaurant_id = ".$_SESSION['restaurant_id'];
	$result = mysqli_query($conn,$query);
	$data = mysqli_fetch_assoc($result);
	$larg_img = explode(', ',substr($data['img-lg'],1,(strlen($data['img-lg'])-2)));
	$mobile = explode(' ', $data['phone']);
	$dish = explode(", ",substr($data['menu'],1,(strlen($data['menu'])-2)));

	$query2 = "SELECT * FROM reviews WHERE restaurant_id = ".$_SESSION['restaurant_id'];
	$result2 = mysqli_query($conn,$query2);
    $num_rows2 = mysqli_num_rows($result2);
	$counter = 0;
	$total = 0;
	if($num_rows2 != 0){
		while($row2 = mysqli_fetch_assoc($result2)){
			$counter++;
			$total = $total + $row2['rating'];
		}
	}
	if($counter == 0){
		$avg_rating = 0.0;
		$num_rows2 = 'No';
	}else{
		$avg_rating = $total/$counter;
	}
	if($avg_rating <= 1.6){
		$rating_color = 'bg-danger';
	}elseif($avg_rating > 1.6 && $avg_rating <= 3.3){
		$rating_color = 'bg-warning';
	}else{
		$rating_color = 'bg-success';
	}
	echo'<h6 class="font-Azeret_Mono ml-5 pl-3 pb-3" style="margin-top: 54px;padding-top: 34px;"><b><a href="home.php">Home</a>/<a href="category.php?category='.$data["category"].'">'.$data["category"].'</a>/<a href="">'.$data["name"].'</a></b></h6>
		
		<div class="container col-md-12 col-sm-12">
			<div class="card card-body col-md-12 col-sm-12">
				<div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="2700" data-pause="hover">
				  	<ol class="carousel-indicators">
					  	<li data-target="#myCarousel" data-slide-to="0" class="active"></li>';
					  	$row = 1;
					    while($row < count($larg_img)){
						  	echo '<li data-target="#myCarousel" data-slide-to="'.$row.'"></li>';
						  	$row++;
					    }
					echo '</ol>

				    <div class="carousel-inner">
				    	<div class="carousel-item active">
				      		<img src="'.$larg_img[0].'">
				    	</div>';
				    	$row = 1;
					    while($row < count($larg_img)){
					    	echo'<div class="carousel-item">
				      			<img src="'.$larg_img[$row].'">
				    		</div>';
				    		$row++;
				    	}
				    echo '</div>

				    <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
				    	<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				    	<span class="sr-only">Previous</span>
				  	</a>
				  	
				  	<a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
				    	<span class="carousel-control-next-icon" aria-hidden="true"></span>
				    	<span class="sr-only">Next</span>
				  	</a>
				</div>
			</div>
			<hr>
			<div class="row ml-2 mr-2">
				<div class="card card-body col-md-10 col-sm-9">
					<h1 class="font-Dancing_Script text-primary">'.$data["name"].'</h1>
					<p><b class="btn-sm '.$rating_color.' text-white font-Lucida_Handwriting">'.$avg_rating.' <i class="fas fa-star"></i></b><span class="text-muted"> '.$num_rows2.' Rating & Reviews</span></p>
					<p>'.$data["cuisines"].'</p>
					<p class="text-muted">'.$data["address"].'</p>
					<div id="#button-container">
						<button id="add-review" class="btn button-text-hover bg-danger btn-lg"><i class="far fa-star"></i> Add Review</button>
						<a href="https://www.google.com/maps/dir/?api=1&destination='.$data["location"].'" target="_blank" class="btn button-text-hover bg-secondary btn-lg"><i class="far fa-directions"></i> Direction</a>
						<button id="bookmarks-btn" class="btn button-text-hover btn-lg ';
						$query1 = "SELECT * FROM bookmarks WHERE user_id LIKE ".$_SESSION['user_id']." AND restaurant_id LIKE ".$_SESSION['restaurant_id'];
						$result1 = mysqli_query($conn,$query1);
						$num_rows = mysqli_num_rows($result1);
						if($num_rows == 0){
							echo 'btn-success" onclick="add_bookmarks()"><i class="fad fa-bookmark"></i> Bookmark';
						}else{
							echo 'btn-danger" onclick="remove_bookmarks()"><i class="fad fa-book-open"></i> Remove Bookmark';
						}
						echo '</button>
					</div>
				</div>
				
				<div class="card card-body col-md-2 col-sm-3" style="background-color: #ACFA58;">
					<h4 class="font-Lucida_Handwriting"><i class="fal fa-phone-alt"></i> Call</h4>
					<p class="text-primary"><b>';
					$row = 0;
					while($row < count($mobile)){
						echo $mobile[$row].'<br>';
						$row++;
					}
					echo '</b></p>
				</div>
			</div>
		</div>
		<hr>
		<div id="details" class="card-body bg-medium-turquoise">
			<form style="margin-top: 15px;">
				<input type="radio" name="open_details" value="Menu" id="Menu" class="btn"><label for="Menu" class="col-3 col-sm-3"><b><i>Menu</i></b></label>
				<input type="radio" name="open_details" value="Reviews" id="Reviews" class="btn"><label for="Reviews" class="col-3 col-sm-3"><b><i>Reviews</i></b></label>				
			</form>
		</div>
		<hr>
		<div id="select-star"></div>
		<div id="details-1"></div>
	</div>'?>
	
	<script type="text/javascript" src="includes/app.js"></script>

	<script type="text/javascript">
		$(document).ready(function(){
			$('#add-review').click(function(){
				$("#select-star").html("");
				text = `<form action="db_control.php?topic=add_reviews" method="POST" class="was-validated card card-body mt-5" style="background-color: #8484">
					<label for="rating"><h5>Overall Rating (0-5):</h5></label>
					<div class="bg-info">
						<a id="star-1" class="btn button-text-hover btn-lg" onclick=star(1)><i class="far fa-star"></i></a>
						<a id="star-2" class="btn button-text-hover btn-lg" onclick=star(2)><i class="far fa-star"></i></a>
						<a id="star-3" class="btn button-text-hover btn-lg" onclick=star(3)><i class="far fa-star"></i></a>
						<a id="star-4" class="btn button-text-hover btn-lg" onclick=star(4)><i class="far fa-star"></i></a>
						<a id="star-5" class="btn button-text-hover btn-lg" onclick=star(5)><i class="far fa-star"></i></a>
						<input id="total-star" type="hidden"  name="rating" value="0">
					</div><br>
					<label for="headline"><h5>Add a headline</h5></label>
					<input type="text" name="headline" class="form-control" placeholder="What's most important to know?" required><br>
					<label for="reviews"><h5>Add a written review</h5></label>
					<textarea name="reviews" class="form-control" placeholder="What did you like or dislike?" required></textarea><br><br>
					<input type="submit" value="Submit" class="btn btn-lg button-text-hover bg-danger">
				</form><br>`;
				$("#details-1").html(text);
			})
			$('#Menu').click(function(){
				$("#select-star").html("");
				text = `<form id="menu-list-form" method="POST" class="was-validated card card-body m-3" style="overflow: auto;background-color: #8484;height: 400px;">
					<?php $row = 0;
					while($row < count($dish)){
						$Menu_item = substr($dish[$row],1,(strlen($dish[$row])-2));
						echo '<div style="display: flex;">
							<input type="checkbox" name="'.$Menu_item.'" value="'.$Menu_item.'" class="ml-4">
							<label for="Menu_item" class="ml-4"><pre><h4><i>'.$Menu_item.'    </i><span class="text-white">    Cost '.$data["cost"].'.00</h4></pre></label>
						</div>';
						$row++;
					}?>
					<div class="row col-md-12 col-sm-12 fixed-bottom">
						<div class="card-body col-md-4 col-sm-4 text-center">
							<a class="btn btn-lg button-text-hover btn-danger" onclick="menuListControl('wishlist')"><i class="fas fa-heart"></i> Add to Wishlist</a>
						</div>
						<div class="card-body col-md-4 col-sm-4 text-center">
							<a class="btn btn-lg button-text-hover btn-warning" onclick="menuListControl('close')"><i class="fas fa-arrow-alt-to-top"></i> Close Menu</a>
						</div>
						<div class="card-body col-md-4 col-sm-4 text-center">
							<a class="btn btn-lg button-text-hover btn-primary" onclick="menuListControl('cart')"><i class="fas fa-cart-plus"></i> Add to Cart</a>
						</div>
					</div>
				</form>`;
				$("#details-1").html(text);		
			})
			$('#Reviews').click(function(){
				$("#details-1").html("");
				text = `<form style="margin: 15px;">
					<input type="radio" name="star" id="review-1-star" class="btn"><label class="col-2"><b><i>1 star</i></b></label>
					<input type="radio" name="star" id="review-2-star" class="btn"><label class="col-2"><b><i>2 star</i></b></label>
					<input type="radio" name="star" id="review-3-star" class="btn"><label class="col-2"><b><i>3 star</i></b></label>
					<input type="radio" name="star" id="review-4-star" class="btn"><label class="col-2"><b><i>4 star</i></b></label>
					<input type="radio" name="star" id="review-5-star" class="btn"><label class="col-2"><b><i>5 star</i></b></label>
				</form>
				<hr>`;
				$("#select-star").html(text);
			})
			$('#select-star').on('click','#review-1-star',function(){
				<?php $query3 = "SELECT * FROM reviews WHERE restaurant_id LIKE ".$_SESSION['restaurant_id']." AND rating LIKE 1";
				$result3 = mysqli_query($conn,$query3);
			    $num_rows3 = mysqli_num_rows($result3);
				?>
				text = `<?php echo '<div class="card-body bg-white" style="overflow: auto;height: 400px;">';
				if($num_rows3 != 0){
					while($row = mysqli_fetch_assoc($result3)){
						echo "<p class='btn m-0'>1 <i class='fas fa-star'></i></p>
						<h4 class='font-Dancing_Script m-0' style='display: inline;'><b>".$row['heading']."</b></h4>
						<p class='text-muted'>".$row['reviews_date']."</p>
						<p class='font-Azeret_Mono'>&emsp;&emsp;".$row['texts']."</p><hr>";
					}
				}else{
					echo '<h1 class="text-danger text-center">No reviews available</h1>';
				}
				echo '</div>';?>`;
				$("#details-1").html(text);
			})
			$('#select-star').on('click','#review-2-star',function(){
				<?php $query3 = "SELECT * FROM reviews WHERE restaurant_id LIKE ".$_SESSION['restaurant_id']." AND rating LIKE 2";
				$result3 = mysqli_query($conn,$query3);
			    $num_rows3 = mysqli_num_rows($result3);?>
				text = `<?php echo '<div class="card-body bg-white" style="overflow: auto;height: 400px;">';
				if($num_rows3 != 0){
					while($row = mysqli_fetch_assoc($result3)){
						echo "<p class='btn m-0'>2 <i class='fas fa-star'></i></p>
						<h4 class='font-Dancing_Script m-0' style='display: inline;'><b>".$row['heading']."</b></h4>
						<p class='text-muted'>".$row['reviews_date']."</p>
						<p class='font-Azeret_Mono'>&emsp;&emsp;".$row['texts']."</p><hr>";
					}
				}else{
					echo '<h1 class="text-danger text-center">No reviews available</h1>';
				}
				echo '</div>';?>`;
				$("#details-1").html(text);
			})
			$('#select-star').on('click','#review-3-star',function(){
				<?php $query3 = "SELECT * FROM reviews WHERE restaurant_id LIKE ".$_SESSION['restaurant_id']." AND rating LIKE 3";
				$result3 = mysqli_query($conn,$query3);
			    $num_rows3 = mysqli_num_rows($result3);?>
				text = `<?php echo '<div class="card-body bg-white" style="overflow: auto;height: 400px;">';
				if($num_rows3 != 0){
					while($row = mysqli_fetch_assoc($result3)){
						echo "<p class='btn m-0'>3 <i class='fas fa-star'></i></p>
						<h4 class='font-Dancing_Script m-0' style='display: inline;'><b>".$row['heading']."</b></h4>
						<p class='text-muted'>".$row['reviews_date']."</p>
						<p class='font-Azeret_Mono'>&emsp;&emsp;".$row['texts']."</p><hr>";
					}
				}else{
					echo '<h1 class="text-danger text-center">No reviews available</h1>';
				}
				echo '</div>';?>`;
				$("#details-1").html(text);
			})
			$('#select-star').on('click','#review-4-star',function(){
				<?php $query3 = "SELECT * FROM reviews WHERE restaurant_id LIKE ".$_SESSION['restaurant_id']." AND rating LIKE 4";
				$result3 = mysqli_query($conn,$query3);
			    $num_rows3 = mysqli_num_rows($result3);?>
				text = `<?php echo '<div class="card-body bg-white" style="overflow: auto;height: 400px;">';
				if($num_rows3 != 0){
					while($row = mysqli_fetch_assoc($result3)){
						echo "<p class='btn m-0'>4 <i class='fas fa-star'></i></p>
						<h4 class='font-Dancing_Script m-0' style='display: inline;'><b>".$row['heading']."</b></h4>
						<p class='text-muted'>".$row['reviews_date']."</p>
						<p class='font-Azeret_Mono'>&emsp;&emsp;".$row['texts']."</p><hr>";
					}
				}else{
					echo '<h1 class="text-danger text-center">No reviews available</h1>';
				}
				echo '</div>';?>`;
				$("#details-1").html(text);
			})
			$('#select-star').on('click','#review-5-star',function(){
				<?php $query3 = "SELECT * FROM reviews WHERE restaurant_id LIKE ".$_SESSION['restaurant_id']." AND rating LIKE 5";
				$result3 = mysqli_query($conn,$query3);
			    $num_rows3 = mysqli_num_rows($result3);?>
				text = `<?php echo '<div class="card-body bg-white" style="overflow: auto;height: 400px;">';
				if($num_rows3 != 0){
					while($row = mysqli_fetch_assoc($result3)){
						echo "<p class='btn m-0'>5 <i class='fas fa-star'></i></p>
						<h4 class='font-Dancing_Script m-0' style='display: inline;'><b>".$row['heading']."</b></h4>
						<p class='text-muted'>".$row['reviews_date']."</p>
						<p class='font-Azeret_Mono'>&emsp;&emsp;".$row['texts']."</p><hr>";
					}
				}else{
					echo '<h1 class="text-danger text-center">No reviews available</h1>';
				}
				echo '</div>';?>`;
				$("#details-1").html(text);
			})			
		})
	</script>
</body>
</html>