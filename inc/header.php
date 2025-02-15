<?php
    include 'lib/session.php';
    Session::init();
?>
<?php
	include 'lib/database.php';
	include 'helper/format.php';

	spl_autoload_register(function($className)
	{
		include_once "classes/".$className.".php";
	});
	
	$db = new Database();
	$fm = new Format();
	$user = new user();
	$cart = new cart();
	$cus = new customer();
	$cat = new category();	
	$prd = new product();

?>


<?php
  header("Cache-Control: no-cache, must-revalidate");
  header("Pragma: no-cache"); 
  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 
  header("Cache-Control: max-age=2592000");
?>

<!DOCTYPE HTML>
<head>
<title>Store Website</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
<!------ Include the above in your HEAD tag ---------->

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
<link href="css/menu.css" rel="stylesheet" type="text/css" media="all"/>
<link href="css/header.css" rel="stylesheet" type="text/css" media="all"/>

<script src="js/jquerymain.js"></script>
<script src="js/script.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script> 
<script type="text/javascript" src="js/nav.js"></script>
<script type="text/javascript" src="js/move-top.js"></script>
<script type="text/javascript" src="js/easing.js"></script> 
<script type="text/javascript" src="js/nav-hover.js"></script>
<link href='http://fonts.googleapis.com/css?family=Monda' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Doppio+One' rel='stylesheet' type='text/css'>
<script type="text/javascript">
  $(document).ready(function($){
    $('#dc_mega-menu-orange').dcMegaMenu({rowItems:'4',speed:'fast',effect:'fade'});
  });
</script>
</head>
<body>
  <div class="wrap">
	  		<!-- new header -->
		<div style="font-family: 'Monda';" class="menu">
			<a href="index.php">
				<div class="logo" id="logo-in-menu"></div>
			</a>

			<ul id="dc_mega-menu-orange" class="dc_mm-orange" style="background-image: none;">
				<li class=""><a style="font-family:Monda" href="index.php">TRANG CHỦ</a></li>
				<li class=""><a style="font-family:Monda" href="products.php">SẢN PHẦM</a> </li>
				<li class=""><a style="font-family:Monda" href="topbrands.php">Top Brands</a></li>
				<?php
				$check_cart = $cart->check_cart();
				if ($check_cart) {
					echo '<li><a style="font-family:Monda" href="cart.php">GIỎ HÀNG</a></li>';
				} else {
					echo '';
				}
				?>
				<?php
				$cusid = Session::get('customer_id');
				$check_order = $cart->check_order($cusid);
				if ($check_order) {
					echo '<li><a style="font-family:Monda" href="orderdone.php">ĐƠN HÀNG</a></li>';
				} else {
					echo '';
				}
				?>
				<li><a style="font-family:Monda" href="contact.php">Contact</a> </li>
				<?php
				$login_check = Session::get('customer_login');
				if ($login_check) {
					echo '<li><a style="font-family:Monda" href="profile.php">Profile</a> </li>';
				} else {
					echo '';
				}
				?>
				<div class="clear"></div>
			</ul>

			<div class="header_in_menu">
				<div class="search_box">
					<form action="search.php" method="POST">
						<input type="text" name="keyword" placeholder="Tìm kiếm sản phẩm"><input type="hidden" name="search" value=""><input type="image" src="images/white-search.png" width="45">
					</form>
				</div>
				<div class="shopping_cart">
					<div class="cart" style="margin-top:2px">
						<?php
						$login_check = Session::get('customer_login');
						if ($login_check) {
							echo '<a href="favorite.php" title="Sản phẩm yêu thích" rel="nofollow">
		   											<img width="30px" src="images/heart.png" alt="">
		   										</a>';
						} else {
							echo '';
						}
						?>
					</div>
					<div class="cart">
						<a href="cart.php" title="Giỏ hàng" rel="nofollow">
							<img width="30px" src="images/cart.png" alt="">
						</a>
					</div>

				</div>
				<?php
				if (isset($_GET['customerid'])) {
					$deytroyCart = $cart->destroy_cart();
					Session::destroy();
				}
				?>
				<div class="login">
					<?php
					$login_check = Session::get('customer_login');
					if ($login_check) {
						echo '<a href="?customerid=' . Session::get('customer_id') . '" title="Đăng xuất"><img width="30px" src="images/admin.png" alt=""></a>';
					} else {
						echo '<a href="login.php" title="Đăng nhập"><img width="30px" src="images/admin.png" alt=""></a>';
					}
					?>
				</div>
				<div class="account_title">
					<?php
					$login_check = Session::get('customer_login');
					if ($login_check) {
						echo '<a href="?customerid=' . Session::get('customer_id') . '" title="Đăng xuất">Đăng xuất</a>';
					} else {
						echo '<a href="login.php" title="Đăng nhập">Đăng nhập</a>';
					}
					?>
				</div>
			</div>


		</div>
		<!-- end new header -->
 
