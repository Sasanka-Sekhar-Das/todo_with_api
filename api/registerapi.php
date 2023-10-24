<?php
include("database_config.php"); 

function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charLength - 1)];
    }

    return $randomString;
}

$my_u_id = generateRandomString(15); 




if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['uname'];
    $email = $_POST['mail'];
    $password = $_POST['pass'];
    $confirm_password = $_POST['cpass'];

    
    $response = array();

    
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $response['message'] = "All fields are required.";
    } elseif ($password !== $confirm_password) {
        $response['message'] = "Passwords do not match.";
    } else {
        
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);


        if ($mysqli->connect_error) {
            error_log("Connection failed: " . $mysqli->connect_error);
            $response['message'] = "Registration failed. Please try again later.";
        } else {

            $name = $mysqli->real_escape_string($name);
            $email = $mysqli->real_escape_string($email);
            $password = $mysqli->real_escape_string($password);

            
            $existingUserCheck = "SELECT COUNT(*) FROM users WHERE User_Email = '$email'";
            $existingUserResult = $mysqli->query($existingUserCheck);

            if ($existingUserResult) {
                $row = $existingUserResult->fetch_row();
                $count = $row[0];

                if ($count > 0) {
                    $response['message'] = "Email already registered.";
                } else {
                    
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        
                    $insertUserQuery = "INSERT INTO users (User_Id, User_Name, User_Email, User_Pass) VALUES ('$my_u_id', '$name', '$email', '$hashedPassword')";

                    if ($mysqli->query($insertUserQuery)) {
                        $response['message'] = "Registration successful.";
                    } else {
                        $response['message'] = "Registration failed. Please try again later.";
                    }
                }
            } else {
                $response['message'] = "Error checking existing user.";
            }

            $mysqli->close();
        }
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
