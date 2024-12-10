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

// Assuming user data is stored in the session after login
if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];

    // Fetch user data from the database, including the username
    $sql = "SELECT * FROM users WHERE userid = $userid";
    $result = mysqli_query($conn, $sql);

    // Fetch the user data
    if ($result) {
        $users = mysqli_fetch_assoc($result); // Fetch user info into $users array
    }
}