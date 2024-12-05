<?php
include 'config.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $password = $_POST['password'];

    // Check if both fields are filled
    if ($name && $password) {
        // Prepare a query to retrieve the user's password
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();

        # Check if the user exists
        if ($result->num_rows > 0) {
            // Fetch the user data
            $row = $result->fetch_assoc();
            
            // Compare the entered password with the stored password
            if ($password === $row['password']) {
                echo "Login successful. Welcome, $name!";

                // Set session variables
                $_SESSION['username'] = $name;

                header("Location: ../frontend/pages/index.html");
                exit();
            } else {
                echo "Incorrect password.";
            }
        } else {
            echo "No user found with that username.";
        }

        $stmt->close();
    } else {
        echo "Please fill in both fields.";
    }
}

$conn->close();
?>
