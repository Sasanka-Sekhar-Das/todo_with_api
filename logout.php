<?php
session_start(); // Start the session

// Check if the user is logged in
if (isset($_SESSION['user_email_todo'])) {
    // Unset and destroy the session variables
    session_unset();
    session_destroy();
    header("Location: index.php"); // Redirect to your desired page after logging out
    exit();
} else {
    header("Location: index.php"); // If the user is not logged in, redirect to the index page
    exit();
}
?>