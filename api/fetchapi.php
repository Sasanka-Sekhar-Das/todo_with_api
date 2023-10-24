<?php
include("database_config.php"); 

$response = array();
session_start();
$user = $_SESSION['user_email_todo'];

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($mysqli->connect_error) {
        error_log("Connection failed: " . $mysqli->connect_error);
        $response['message'] = "Failed to connect to the database.";
    } else {
        $query = "SELECT * FROM todo_item WHERE User_Id = '$user'";
        $result = $mysqli->query($query);

        if ($result) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            $response['data'] = $data;
        } else {
            $response['message'] = "No data found";
        }

        $mysqli->close();
    }
} else {
    $response['message'] = "Invalid request.";
}

header('Content-Type: application/json');
echo json_encode($response);
?>

