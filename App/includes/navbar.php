<div id="glutton_navbar" class="navbar text-white fixed-top">
	<a class="rotation_720" href="home.php"><h1 class="font-Lucida_Handwriting logo-display col-3 col-sm-2 text-white" style="margin: 0px">Glutton</h1></a>
	
	<div class="col-6 col-sm-7">
		<form action="search.php" method="GET" style="display: flex;">
			<input placeholder="Search for restaurant, cuisine or a dish" type="text" class="form-control col-11 col-sm-11" name="term">
			<button type="submit" id="navbar_search_button" class="btn btn-warning col-2 col-sm-1 button-text-hover"><i class="fas fa-search"></i></button>
		</form>
	</div>
	
	<div class="dropdown col-1 col-sm-1 text-center">
		<button class="btn button-text-hover dropdown-toggle navbar_button" data-toggle="dropdown"><h4 style="display: inline;"><i class="fas fa-user"></i></h4></button>
		<div class="dropdown-menu dropdown-menu-right font-Azeret_Mono">
	    	<h4 class="dropdown-header"><b><i><?php echo $_SESSION["name"]?></i></b></h4>
	    	<div class="dropdown-divider"></div>
	    	<a class="dropdown-item btn" href="profile.php?update=none"><i class="fas fa-user"></i> My Profile</a>
	    	<div class="dropdown-divider"></div>
	    	<a class="dropdown-item btn" href="bookmarks.php"><i class="fad fa-bookmark"></i> Bookmarks</a>
	    	<a class="dropdown-item btn" href="wishlist.php"><i class="fas fa-heart"></i> Wishlist</a>
	    	<a class="dropdown-item btn" data-toggle="modal" data-target="#giftcards"><i class="fas fa-gift-card"></i> Giftcards</a>
	    	<div class="dropdown-divider"></div>
	    	<a class="dropdown-item btn" onclick="logout()"><i class="far fa-sign-out"></i> Log out</a>
	    </div>
	</div>
	
	<div class="dropdown col-1 col-sm-1 text-center">
		<button class="btn button-text-hover dropdown-toggle navbar_button" data-toggle="dropdown"><h4 style="display: inline;"><i class="fas fa-truck-container"></i></h4></button>
		<div class="dropdown-menu dropdown-menu-right font-Azeret_Mono">
	    	<h4 class="dropdown-header"><b><i>Orders</i></b></h4>
	    	<div class="dropdown-divider"></div>
	    	<a class="dropdown-item btn" href="orders.php?delivery=no"><i class="fas fa-shipping-fast"></i> Ongoing Delivery</a>
	    	<a class="dropdown-item btn" href="orders.php?delivery=yes"><i class="fas fa-handshake"></i> Delivered</a>
	    </div>
	</div>	
	<div class="col-1 col-sm-1 text-center">
		<button class="btn button-text-hover navbar_button" onclick="window.location.href ='cart.php'"><h4><i class="fas fa-cart-arrow-down"></i></h4></button>
	</div>
</div>

<div class="modal fade" id="giftcards" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog font-Azeret_Mono">
	    <div class="modal-content">
	    	<div class="modal-header">
	        	<h5 class="modal-title text-warning">Active Giftcards</h5>
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          	<span aria-hidden="true">&times;</span>
	        	</button>
	      	</div>
	      	<div class="modal-body">
	      		<?php $query1 = "SELECT * FROM giftcards WHERE status LIKE 'active'";
				$result1 = mysqli_query($conn,$query1);
		        $num_rows1 = mysqli_num_rows($result1);
				$data1 = mysqli_fetch_assoc($result1);
				if ($num_rows1 == 1){
	        		echo '<label class="text-success">'.$data1["card_name"].'</label><br>
        			<label class="text-danger">'.$data1["discount"].'% discount</label>';
        		}else{
        			echo '<label>No card Active</label';
        		}?>
           	</div>
	  	</div>
	</div>
</div>
