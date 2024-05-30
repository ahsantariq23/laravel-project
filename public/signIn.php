<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); // Start the session

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Connect to the database
    $servername = "localhost"; // Change this to your database server name
    $username = "abstract-programmer"; // Change this to your database username
    $db_password = "mypassword"; // Change this to your database password
    $dbname = "WebsiteUsersDB"; // Change this to your database name

    $conn = new mysqli($servername, $username, $db_password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement to retrieve user data
    $stmt = $conn->prepare("SELECT email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // If a record with the same email exists, verify the password
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($dbEmail, $dbPassword);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $dbPassword)) {
            // Password is correct, set session variables and redirect to sign-in page
            $_SESSION["email"] = $email;
            header("Location: ../resources/views/home.html");
            exit();
        } else {
            // Password is incorrect, display error message
            $error = "Incorrect password. Please try again.";
            echo $error;
        }
    } else {
        // User does not exist, display error message
        $error = "User does not exist. Please sign up first.";
    }

    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();
}

