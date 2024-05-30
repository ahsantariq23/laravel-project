<?php
echo "Php is Enabled";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validate form data (you may add more validation as needed)

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Connect to the database
    $servername = "localhost"; // Change this to your database server name
    $username = "abstract-programmer"; // Change this to your database username
    $password = "mypassword"; // Change this to your database password
    $dbname = "WebsiteUsersDB"; // Change this to your database name

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the user already exists
    $check_stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_stmt->store_result();

    // If a record with the same email exists, display an error message
    if ($check_stmt->num_rows > 0) {
        echo "User already exists!";
    } else {
        // Prepare SQL statement to insert data into the database
        $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $hashedPassword);

        // Execute the SQL statement
        if ($stmt->execute()) {
            // If the data is inserted successfully, redirect the user to a success page
            header("Location: ../../public/index.html");
            exit();
        } else {
            // If an error occurs during insertion, display an error message
            echo "Error: " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();
    }

    // Close the database connection
    $conn->close();
}
?>
