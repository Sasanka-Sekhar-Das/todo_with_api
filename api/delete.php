<?php
include("database_config.php"); 

$response = array();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $item_id = $_POST['Item_Id'];

    if (empty($item_id)) {
        $response['message'] = "Item ID is required for deletion.";
    } else {
        
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        
        if ($mysqli->connect_error) {
            error_log("Connection failed: " . $mysqli->connect_error);
            $response['message'] = "Deletion failed. Please try again later.";
        } else {
        
            $item_id = $mysqli->real_escape_string($item_id);

            
            $deleteQuery = "DELETE FROM todo_item WHERE Item_Id = '$item_id'";

            if ($mysqli->query($deleteQuery)) {
                $response['message'] = "Deleted";
            } else {
                $response['message'] = "Deletion failed: " . $mysqli->error;
            }

            $mysqli->close();
        }
    }

    
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
