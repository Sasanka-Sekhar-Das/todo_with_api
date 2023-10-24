
<?php

include("database_config.php"); 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['mail'];
    $password = $_POST['pass'];


    $response = array();

    
    if (empty($email) || empty($password)) {
        $response['message'] = "Email and password are required.";
    } else {
        
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        
        if ($mysqli->connect_error) {
            error_log("Connection failed: " . $mysqli->connect_error);
            $response['message'] = "Login failed. Please try again later.";
        } else {
            
            $email = $mysqli->real_escape_string($email);

            
            $getUserQuery = "SELECT User_Pass FROM users WHERE User_Email = '$email'";
            $userResult = $mysqli->query($getUserQuery);

            if ($userResult) {
                if ($userResult->num_rows > 0) {
                    $row = $userResult->fetch_assoc();
                    $hashedPassword = $row['User_Pass'];

                    //session
                    session_start();
                     $_SESSION['user_email_todo'] = $email;

                
                    if (password_verify($password, $hashedPassword)) {
                        $response['loggedIn'] = true;
                        $response['message'] = "Login successful.";
                    } else {
                        $response['message'] = "Incorrect password.";
                    }
                } else {
                    $response['message'] = "Email not found.";
                }
            } else {
                $response['message'] = "Error checking user.";
            }

            $mysqli->close();
        }
    }

    
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>