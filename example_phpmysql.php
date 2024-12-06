<?php

// CSci 130 - Web Programming

// In XAMPP
// start MySQL, click on Admin, create a new user, give yourself all the rights!

$servername = "localhost"; // default server name
$username = "hubert"; // user name that you created
$password = "OXccs8wmVCGDU0fG"; // password that you created
$dbname = "myDB";

// Main functions:
//	CREATE DATABASE mydb;
//	USE mydb;
//	CREATE TABLE mytable ( id INT PRIMARY KEY, name VARCHAR(20) );
//	INSERT INTO mytable VALUES ( 1, 'Will' );
//	INSERT INTO mytable VALUES ( 2, 'Arnold' );
//	INSERT INTO mytable VALUES ( 3, 'Terrence' );
//	SELECT id, name FROM mytable WHERE id = 1;
//	UPDATE mytable SET name = 'Willy' WHERE id = 1;
//	SELECT id, name FROM mytable;
//	DELETE FROM mytable WHERE id = 1;
//	SELECT id, name FROM mytable;
//	DROP DATABASE mydb;
//	SELECT count(1) from mytable; gives the number of records in the table


// There are several ways to create the connection
// we keep it clean by using objects !

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error ."<br>");
} 
echo "Connected successfully <br>";

// Delete the database
$sql = 'DROP DATABASE myDB';
if ($conn->query($sql)) {
    echo "Database myDB was successfully dropped<br>";
} else {
    echo 'Error dropping database: ' . $conn->errorm . "<br>"; 
	// mysql_error() not working with PHP7 use $conn->error
}		


// Creation of the database
$sql = "CREATE DATABASE myDB";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error ."<br>";
}

// close the connection
$conn->close();



// We connect again but this time we specify the name of the database !

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// Creation of a table
// id = a unique identifier that is created automatically 
// varchar(n) = string of n characters max 
$sql = "CREATE TABLE Person (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
firstname VARCHAR(30) NOT NULL, 
lastname VARCHAR(30) NOT NULL,
email VARCHAR(50),
reg_date TIMESTAMP
)";


if ($conn->query($sql) === TRUE) {
    echo "Table Person created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error ."<br>";
}


// Insert elements in the database
$sql = "INSERT INTO Person (firstname, lastname, email) VALUES ('Tobias', 'Harris', 't.harris@laclippers.com')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error ."<br>";
}

// insert the first element
$sql = "INSERT INTO Person (firstname, lastname, email) VALUES ('Alfred', 'Smith', 'a.smith@hotmail.com');";  // do not forget the ; after each block for the multiquery
// insert the second element (notice the .)
$sql .= "INSERT INTO Person (firstname, lastname, email) VALUES ('Jesus', 'Sanchez', 'jesus12456@yahoo.com');";
// insert the third element  (notice the .) 
$sql .= "INSERT INTO Person (firstname, lastname, email) VALUES ('Carlos', 'Dasilva', 'carlos.dasilva@gmail.com')";

if ($conn->multi_query($sql) === TRUE) {  // notice the difference MULTI query
	 $last_id = $conn->insert_id;
    echo "New record created successfully. Last inserted ID is: " . $last_id ."<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}



// To improve performance when the same actions are repeated many times: prepared statement

// Prepared statements: 
// 1. An SQL statement template is created and sent to the database.
// Some values are left unspecified (called parameters (labeled "?"))
// Example: INSERT INTO Person VALUES(?, ?, ?)
// 2. The database parses, compiles, and performs query optimization on the SQL statement template
//    The database stores the result without executing it
// 3. Execute 
//	The application binds the values to the parameters, and the database executes the statement.
//  The application may execute the statement as many times as it wants with different values.
echo "Prepared statements <br>";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


// prepare and bind
$stmt = $conn->prepare("INSERT INTO Person (firstname, lastname, email) VALUES (?, ?, ?)");
if ($stmt==FALSE) {
	echo "There is a problem with prepare <br>";
	echo $conn->error; // Need to connect/reconnect before the prepare call otherwise it doesnt work
	// see: https://dev.mysql.com/doc/refman/5.7/en/commands-out-of-sync.html
}
$stmt->bind_param("sss", $firstname, $lastname, $email);

// sss = 3 strings
// i - integer
// d - double
// s - string
// b - BLOB: a binary large object that can hold a variable amount of data

// set parameters and execute
$firstname = "Jim";
$lastname = "McDonald";
$email = "jim@yahoo.com";
$stmt->execute();

$firstname = "Henry";
$lastname = "Walter";
$email = "h.walter@gmail.com";
$stmt->execute();

$firstname = "Courtney";
$lastname = "Dylan";
$email = "c.dylan@msn.com";
$stmt->execute();

echo "New records created successfully<br>";

$stmt->close();

// Selection of data 
$sql = "SELECT id, firstname, lastname FROM Person";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
    }
} else {
    echo "0 results";
}

// sql to delete a record
$sql = "DELETE FROM Person WHERE id=4";
if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully <br>";
} else {
    echo "Error deleting record: " . $conn->error ."<br>";
}

// Update a record
$sql = "UPDATE Person SET lastname='Donovan' WHERE id=4";
if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully<br>";
} else {
    echo "Error updating record: " . $conn->error ."<br>";
}

// Get only the first 10 instances in the result of the query
$sql = "SELECT * FROM Orders LIMIT 10";

// close the connection
$conn->close();

?>