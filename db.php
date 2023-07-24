<?php

/*$connect = mysqli_connect("localhost","sa","sa123456","satisfy");

if($connect){
	
}else{
	echo "Connection Failed";
}
exit();*/
/**
* Author : https://roytuts.com 1 สร้าง ob และฐานข้อมูล
*/
	
$db = mysqli_connect('localhost', 'risk2', '123456', 'satisfy') or die('MySQL connect failed. ' . mysqli_connect_error());
mysqli_set_charset($db, 'utf8');
function dbQuery($sql) {//dbqueryคือผลลัพธ์ของการ query จากฐานข้อมูล.
	global $db;
	$result = mysqli_query($db, $sql) or die(mysqli_error($db)); //ตัวแรกคือ ob การเชื่อมต่อที่ส่งคืนโดย ฟช mysql_connect //ตัวที่สองคือคิวรี่ที่ดำเนินการโดยส่งคืนผลลัพธ์
	return $result;
}

function dbFetchAssoc($result) { //ดึงแถวจากชุดผลลัพธ์เป็นอาร์เรย์
	return mysqli_fetch_assoc($result);
}

function dbNumRows($result) {	//ฟังก์ชั่นเป็นฟังก์ชั่น PHP ใช้ในการส่งกลับจำนวนแถวที่มีอยู่ในชุดผลลัพธ์หรือฐานข้อมูลที่ได้ Query มา โดยทั่วไปจะใช้เพื่อตรวจสอบว่ามีข้อมูลอยู่ในฐานข้อมูลหรือไม่ 
    return mysqli_num_rows($result);
}

function closeConn() {
	global $db;	//เป็นฟังก์ชันใน PHP ที่ใช้เพื่อปิดการเชื่อมต่อ MySQLi ที่เปิดไว้ก่อนหน้านี้
	mysqli_close($db);
}
?>