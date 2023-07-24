<?php
require_once 'db.php';
require_once 'jwt_utils.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

$bearer_token = get_bearer_token();

$is_jwt_valid = is_jwt_valid($bearer_token);

if ($is_jwt_valid) {
    $db = mysqli_connect("localhost", "risk2", "123456", "satisfy");
    mysqli_set_charset($db, 'utf8');
    if (!$db) {
        die("Connection failed: " . mysqli_connect_error());
    }
    else{
       if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents("php://input"), true);
        // echo json_encode($data);
        if (isset($data['deptid']) && isset($data['datefirst']) && isset($data['dateafter'])) {
            $deptid = mysqli_real_escape_string($db, $data['deptid']);
            $datefirst = mysqli_real_escape_string($db, $data['datefirst']) . ' 00:00:00';
            $dateafter = mysqli_real_escape_string($db, $data['dateafter']) . ' 23:59:59';
            
            $sql = "select count(*) as total, point from transaction where deptid = '$deptid' and dateact between '$datefirst' and '$dateafter' group by point";

            $result = mysqli_query($db, $sql);
            if ($result) {
                $rows = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    $rows[] = $row;
                }
                echo json_encode($rows);
            } else {
                echo json_encode(array('error' => 'Failed to fetch data'));
            }
        } else {
            echo json_encode(array('error' => 'Missing required parameters'));
        }
    } else {
        echo json_encode(array('error' => 'Invalid request method'));
    }
    }
} else {
    echo json_encode(array('error' => 'Access denied'));
}
?>
