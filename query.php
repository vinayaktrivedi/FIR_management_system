<?php
//$db = new SQLite3('mysqlitedb.db');
if($_POST['query_type'] == 'select'){
	//$result = $db->query($_POST["query"]);
	$result = "select";
}
else if($_POST['query_type'] == 'exec'){
	$result ="exec";
}
echo $result;
?>