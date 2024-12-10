<?php
session_start();
include "include/header.inc";
include "include/db_connect.inc";

// Check if AJAX request for type filtering
if (isset($_GET['type']) && !isset($_GET['petname'])) {
    $type = mysqli_real_escape_string($conn, $_GET['type']);
    
    // Build SQL query based on type filter
    $sql = "SELECT * FROM pets";
    if (!empty($type)) {
        $sql .= " WHERE type = '$type'";
    }

    $result = mysqli_query($conn, $sql);
    $pets = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Output the filtered pets data for AJAX request
    if (count($pets) > 0) {
        foreach ($pets as $pet) {
            echo '<div class="details-link">';
            echo '  <div class="imgbox">';
            echo '    <a href="details.php?petid=' . $pet['petid'] . '">';
            echo '      <img class="fade" src="images/' . htmlspecialchars($pet['image']) . '" alt="pet-picture"/>';
            echo '      <p>' . htmlspecialchars($pet['petname']) . '</p>';
            echo '      <div class="overlay">';
            echo '        <span><img src="images/blacksearchingtool.png" alt="search"/>';
            echo '        <p>Discover more!</p>';
            echo '      </span>';
            echo '    </a>';
            echo '  </div>';
            echo '</div>';
        }
    } else {
        echo '<p>No pets found matching your search criteria. Please try again.</p>';
    }
    exit; // End the script for AJAX response
}

// Check if form was submitted with both petname and type
if (isset($_GET['petname']) && isset($_GET['type'])) {
    $petname = mysqli_real_escape_string($conn, $_GET['petname']);
    $type = mysqli_real_escape_string($conn, $_GET['type']);

    if (empty($petname)) {
        // If no pet name is provided, redirect to gallery.php with the selected pet type
        header("Location: gallery.php?type=$type");
        exit;
    }

    // Build SQL query to search for pet with given name and type
    $sql = "SELECT * FROM pets WHERE petname LIKE '%$petname%' AND type = '$type'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch the first matching pet
        $pet = mysqli_fetch_assoc($result);

        // Redirect to the details page for that pet
        header("Location: details.php?petid=" . $pet['petid']);
        exit;
    } else {
        // If no results, set error message in session
        $_SESSION['error_message'] = "No pet found with the name '$petname' and type '$type'. Please try again.";
        header("Location: index.php"); // Redirect back to the index page
        exit;
    }
} else {
    $_SESSION['error_message'] = "Please provide both pet name and type.";
    header("Location: index.php"); // Redirect back to the index page
    exit;
}
?>
