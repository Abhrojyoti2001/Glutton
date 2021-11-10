<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<?php include "includes/html_head.php";?>
</head>

<body>
	<?php include "includes/navbar.php";?>
	<div class="card card-body col-md-12 col-sm-12" style="margin-top: 65px;">
		<div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="2700" data-pause="hover">
		  	<ol class="carousel-indicators">
		      	<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
		      	<li data-target="#myCarousel" data-slide-to="1"></li>
		      	<li data-target="#myCarousel" data-slide-to="2"></li>
		      	<li data-target="#myCarousel" data-slide-to="3"></li>
		      	<li data-target="#myCarousel" data-slide-to="4"></li>
		      	<li data-target="#myCarousel" data-slide-to="5"></li>
		      	<li data-target="#myCarousel" data-slide-to="6"></li>
		      	<li data-target="#myCarousel" data-slide-to="7"></li>
		      	<li data-target="#myCarousel" data-slide-to="8"></li>
		      	<li data-target="#myCarousel" data-slide-to="9"></li>
		    </ol>
			
			<div class="carousel-inner">
		    	<div class="carousel-item active">
		      		<img src="https://b.zmtcdn.com/web_assets/81f3ff974d82520780078ba1cfbd453a1583259680.png">
		    	</div>
		    
		    	<div class="carousel-item">
		      		<img src="https://wallpaperaccess.com/full/767033.jpg">
		    	</div>
			    
			    <div class="carousel-item">
			      	<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS5--hVYsJYcW45GJz84unrz1YVZdrgWAvKOQ&usqp=CAU">
			    </div>

			    <div class="carousel-item">
			      	<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSlmYQ0Gbyw6tL0es4pf-6AsgIc_1mOehndew&usqp=CAU">
			    </div>

			    <div class="carousel-item">
			      	<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ4M7sqRyUvzzQoZmod5qLbrrOdoC-W4qWfHQ&usqp=CAU">
			    </div>

			    <div class="carousel-item">
			      	<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTStPWzr2GElQifIruuMIGhMOC_tq2TWn9dQQ&usqp=CAU">
			    </div>
			    
			    <div class="carousel-item">
			      	<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQDkLvdMHZvZm-MG0Ex8T9rTk4T4UMjWh4TjQ&usqp=CAU">
			    </div>
			    <div class="carousel-item">
			      	<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRy9Xw__q4_UsXFaRg-3nM6Gt552MO32G6V2A&usqp=CAU">
			    </div>
			    
			    <div class="carousel-item">
			      	<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTQo-VQi9V5DOrMvey5LzWUkdlsXyDR_lrBAQ&usqp=CAU">
			    </div>

			    <div class="carousel-item">
			      	<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcREAW6AHZuQtR_1d9WPZn5mjK_jG-aAJxYfLQ&usqp=CAU">
			    </div>
			</div>
		  	
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
	
	<div class="card card-body" style="background-color: #8484">
		<a href="category.php?category=Desserts" class="col-md-2 col-sm-2 rotation_720 ml-4 mb-4 p-0 text-center"><h1>Desserts</h1></a>
		<div class="row col-md-12 col-sm-12">
			<?php $query = "SELECT * FROM `restaurants` WHERE category LIKE 'Desserts' LIMIT 4";
			$result = mysqli_query($conn,$query);
			while($row = mysqli_fetch_assoc($result)){
				$query2 = "SELECT * FROM reviews WHERE restaurant_id = ".$row['restaurant_id'];
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
				echo '<div class="col-md-3 col-sm-6 mb-4">
					<a class="card clickable-card"  href="restaurante.php?restaurant_id='.$row["restaurant_id"].'">
						<div class="card-body">
							<img src='.$row["img-sm"].' width="100%">
							<h1 class="font-Dancing_Script text-primary">'.$row["name"].'</h1>
							<h5 class="font-Azeret_Mono text-danger">'.$row["cuisines"].'</h5>
							<h6 class="font-Azeret_Mono text-dark">'.$row["city"].'</h6>
							<p><b class="btn-sm '.$rating_color.' text-white font-Lucida_Handwriting">'.$avg_rating.' <i class="fas fa-star"></i></b><span class="text-muted"> '.$num_rows2.' Rating & Reviews</span></p>
						</div>
					</a>
				</div>';
			}?>
		</div>
		
		<a href="category.php?category=Cafes" class="col-md-2 col-sm-2 rotation_720 ml-4 mb-4 p-0 text-center"><h1>Cafes</h1></a>
		
		<div class="row col-md-12 col-sm-12">
			<?php $query = "SELECT * FROM restaurants WHERE category LIKE 'Cafes' LIMIT 4";
			$result = mysqli_query($conn,$query);
			while($row = mysqli_fetch_assoc($result)){
				$query2 = "SELECT * FROM reviews WHERE restaurant_id = ".$row['restaurant_id'];
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
				echo '<div class="col-md-3 col-sm-6 mb-4">
					<a class="card clickable-card"  href="restaurante.php?restaurant_id='.$row["restaurant_id"].'">
						<div class="card-body">
							<img src='.$row["img-sm"].' width="100%">
							<h1 class="font-Dancing_Script text-primary">'.$row["name"].'</h1>
							<h5 class="font-Azeret_Mono text-danger">'.$row["cuisines"].'</h5>
							<h6 class="font-Azeret_Mono text-dark">'.$row["city"].'</h6>
							<p><b class="btn-sm '.$rating_color.' text-white font-Lucida_Handwriting">'.$avg_rating.' <i class="fas fa-star"></i></b><span class="text-muted"> '.$num_rows2.' Rating & Reviews</span></p>
						</div>
					</a>
				</div>';
			}?>
		</div>
		
		<a href="category.php?category=Buffet" class="col-md-2 col-sm-2 rotation_720 ml-4 mb-4 p-0 text-center"><h1>Buffet</h1></a>

		<div class="row col-md-12 col-sm-12">
			<?php $query = "SELECT * FROM restaurants WHERE category LIKE 'Buffet' LIMIT 4";
			$result = mysqli_query($conn,$query);
			while($row = mysqli_fetch_assoc($result)){
				$query2 = "SELECT * FROM reviews WHERE restaurant_id = ".$row['restaurant_id'];
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
				echo '<div class="col-md-3 col-sm-6 mb-4">
					<a class="card clickable-card"  href="restaurante.php?restaurant_id='.$row["restaurant_id"].'">
						<div class="card-body">
							<img src='.$row["img-sm"].' width="100%">
							<h1 class="font-Dancing_Script text-primary">'.$row["name"].'</h1>
							<h5 class="font-Azeret_Mono text-danger">'.$row["cuisines"].'</h5>
							<h6 class="font-Azeret_Mono text-dark">'.$row["city"].'</h6>
							<p><b class="btn-sm '.$rating_color.' text-white font-Lucida_Handwriting">'.$avg_rating.' <i class="fas fa-star"></i></b><span class="text-muted"> '.$num_rows2.' Rating & Reviews</span></p>
						</div>
					</a>
				</div>';
			}?>
		</div>
	</div>
	
	<script type="text/javascript" src="includes/app.js"></script>
</body>
</html>