<?php

require_once 'db.php';	//ต้องการ db.php

header("Access-Control-Allow-Origin: *");//เป็น Header กำหนดว่าให้ใครเข้าถึง Resource ของ Server ได้บ้าง
header("Access-Control-Allow-Methods: POST");//วิธีการร้องขอ HTTP ที่อนุญาต

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// get posted data
	
	$data = json_decode(file_get_contents("php://input", true));//ดึงพารามิเตอร์เนื้อหา json
	echo json_encode($data);
	$sql = "INSERT INTO user(username, password) VALUES('" . mysqli_real_escape_string($db, $data->username) . "', '" . mysqli_real_escape_string($db, $data->password) . "')";
	//INSERT INTO เป็นคำสั่งที่ใช้ใส่ข้อมูลลงในตาราง 
	$result = dbQuery($sql);
	//dbqueryคือผลลัพธ์ของการ query จากฐานข้อมูล.
	
	if($result) {
		echo json_encode(array('success' => 'You registered successfully'));
		//json_encode ในภาษา PHP เป็นฟังก์ชันที่ใช้แปลงค่าที่เก็บอยู่ใน Array ให้ออกมาเป็น json 
	} else {
		echo json_encode(array('error' => 'Something went wrong, please contact administrator'));
	}
}
?>