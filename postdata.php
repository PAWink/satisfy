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
        //echo json_encode($data);
        if (isset($data['deptid']) && isset($data['point'])) {
            $deptid = mysqli_real_escape_string($db, $data['deptid']);
            $point = mysqli_real_escape_string($db, $data['point']);

            $sql = "insert into transaction (deptid, point) VALUES ('$deptid', '$point')";
            $result = mysqli_query($db, $sql);
            if ($result) {
                echo json_encode(array('success' => 'Post success'));
            } else {
                echo json_encode(array('error' => 'Failed to insert data'));
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
