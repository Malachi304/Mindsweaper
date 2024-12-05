<?php
    // Database credentials
    $host = "localhost";
    $username = "root";
    $password = "Ethan323";

    // Database name
    $dbName = "minesweeper";

    // Step 1: Connect to MySQL server without selecting a database
    $conn = new mysqli($host, $username, $password);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Step 2: Check if the database exists
    $dbExistsQuery = "SHOW DATABASES LIKE '$dbName'";
    $result = $conn->query($dbExistsQuery);

    if ($result->num_rows == 0) {
        // Step 3: If database doesn't exist, create it
        $createDbQuery = "CREATE DATABASE $dbName";
        if ($conn->query($createDbQuery) === TRUE) {

            $conn->select_db($dbName);

            $sql = "CREATE TABLE users (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            username VARCHAR(30) NOT NULL,
            password VARCHAR(30) NOT NULL
            )";

            if($conn->query($sql) === TRUE) {
                echo "Table 'users' created successfully.<br>";
            } else{
                die("Error creating table: " . $conn->error);
            }

        } else {
            die("Error creating database: " . $conn->error);
        }
    } else {
        echo "Database '$dbName' already exists.<br>";
        // Step 4: Switch to the database if it exists 
         $conn->select_db($dbName);
        echo "Connected to database '$dbName'.<br>";
    }

    $conn->close();

?>
