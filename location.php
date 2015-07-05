<?php
require_once ('database.php'); 

$request_json = json_decode($_POST['json'], true);
$sql = "SELECT * FROM region_list WHERE id IN (SELECT parent_id FROM region_list WHERE name=\"".$request_json['location_name']."\")";
$query_locations = mysql_query($sql);

$locations = array();
while($loc = mysql_fetch_assoc($query_locations)){	
	$locations[$loc['id']] = $loc['name'];
}

$res["res"] = $locations;
echo json_encode($res);

?>