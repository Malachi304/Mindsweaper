<?php

session_start();

// Check if the user is logged in, if not then redirect him to login page
$response = [
    'loggedIn' => false,
    'username' => null
];

if(isset($_SESSION['username'])){
    $response['loggedIn'] = true;
    $response['username'] = $_SESSION['username'];
}

header('Content-Type: application/json');
echo json_encode($response);

?>