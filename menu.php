<?php include "lib/mfbconnect.php"; ?>
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu-v.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js">
	/***********************************************
	 * Smooth Navigational Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
	 * This notice MUST stay intact for legal use
	 * Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
	 ***********************************************/
</script>


<script type="text/javascript">
	ddsmoothmenu.init({
		mainmenuid: "smoothmenu1", //menu DIV id
		orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
		classname: 'ddsmoothmenu', //class added to menu's outer DIV
		//customtheme: ["#1c5a80", "#18374a"],
		contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
	})

	ddsmoothmenu.init({
		mainmenuid: "smoothmenu2", //Menu DIV id
		orientation: 'v', //Horizontal or vertical menu: Set to "h" or "v"
		classname: 'ddsmoothmenu-v', //class added to menu's outer DIV
		//customtheme: ["#804000", "#482400"],
		contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
	})
</script>
<style>
	ul {
		list-style: none;
		padding: 0;
		margin: 0 !important;
	}

	.nav {
		background-color: #03363D;
		width: 100px;
		height: 100vh;
	}

	.nav_item {
		padding: 0;
		margin: 0;
		padding: 15px 10px;
		margin-bottom: 1px;
		cursor: pointer;
	}

	.nav_item:hover {
		background-image: linear-gradient(to right, rgba(255, 255, 255, .5), rgba(255, 255, 255, .5));
	}

	.nav_item>a {
		text-decoration: none;
		color: #fff;
		display: flex;
		justify-content: center;
	}

	.nav_item>ul {
		display: none;
		position: absolute;
		top: 0px;
		left: 109px;
		background: #fff;
		padding: 20px;
		width: 180px;
		height: 100vh;
		z-index: 20;
	}

	.nav_item>ul>li {
		padding: 10px 0;
	}

	.nav_item>ul>li>a {
		color: #ABB1B7;
		font-size: 15px;
		text-decoration: none;
	}

	.nav_item:hover>ul {
		display: block;
	}
</style>
<!-- <div id="smoothmenu1" class="ddsmoothmenu"> -->


<div class="nav">
	<div style="display:flex; justify-content: center;margin:15px 0;">
		<img src="./images/logo copy.png" />
	</div>
	<ul>
		<?php
		//$my_db = mysql_select_db("for_db");
		//$sql = "select * from menu where menu_level='0' order by menu_order";
		$role_id = $_SESSION['role_id_sess'];
		$sql = "select * from menu where menu_level='0' and menu_id in (select menu_id from menugroup where role_id ='$role_id') order by menu_order";

		//$sql = "select * from menu where menu_level='0'  order by menu_order";
		//echo $sql;



		$result = mysqli_query($_SESSION['db_connect'], $sql);
		$numrows = mysqli_num_rows($result);
		for ($i = 0; $i < $numrows; $i++) {
			$row = mysqli_fetch_array($result);
			$menu_id = $row['menu_id'];
			$parent_id = $row['parent_id'];
			$menu_level = $row['menu_level'];

			switch ($row['menu_name']) {
				case 'File':
					echo "<li class=\"nav_item\"><a href='$row[menu_url]'> <svg width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">
					<path d=\"M8.25 15C10.9424 15 13.125 12.8174 13.125 10.125C13.125 7.43261 10.9424 5.25 8.25 5.25C5.55761 5.25 3.375 7.43261 3.375 10.125C3.375 12.8174 5.55761 15 8.25 15Z\" stroke=\"white\" stroke-width=\"1.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>
					<path d=\"M14.5703 5.43173C15.2408 5.24281 15.9441 5.19978 16.6326 5.30552C17.3212 5.41126 17.9791 5.66333 18.562 6.04475C19.1449 6.42616 19.6393 6.92807 20.012 7.51666C20.3846 8.10525 20.6268 8.76685 20.7221 9.45692C20.8175 10.147 20.764 10.8495 20.565 11.5171C20.366 12.1847 20.0263 12.8019 19.5687 13.3272C19.1111 13.8524 18.5463 14.2735 17.9123 14.5621C17.2782 14.8507 16.5897 15.0001 15.8931 15.0001\" stroke=\"white\" stroke-width=\"1.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>
					<path d=\"M1.5 18.5059C2.26138 17.4229 3.27215 16.539 4.44698 15.9288C5.62182 15.3186 6.92623 15.0001 8.25008 15C9.57393 14.9999 10.8784 15.3184 12.0532 15.9285C13.2281 16.5386 14.239 17.4225 15.0004 18.5054\" stroke=\"white\" stroke-width=\"1.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>
					<path d=\"M15.8926 15C17.2166 14.999 18.5213 15.3171 19.6962 15.9273C20.8712 16.5375 21.8819 17.4218 22.6426 18.5054\" stroke=\"white\" stroke-width=\"1.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>
					</svg>
					 </a>";
					break;

				case 'All Modules':
					echo " <li title='All Modules' class=\"nav_item\"><a href='$row[menu_url]'> <svg width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">
					<path d=\"M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z\" stroke=\"#D9D9D9\" stroke-width=\"2\"/>
					<path d=\"M9.44331 3.49277C10.215 0.835742 13.785 0.835742 14.5567 3.49277C14.9674 4.90707 16.3463 5.74586 17.7142 5.41351C20.284 4.78912 22.069 8.04662 20.2709 10.0793C19.3138 11.1612 19.3138 12.8388 20.2709 13.9207C22.069 15.9534 20.284 19.2109 17.7142 18.5865C16.3463 18.2541 14.9674 19.0929 14.5567 20.5072C13.785 23.1643 10.215 23.1643 9.44331 20.5072C9.03256 19.0929 7.65367 18.2541 6.28582 18.5865C3.71602 19.2109 1.93101 15.9534 3.72913 13.9207C4.68623 12.8388 4.68623 11.1612 3.72913 10.0793C1.93101 8.04662 3.71602 4.78912 6.28582 5.41351C7.65367 5.74586 9.03256 4.90707 9.44331 3.49277Z\" stroke=\"#D9D9D9\" stroke-width=\"2\"/>
					</svg>
					</a>";
					break;
				
				case 'Reports':
					echo"<li class=\"nav_item\"><a href='$row[menu_url]'>  <svg width=\"25\" height=\"25\" viewBox=\"0 0 25 25\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">
					<path d=\"M20.7087 18.7187C21.167 17.9896 21.4378 17.1458 21.4378 16.2292C21.4378 13.6354 19.3441 11.5417 16.7503 11.5417C14.1566 11.5417 12.0628 13.6354 12.0628 16.2292C12.0628 18.8229 14.1566 20.9167 16.7399 20.9167C17.6566 20.9167 18.5107 20.6458 19.2295 20.1875L22.4795 23.4375L23.9587 21.9583L20.7087 18.7187ZM16.7503 18.8333C15.3128 18.8333 14.1462 17.6667 14.1462 16.2292C14.1462 14.7917 15.3128 13.625 16.7503 13.625C18.1878 13.625 19.3545 14.7917 19.3545 16.2292C19.3545 17.6667 18.1878 18.8333 16.7503 18.8333ZM16.3753 9.97917C15.6045 10 14.8649 10.1667 14.1878 10.4479L13.6149 9.58333L9.65658 16.0208L6.52116 12.3542L2.73991 18.4062L1.04199 17.1875L6.25033 8.85417L9.37533 12.5L13.542 5.72917L16.3753 9.97917ZM19.0732 10.5C18.4066 10.2083 17.6878 10.0312 16.9378 9.98958L22.2712 1.5625L23.9587 2.79167L19.0732 10.5Z\" fill=\"#D9D9D9\"/>
					</svg> </a>
					";
					break;

				case 'Logout':
					echo "<li class=\"nav_item\"><a href='$row[menu_url]'> 
					<svg width=\"16\" height=\"16\" viewBox=\"0 0 16 16\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">
						<path fill-rule=\"evenodd\" clip-rule=\"evenodd\" d=\"M11.9997 12.6668V10.6668C11.9997 10.2986 11.7012 10.0002 11.333 10.0002C10.9648 10.0002 10.6663 10.2986 10.6663 10.6668V12.6668C10.6663 13.035 10.3679 13.3335 9.99967 13.3335H3.33301C2.96482 13.3335 2.66634 13.035 2.66634 12.6668V3.3335C2.66634 2.96531 2.96482 2.66683 3.33301 2.66683H9.99967C10.3679 2.66683 10.6663 2.96531 10.6663 3.3335V5.3335C10.6663 5.70169 10.9648 6.00016 11.333 6.00016C11.7012 6.00016 11.9997 5.70169 11.9997 5.3335V3.3335C11.9997 2.22893 11.1042 1.3335 9.99967 1.3335H3.33301C2.22844 1.3335 1.33301 2.22893 1.33301 3.3335V12.6668C1.33301 13.7714 2.22844 14.6668 3.33301 14.6668H9.99967C11.1042 14.6668 11.9997 13.7714 11.9997 12.6668ZM13.1397 6.1935L14.473 7.52683C14.5992 7.65201 14.6702 7.8224 14.6702 8.00016C14.6702 8.17792 14.5992 8.34832 14.473 8.4735L13.1397 9.80683C13.0145 9.93304 12.8441 10.004 12.6663 10.004C12.4886 10.004 12.3182 9.93304 12.193 9.80683C12.0668 9.68165 11.9958 9.51125 11.9958 9.3335C11.9958 9.15574 12.0668 8.98534 12.193 8.86016L12.393 8.66683H7.99967C7.63148 8.66683 7.33301 8.36835 7.33301 8.00016C7.33301 7.63197 7.63148 7.3335 7.99967 7.3335H12.393L12.193 7.14016C11.9316 6.87875 11.9316 6.45491 12.193 6.1935C12.4544 5.93208 12.8783 5.93208 13.1397 6.1935Z\" fill=\"#fff\"/>
						</svg>  </a>";

			}
			// echo "<li class=\"nav_item\"><a href='$row[menu_url]'> $row[menu_name] </a>";
			//$sql_1 = "select * from menu where menu_level='1' and parent_id = '$menu_id' order by menu_order";

			$sql_1 = "select * from menu where menu_level='1' and parent_id = '$menu_id' and menu_id in (select menu_id from menugroup where role_id ='$role_id') order by menu_order";

			//$sql_1 = "select * from menu where menu_level='1' and parent_id = '$row[menu_id]' order by menu_order";
			//echo $sql_1;
			$result_1 = mysqli_query($_SESSION['db_connect'], $sql_1);
			$numrows_1 = mysqli_num_rows($result_1);
			if ($numrows_1 > 0) {
				echo "<ul>";
				for ($j = 0; $j < $numrows_1; $j++) {
					$row_1 = mysqli_fetch_array($result_1);
					$menu_id_1 = $row_1['menu_id'];
					$menu_url_1 = $row_1['menu_url'];
					if ($menu_url_1 == '') continue;
					//echo "menu_id = ".$menu_id_1;
					//echo $row_1[menu_name];
					echo "<li><a href='#' onclick=\"getpage('$row_1[menu_url]','page')\">$row_1[menu_name]</a>";
					// 2nd level menu

					$sql_2 = "select * from menu where menu_level='2' and parent_id = '$row_1[menu_id]' and menu_id in (select menu_id from menugroup where role_id ='$role_id') order by menu_order";

					//$sql_2 = "select * from menu where menu_level='2' and parent_id = '$row_1[menu_id]' order by menu_order";
					//echo $sql_2;
					$result_2 = mysqli_query($_SESSION['db_connect'], $sql_2);
					$numrows_2 = mysqli_num_rows($result_2);
					//echo $numrows_2;

					if ($numrows_2 > 0) {
						echo "<ul>";
						for ($k = 0; $k < $numrows_2; $k++) {
							$row_2 = mysqli_fetch_array($result_2);
							//$menu_id_2 = $row_1[menu_id];
							echo "<li><a href='#' onclick=\"getpage('$row_2[menu_url]','page')\">$row_2[menu_name]</a></li>";
						} // End 2nd level for loop
						echo "</ul>";
					} // End $numrows_2 > 0
					echo "</li>";
				} //End 1st level For Loop
				echo "</ul>";
			} // End of $numrows_1 > 0
			echo "</li>";
		} // End of Outer for Loop
		?>
		<!-- </div> -->
		<input type="hidden" id="eodst" name="eodst" value="0" />
		<!-- <br style="clear: left" />-->
</div>