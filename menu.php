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
		margin: 0!important;
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
		background-image: linear-gradient(to right, rgba(255,255,255,.5), rgba(255,255,255,.5));	
	}

	.nav_item>a {
		text-decoration: none;
		color: #fff;
	}

	.nav_item > ul {
		display: none;
		position: absolute;
		top: 15px;
		left:95px;
		background: #fff;
		padding: 20px;
		width: 220px;
		height: 100vh;
		z-index: 20;
	}
	.nav_item > ul > li {
		padding: 10px 0;
	}
	.nav_item > ul > li > a {
		color: #ABB1B7;
		font-size: 15px;
		text-decoration: none;
	}

	.nav_item:hover > ul{
		display: block;
	}
</style>
<!-- <div id="smoothmenu1" class="ddsmoothmenu"> -->
<div class="nav">
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
			echo "<li class=\"nav_item\"><a href='$row[menu_url]'> $row[menu_name] </a>";
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
</div>
<input type="hidden" id="eodst" name="eodst" value="0" />
<br style="clear: left" />
</div>