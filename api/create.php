<?php
include("database_config.php"); 

$response = array(); 


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $todo = $_POST['todo'];
    $user = $_POST['user'];

    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    
    if ($mysqli->connect_error) {
        error_log("Connection failed: " . $mysqli->connect_error);
        $response['message'] = "Insertion failed. Please try again later.";
    } else {
        
        $todo = $mysqli->real_escape_string($todo);
        $user = $mysqli->real_escape_string($user);

        $insertDataQuery = "INSERT INTO todo_item (User_Id, Todo_Data) VALUES ('$user', '$todo')";

        if ($mysqli->query($insertDataQuery)) {
            $response['message'] = "Inserted";
        } else {
            $response['message'] = "Failed " . $mysqli->error;
        }

        $mysqli->close();
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}


?>
