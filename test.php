<?php
	require_once('database.php');
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Table</title>
	<meta charset="utf-8"/>
	<style>
		table {
			border-collapse: collapse; 
		}
		tr, td, th {
			padding: 5px;
			border: 1px solid black;
		}
		select {
			width: 170px;
		}
		.picture {
			width: 70px;
			display: inline-block;
			border: 0.5px solid black;
		}
		#overlay, #overlay1 {
		 visibility: hidden;
		 position: absolute;
		 left: 0px;
		 top: 0px;
		 width:100%;
		 height:100%;
		 text-align:center;
		 z-index: 1000;
		}
		#overlay div, #overlay1 div {
		 width:300px;
		 margin: 100px auto;
		 background-color: #fff;
		 border:1px solid #000;
		 padding:15px;
		 text-align:center;
		}
	</style>
	<link href="style.css" rel="stylesheet" type="text/css"/>
	
	<script type="text/javascript">
function edit_modal(id){
	
el = document.getElementById(id);
el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible"; 
}
function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}
</script>
<script src="modal.js"></script>
</head>
<body>
<?php 
	$sql = "SELECT ul.name, login, rl.name as city, rl2.name as region, rl3.name as distinctt, goods.id, goods.tema, goods.meil, t_sprav.Text_values 
	FROM userlist ul JOIN goods on ul.id_u=goods.id_user 
	JOIN t_sprav on t_sprav.id=goods.Statys_m 
	JOIN region_list rl on ul.city=rl.id 
	LEFT JOIN region_list rl2 on rl2.id=rl.parent_id 
	LEFT JOIN region_list rl3 on rl3.id=rl2.parent_id";
	$query_orders = mysql_query($sql);
	$count = 1;
	echo "<table width='50%'>";
	echo "<tr><th>name</th><th><b>login</b></th><th>order_id</th><th>tema</th><th>mail</th><th>Status_m</th><th>distinct</th><th>region</th><th>city</th></tr>";
	while($orders = mysql_fetch_assoc($query_orders)){	
		echo "<tr>
				<td>".$orders['name']."</td>
				<td>".$orders['login']."</td>
				<td>".$orders['id']."</td>
				<td>".$orders['tema']."</td>
				<td>".$orders['meil']."</td>
				<td>".$orders['Text_values']."</td>
				<td>".$orders['distinctt']."</td>
				<td>".$orders['region']."</td>
				<td>".$orders['city']."</td>
			  </tr>";
		$count++;
	}
	echo "</table>";
?>
<br />
<div><h2>TABLE USERS</h2>
	<?php
		if(isset($_GET['dell_user']) && !empty($_GET['dell_user'])){
			$sql = "DELETE FROM userlist WHERE id_u=".$_GET['dell_user'];
			mysql_query($sql);
		}
		$sql = "SELECT id_u, ul.name, login, pass, rl.name as city, rl2.name as region, rl3.name as distinctt FROM userlist ul
		JOIN region_list rl on ul.city=rl.id 
		LEFT JOIN region_list rl2 on rl2.id=rl.parent_id 
		LEFT JOIN region_list rl3 on rl3.id=rl2.parent_id";
		$query_users = mysql_query($sql);
		$count = 1;
		echo "<table width='50%'>";
		echo "<tr><th></th><th>name</th><th><b>login</b></th><th>password</th><th>distinct</th><th>region</th><th>city</th></tr>";
		while($user = mysql_fetch_assoc($query_users)){	
			echo "<tr>
					<td class='picture'>
						<img id='change_id' src='change.gif'>
						<img id='add_id' src='plus.gif'>
						<a href='".$_SERVER['PHP_SELF']."?dell_user=".$user['id_u']."'onclick=\"if(!confirm('Запис буде видалено!')){return false;}\">
							<img src='del.gif'>
						</a>
					</td>
					<td>".$user['name']."</td>
					<td>".$user['login']."</td>
					<td>".$user['pass']."</td>
					<td>".$user['distinctt']."</td>
					<td>".$user['region']."</td>
					<td>".$user['city']."</td>
				  </tr>";
			$count++;
		}
		echo "</table>";
	?>
</div>
	<button id="btn_popup">popup</button>
    <div id="smoke" class="smokeclass">...</div>
	<div class="modalDialog">
		<div id="popup" class="popupclass">
			<div id="popup_bar" class="popupbarclass" >Title<span id="btn_close" class="bntcloseclass">[X]</span></div>
			<p>Popup Window.<br>Press ESC to close.</p>
		</div>
	</div>
<script src="modal.js"></script>
</body>
</html>