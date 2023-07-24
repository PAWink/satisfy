<?php
require_once 'db.php';
require_once 'jwt_utils.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

$bearer_token = get_bearer_token();

#echo $bearer_token;

$is_jwt_valid = is_jwt_valid($bearer_token); 

if($is_jwt_valid) {
$db = mysqli_connect("localhost","risk2","123456","satisfy");
	mysqli_set_charset($db, 'utf8');
	if(!$db){
		echo json_encode(array('error' => 'Cannot access Database'));
	}else{

		$person=$db->query("select * from department");
		$list=array();

		while($rowdata=$person->fetch_assoc()){
			$list[]=$rowdata;
		}
		echo json_encode($list);
	}

}else
{
	echo json_encode(array('error' => 'Access denied'));
}

?>