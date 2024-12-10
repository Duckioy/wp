<?php
session_start(); // Start the session to check if the user is logged in
include "include/db_connect.inc"; // Include the database connection

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If the user is not logged in, redirect them to the login page
    header("Location: login.php");
    exit();
}

// Check if 'petid' is set in the URL (the pet we want to delete)
if (isset($_GET['petid'])) {
    $petid = $_GET['petid'];

    // Prepare SQL to fetch the pet details, including the image file
    $sql = "SELECT image FROM pets WHERE petid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $petid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if the pet exists in the database
    if ($result->num_rows > 0) {
        $pet = $result->fetch_assoc();
        $image = $pet['image']; // Store the image filename to delete later

        // Now, delete the pet from the database
        $sql = "DELETE FROM pets WHERE petid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $petid);
        $stmt->execute();

        // Check if the record was successfully deleted
        if ($stmt->affected_rows > 0) {
            // If the record is deleted, delete the image file from the server
            if (!empty($image) && file_exists('images/' . $image)) {
                unlink('images/' . $image); // Delete the image file
            }
            
            // Redirect to the pets page or show a success message
            $_SESSION['usermsg'] = "Pet deleted successfully!";
            header("Location: gallery.php"); // Redirect to the pets listing page
            exit();
        } else {
            // If the record wasn't deleted, show an error message
            $_SESSION['err'] = "Error deleting the pet!";
        }
    } else {
        // If the pet doesn't exist, show an error
        $_SESSION['err'] = "Pet not found!";
    }
    
    // Free resources
    $stmt->close();
} else {
    // If no 'petid' is provided, redirect back to the pets page
    $_SESSION['err'] = "No pet selected to delete!";
    header("Location: gallery.php");
    exit();
}
$conn->close(); // Close the database connection

