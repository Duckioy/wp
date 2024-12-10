<?php
if (strstr($_SERVER['SERVER_NAME'], 'localhost')) {
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'petsvictoria';
} else {
    $servername = 'talsprddb02.int.its.rmit.edu.au';
    $username = 's4038230';
    $password = 'Kid123456789';
    $dbname = 's4038230';
}
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}