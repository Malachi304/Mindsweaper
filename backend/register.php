<?php

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = $_POST['name'];
    $password = $_POST['password'];

    if($name && $password !==null){
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name, password) VALUES ('$name', '$hash')";
        $result = $conn->query($sql);
        if ($result) {
            header("Location: login.php");
            echo "User $name registered successfully";
            exit();
        }
    }
}

?>