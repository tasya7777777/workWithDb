<?php

 require_once('database.php');
 if (isset($_POST['hidden_action']) or isset($_GET['dell_user'])){ 
    	//header("Location:".$_SERVER['PHP_SELF'].'?already_showed=true');  
    }
 
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Table</title>
	<meta charset="utf-8"/>
	<link href="css/style.css" rel="stylesheet" type="text/css"/>
	<script src="js/modal.js"></script>
</head>
<body>
<div>
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
<input type='button' id='but_show' value='Show userlist table' onclick="show_table()"/>

<div id='table_users' style='visibility: hidden;'>
	<h2>TABLE USERS</h2>
	<?php
		
		 if(isset($_GET['dell_user']) && !empty($_GET['dell_user'])){
			$sql = "DELETE FROM userlist WHERE id_u=".$_GET['dell_user'];
			echo "<input type=\"hidden\" name=\"already_showed\" value=\"true\"/>";
			$del_record = mysql_query($sql);
			if(!$del_record){
				echo "<script>alert ('Could not delete record!It has relations to another tables.');</script>";
			}
		}else if(isset($_POST['hidden_action']) && ($_POST['hidden_action'] == 'Edit record')){
			$sql = "UPDATE userlist SET name = \"".$_POST['user_name']."\", login =\"".$_POST['login']."\", pass =\"".$_POST['pass']."\", city=(SELECT id FROM `region_list` rl1 WHERE rl1.name=\"".$_POST['user_city']."\" AND rl1.parent_id = 
					(SELECT rl2.id FROM region_list rl2 WHERE rl2.name = \"".$_POST['region']."\" AND rl2.parent_id=
																(SELECT rl3.id FROM region_list rl3 WHERE rl3.name =\"".$_POST['dist']."\"))) where id_u =".$_POST['user_id'];
			echo "<input type=\"hidden\" name=\"already_showed\" value=\"true\"/>";
			mysql_query($sql);
			
		}else if(isset($_POST['hidden_action']) && ($_POST['hidden_action'] == 'Add record')){

			$sql = "INSERT INTO userlist (name, login, pass, city) VALUES(\"".$_POST['user_name']."\",\"".$_POST['login']."\",\"".$_POST['pass']."\",(SELECT id FROM `region_list` rl1 WHERE rl1.name=\"".$_POST['user_city']."\" AND rl1.parent_id = 
					(SELECT rl2.id FROM region_list rl2 WHERE rl2.name = \"".$_POST['region']."\" AND rl2.parent_id=
																(SELECT rl3.id FROM region_list rl3 WHERE rl3.name =\"".$_POST['dist']."\"))))";
			mysql_query($sql);
		
			echo "<input type=\"hidden\" name=\"already_showed\" value=\"true\"/>";
		}else{
			echo "<input type=\"hidden\" name=\"already_showed\" value=\"false\"/>";
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
						<img id='change_id".$count."' src='pictures/change.gif' onclick='edit_modall(\"change\", "; echo json_encode($user); echo ",".$user['id_u'].")'>
						<img id='add_id".$count."' src='pictures/plus.gif' onclick='edit_modall(\"add\")'>
						<a href='".$_SERVER['PHP_SELF']."?dell_user=".$user['id_u']."&already_showed=true 'onclick=\"if(!confirm('Запис буде видалено!')){return false;}\">
							<img src='pictures/del.gif'>
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
    <div id="greyBack" class="greyBackclass"></div>
	<div id="popup" class="popupclass">
		<div id="popup_bar" class="popupbarclass" ><span id="btn_close" class="bntcloseclass"><img src='pictures/close.png' width='20px'/></span></div>
		<form action="<?php echo $PHP_SELF; ?>" method="POST" onSubmit="window.location.reload()">
			<p>Name:</p><input type="text" id="user_name" name="user_name" required/>
			<p>Login:</p><input type="text" id="user_login" name="login" required/>
			<p>Password:</p><input type="password" id="user_pass" name="pass" required/>
			<p>City:</p>
			<?php 
			$sql = "SELECT DISTINCT name FROM region_list where id not in(select parent_id from region_list where parent_id is not null)";
			$query_city = mysql_query($sql);
			echo "<select id='select_city' name=\"user_city\" onchange=\"getLocations(this, 'city')\" required>";
			echo "<option value=''></option>";
			while($city = mysql_fetch_assoc($query_city)){	
				echo "<option value=\"".$city['name']."\">".$city['name']."</option>";
			}
			echo "</select>";
			?>
			<p>Region:</p>
			<select id='user_region' name="region" disabled=\"disabled\" onchange="getLocations(this, 'region')"  required>
				
			</select>
			
			<p>Distinct:</p>
			<select id='user_dist' name="dist" disabled=\"disabled\" required>
				
			</select>
			<br /><br />
			<input type="hidden" id="hidden_action" name="hidden_action" value=""/>
			<input type="hidden" id="user_id" name="user_id" value=""/>
			<input type="submit" name="button_change" value="Save" onclick="save_editing()">
			<input type="button" name="cancel" value="Cancel" onclick="cancel_editing()">
		</form>
	</div>
</div>
<script>
(function() {
	var query = window.location.search.substring(1);
  
    if(query.includes('already_showed=true')){
    	var t_user = document.getElementById('table_users');
    	t_user.style.visibility = "visible";
   }

})();
</script>
</body>
</html>