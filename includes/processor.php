<?php
function secure($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}
// Level & Level [Deepness] Conversion
function getLevelDeepness($lvl) {
	$lvl_deep = "./";
	for($i=0; $i<$lvl; $i++) {
  		$lvl_deep .= "../";
	}
	return $lvl_deep;
}
function confirm_logged_in()
{
    if (isset($_SESSION['user']['username']) && isset($_SESSION['logged'])) {
        return true;
    }
}

if (isset($_GET['log_out'])) {
    session_unset();
    session_destroy();
    header('location: index.php');
    exit;
}
function do_inserts($arr, $tbl, $conx){
	$keys = array_keys($arr);
	$pholder =  ':'.implode(',:',$keys);
	$columns =  implode(', ',$keys);
	$arr_objs = [];
	foreach($keys as $key){
		$arr_objs[$key] = $arr[$key];
	}
	$query = query('INSERT INTO '.$tbl.' ('.$columns.') VALUES('.$pholder.')',$arr_objs,$conx);
	return ($query) ? $query : false;
}
