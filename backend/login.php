<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = $_POST['name'];
    $password = $_POST['password'];

    if($name && $password !==null){
        $sql = "SELECT * FROM users WHERE name = '$name'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                session_start();
                $_SESSION['name'] = $name;
                header("Location: index.php");
                exit();
            }else{
                echo "Invalid password";
            }
        }else{
            echo "User not found";
        }
    }
}

?>