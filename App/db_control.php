<?php 
class Glutton{
	public $conn;
	function __construct($task){
    	$this->conn = mysqli_connect("localhost","root","","glutton");
    	session_start();

	    switch ($task){
	    	case 'login':
		        $email = $_POST['email'];
		        $password = $_POST['password'];
		        self::user_login($email,$password);   
		        break;
			
			case 'singup':
				$name = $_POST['user_name'];
				$email = $_POST['user_email'];
				$password = $_POST['user_password'];
				self::user_singup($name,$email,$password);
		    	break;
				
			case 'logout':
				session_unset();
				session_destroy();
			    header('Location:index.php');
			    break;
			
			case 'add_bookmarks':
				$query = "INSERT INTO bookmarks (bookmarks_id, user_id, restaurant_id) VALUES (NULL, ".$_SESSION['user_id'].",".$_SESSION['restaurant_id'].")";
				if(mysqli_query($this->conn,$query)){
					echo "Success";
				}else{
					echo "Failed";
				}				
				break;
			
			case 'delete_bookmarks':
				$query = "DELETE FROM bookmarks WHERE  user_id LIKE ".$_SESSION['user_id']." AND restaurant_id LIKE ".$_SESSION['restaurant_id'];				
				if(mysqli_query($this->conn,$query)){
					echo "Success";
				}else{
					echo "Failed";
				}
				break;
			
			case 'remove_bookmarks':
				$query = "DELETE FROM bookmarks WHERE bookmarks_id = ".$_GET['bookmarks_id'];
				$result = mysqli_query($this->conn,$query);
				header('Location:bookmarks.php');
				break;
			
			case 'add_to_cart':
				if($_GET['dish_name']){
					self::add_to_cart_one();
				}elseif($_POST['id']){
					self::update_cart($_POST['id']);
				}else{
					$dish_list = $_POST;
					self::add_to_cart_array($dish_list);
				}
				break;
			
			case 'remove_from_cart':
				$query = "DELETE FROM carts WHERE cart_id = ".$_POST['id'];
				if(mysqli_query($this->conn,$query)){
					echo "Success";
				}else{
					echo "Failed";
				}
				break;

			case 'add_orders':
				$_SESSION['order_id'] = uniqid();
				header('Location:placeorder.php?status=no');
				break;
			
			case 'place_orders':
				$_SESSION['transaction_id'] = uniqid();
				$name = str_replace("'", "\'", $_POST['name']);
				$name = str_replace('"', '\"', $name);
				$address = str_replace("'", "\'", $_POST['address']);
				$address = str_replace('"', '\"', $address);
				self::place_orders($name,$address);
				break;
			
			case 'add_to_wishlist':
				$dish_list = $_POST;
				self::add_to_wishlist($dish_list);
				break;
			
			case 'remove_from_wishlist':
				$query = "DELETE FROM wishlist WHERE wishlist_id = ".$_GET['wishlist_id'];
				$result = mysqli_query($this->conn,$query);
				header('Location:wishlist.php');
				break;
			
			case 'apply_giftcard':
				$query = "SELECT * FROM giftcards WHERE code LIKE '".$_POST['giftcard_code']."'";
				$result = mysqli_query($this->conn,$query);
				$num_rows = mysqli_num_rows($result);
				if($num_rows == 0){
					echo "invalid";
				}else{
					$result = mysqli_fetch_assoc($result);
					if($result['status'] == 'active'){
						echo $result['discount'];
					}else{
						echo "expired/inactive";
					}
				}
				break;

			case 'add_reviews':
				$headline = str_replace("'", "\'", $_POST['headline']);
				$headline = str_replace('"', '\"', $headline);
				$reviews = str_replace("'", "\'", $_POST['reviews']);
				$reviews = str_replace('"', '\"', $reviews);
				$query = "INSERT INTO reviews (id,reviews_date,user_id,restaurant_id,rating,heading,texts) VALUES (NULL,'".date("Y-m-d")."',".$_SESSION['user_id'].",".$_SESSION['restaurant_id'].",".$_POST['rating'].",'$headline','$reviews')";
				echo $query;
				$result = mysqli_query($this->conn,$query);
				header('Location:restaurante.php?restaurant_id='.$_SESSION["restaurant_id"]);
				break;

			case 'change_name':
				$name = str_replace("'", "\'", $_POST["new-name"]);
				$name = str_replace('"', '\"', $name);
				$query = "UPDATE users SET name = '$name' WHERE user_id = ".$_SESSION['user_id'];
				$result = mysqli_query($this->conn,$query);
				$_SESSION['name'] = $_POST['new-name'];
				header('Location:profile.php?update=name');
				break;

			case 'change_password':
				$password = str_replace("'", "\'", $_POST["re_password"]);
				$password = str_replace('"', '\"', $password);
				$query = "UPDATE users SET password = '$password' WHERE user_id = ".$_SESSION['user_id'];
				$result = mysqli_query($this->conn,$query);
				header('Location:profile.php?update=password');
				break;

			case 'add_address':
				$text = str_replace("'", "\'", $_POST["new-address"]);
				$text = str_replace('"', '\"', $text);
				$landmark = str_replace("'", "\'", $_POST["landmark"]);
				$landmark = str_replace('"', '\"', $landmark);
				$address = $text.".\r\nPin: ".$_POST['pin'].",\r\nLandmark: ".$landmark.",\r\nMobile: ".$_POST['mobile'];
				$query = "INSERT INTO address (sl_no,user_id,address) VALUES (NULL,".$_SESSION['user_id'].",'$address')";
				$result = mysqli_query($this->conn,$query);
				header('Location:placeorder.php?status=no');
				break;

			case 'go_back':
				unset($_SESSION['order_id']);
				unset($_SESSION['total']);
				unset($_SESSION['transaction_id']);
				if($_GET['destination'] == 'home'){
					header('Location:home.php');
				}else{
					header('Location:orders.php?delivery=no');
				}
				break;

			default:
				header('Location:home.php');
				exit;
		}
	}

	function user_login($email,$password){
        $query = "SELECT * FROM users WHERE email LIKE '$email' AND password LIKE '$password'";
        $result = mysqli_query($this->conn,$query);
        $num_rows = mysqli_num_rows($result);
        $data = mysqli_fetch_assoc($result);
        if($num_rows == 1){
			$_SESSION['name'] = $data['name'];
			$_SESSION['user_id'] = $data['user_id'];
			header('Location:home.php');
        }else{
			header('Location:index.php?output=input');
        }
	}

	function user_singup($name,$email,$password){
		$query1 = "SELECT * FROM users WHERE email LIKE '$email'";
		$result1 = mysqli_query($this->conn,$query1);
		$num_rows = mysqli_num_rows($result1);
		if($num_rows == 0){
			$query2 = "INSERT INTO users (user_id,name,email,password) VALUES (NULL,'$name','$email','$password')";
			$result2 = mysqli_query($this->conn,$query2);
			// log in
			self::user_login($email,$password);
		}else{
			header('Location:index.php?output=email');
		}
	}
	
	function add_to_cart_one(){
		$dish = str_replace("'", "\'", strval($_GET['dish_name']));
		$dish = str_replace('"', '\"', $dish);
		$query1 = "SELECT * FROM carts WHERE user_id LIKE ".$_SESSION['user_id']." AND restaurant_id LIKE ".$_GET['restaurant_id']." AND dish_name LIKE '$dish'";
		$result1 = mysqli_query($this->conn,$query1);
		$num_rows = mysqli_num_rows($result1);
		if($num_rows == 0){
			$query = "INSERT INTO carts (cart_id, user_id, restaurant_id, dish_name) VALUES (NULL,".$_SESSION['user_id'].",".$_GET['restaurant_id'].",'".$_GET['dish_name']."')";
		}else{
	        $data = mysqli_fetch_assoc($result1);
	        $query = "UPDATE carts SET quantity = quantity + 1 WHERE cart_id = '".$data["cart_id"]."'";
		}
		$result = mysqli_query($this->conn,$query);
		header('Location:cart.php');
	}
	
	function add_to_cart_array($dish_list){
		foreach($dish_list as $x => $x_value){
			$query = "INSERT INTO carts (cart_id, user_id, restaurant_id, dish_name) VALUES (NULL,".$_SESSION['user_id'].",".$_SESSION['restaurant_id'].",'$x_value')";
			$result = mysqli_query($this->conn,$query);
		}
		header('Location:cart.php');
	}

	function update_cart($id){
		if($_POST['sign'] == '-'){
			$query = "UPDATE carts SET quantity = quantity - 1 WHERE cart_id = '$id'";
			$_SESSION['total'] -= $_POST['cost'];
		}else{
	       	$query = "UPDATE carts SET quantity = quantity + 1 WHERE cart_id = '$id'";
	       	$_SESSION['total'] += $_POST['cost'];
	    }
		if(mysqli_query($this->conn,$query)){
			echo "Success";
		}else{
			echo "Failed";
		}
	}
	
	function place_orders($name,$address){
		$query = 'SELECT * FROM carts JOIN restaurants ON restaurants.restaurant_id = carts.restaurant_id WHERE carts.user_id = '.$_SESSION["user_id"];
		$result = mysqli_query($this->conn,$query);
		while($row = mysqli_fetch_assoc($result)){
			$query1 = "INSERT INTO orders_details (sl_no,orders_id,restaurant_id,name,dish_name,cost,quantity) VALUES (NULL,'".$_SESSION['order_id']."',".$row['restaurant_id'].",'".$row['name']."','".$row['dish_name']."',".$row["cost"].",".$row["quantity"].")";
			$result1 = mysqli_query($this->conn,$query1);
		}
		$query2 = "INSERT INTO orders (orders_id,orders_date,user_id,name,address,amount,transaction_id,payment_method)VALUES ('".$_SESSION['order_id']."','".date("Y-m-d")."',".$_SESSION['user_id'].",'$name','$address',".$_POST['total-amount'].",'".$_SESSION['transaction_id']."','".$_POST['payment']."')";
		$result2 = mysqli_query($this->conn,$query2);
		$query3 = "DELETE FROM carts WHERE user_id = ".$_SESSION['user_id'];
		$result3 = mysqli_query($this->conn,$query3);
		header('Location:placeorder.php?status=yes');				
	}
	
	function add_to_wishlist($dish_list){
		foreach($dish_list as $x => $x_value){
			$query = "INSERT INTO wishlist (wishlist_id, user_id, restaurant_id, dish_name) VALUES (NULL,".$_SESSION['user_id'].",".$_SESSION['restaurant_id'].",'$x_value')";
			$result = mysqli_query($this->conn,$query);
		}
		header('Location:wishlist.php');
	}
}

$topic = $_GET['topic'];
new Glutton($topic);
?>