<?php
require_once 'db.php';	//ต้องการ db.php
require_once 'jwt_utils.php';	//ต้องการ jwt_utils.php

header("Access-Control-Allow-Origin: *"); //เป็น Header กำหนดว่าให้ใครเข้าถึง Resource ของ Server ได้บ้าง
header("Access-Control-Allow-Methods: POST");//วิธีการร้องขอ HTTP ที่อนุญาต

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// get posted data
	$data = json_decode(file_get_contents("php://input", true));
	//ดึงพารามิเตอร์เนื้อหา json
	$sql = "SELECT * FROM user WHERE username = '" . mysqli_real_escape_string($db, $data->username) . "' AND password = '" . mysqli_real_escape_string($db, $data->password) . "' LIMIT 1";
	//SELECT คือการเลือกคอลัมน์ที่เรากำหนดเอาไว้ //FORM คือการเลือกตารางข้อมูล. WHERE คือการกำหนดเงื่อนไข
	$result = dbQuery($sql);
	//dbqueryคือผลลัพธ์ของการ query จากฐานข้อมูล.
	
	//dbNumRowsใช้ในการส่งกลับจำนวนแถวที่มีอยู่ในชุดผลลัพธ์หรือฐานข้อมูลที่ได้ Query มา โดยทั่วไปจะใช้เพื่อตรวจสอบว่ามีข้อมูลอยู่ในฐานข้อมูลหรือไม่
	if(dbNumRows($result) < 1) {
		echo json_encode(array('error' => 'Invalid User'));
	} else {
		$row = dbFetchAssoc($result);//ดึงแถวจากชุดผลลัพธ์เป็นอาร์เรย์
		
		$username = $row['username'];
		
		$headers = array('alg'=>'HS256','typ'=>'JWT');
		$payload = array('username'=>$username);
		//$payload = array('username'=>$username, 'exp'=>(time() + 60000));

		$jwt = generate_jwt($headers, $payload);
		
		echo json_encode(array('token' => $jwt));
	}
}
?>