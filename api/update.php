<?php
include("database_config.php"); 

$response = array();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $item_id = $_POST['item_id'];
    $data = $_POST['data'];

    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($mysqli->connect_error) {
        error_log("Connection failed: " . $mysqli->connect_error);
        $response['message'] = "Update failed. Please try again later.";
    } else {
        $item_id = $mysqli->real_escape_string($item_id);
        $data = $mysqli->real_escape_string($data);

        $updateQuery = "UPDATE todo_item SET Todo_Data = '$data' WHERE Item_Id = '$item_id'";

        if ($mysqli->query($updateQuery)) {
            $response['message'] = "Updated";
        } else {
            $response['message'] = "Update failed: " . $mysqli->error;
        }

        $mysqli->close();
    }
}

header('Content-Type: application/json');
echo json_encode($response);
?>
