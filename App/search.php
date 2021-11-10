<!DOCTYPE html>
<html>
<head>
	<title>Search</title>
	<?php include "includes/html_head.php";?>
</head>

<body>
	<?php include "includes/navbar.php";
	$term = $_GET['term'];?>
	<div class="card card-body col-md-12 col-sm-12" style="margin-top: 65px;background-color: #8484">
		<h1 class="ml-4 mb-4"><?php echo $term;?></h1>
		<div class="row col-md-12 col-sm-12">
			<?php $query = "SELECT * FROM restaurants WHERE name LIKE '%$term%' OR cuisines LIKE '%$term%' OR menu LIKE '%$term%'";
			$result = mysqli_query($conn,$query);
			$num_rows = mysqli_num_rows($result);
			if($num_rows != 0){
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
				}
			}else{
				echo '<h1 class="text-danger text-center">No result found</h1>';
			}?>
		</div>
	</div>

	<script type="text/javascript" src="includes/app.js"></script>
</body>
</html>	