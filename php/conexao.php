<?php

// Open a Connection to MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "museu";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, '3306');

// Check connection
if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
    echo 'problema';
	return;
} 

// SELECIONAR BANCO QUE VAMOS TRABALHAR
$query = 'use museu';
$result = $conn->query($query);

?>