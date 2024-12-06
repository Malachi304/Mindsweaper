<?php

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = $_POST['name'];
    $password = $_POST['password'];

    if($name && $password){
        # Check if user already exists
        $sql = "SELECT * FROM users WHERE username = '$name'";
        # this query returns a result set
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo "Username Taken. Please choose another one.";
            exit();
        }else{        
            $sql = "INSERT INTO users (username, password) VALUES ('$name', '$password')";
            $result = $conn->query($sql);
            if ($result) {
                echo "User $name registered successfully";
                header("Location: login.php");
                exit();
            }
        }

    }
}

$conn->close();

?>