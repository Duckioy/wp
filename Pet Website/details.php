<?php
$title = "Pets' details";
include "include/header.inc";
include "include/nav.inc";
include "include/db_connect.inc";

// Check if 'petid' is set in the URL
if (isset($_GET['petid'])) {
    $petid = $_GET['petid'];

    // Prepare SQL to fetch the pet details by petid
    $sql = "SELECT * FROM pets WHERE petid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $petid);
    $stmt->execute();
    $result = $stmt->get_result();
    $pet = $result->fetch_assoc();

    // If the pet exists, display its details
    if ($pet) {
?>
        <main id="mainbody-5">
            <div class="detailsframe">
                <div class="info-img">
                    
                        <img id="mainpicture-3" src="images/<?php echo htmlspecialchars($pet['image']); ?>" alt="pet's picture">
                    

                    
                        <div class="icon-details">
                            <span><img src="images/alarm.png">
                                <p><?php echo htmlspecialchars($pet['age']); ?> months</p>
                            </span>
                            <span>
                                <img src="images/paw.png">
                                <p><?php echo htmlspecialchars($pet['type']); ?></p>
                            </span>
                            <span>
                                <img src="images/location.png">
                                <p><?php echo htmlspecialchars($pet['location']); ?></p>
                            </span>
                        </div>
                    
                    <?php
                    // Show Edit and Delete buttons only if the user is logged in
                    if (isset($_SESSION['username'])) {
                    ?>
                        <div class="action-buttons">
                            <a href="edit.php?petid=<?php echo $pet['petid']; ?>" class="btn btn-primary">Edit</a>
                            <a href="delete.php?petid=<?php echo $pet['petid']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this pet?');">Delete</a>
                        </div>
                    <?php
                    }
                    ?>
                </div>

                <div class="fontbody-5">
                    <h1><?php echo htmlspecialchars($pet['petname']); ?></h1>
                    <p><?php echo htmlspecialchars($pet['caption']); ?></p>
                </div>
            </div>
        </main>

<?php
    } else {
        echo "<p>Pet not found!</p>";
    }

    // Free resources
    $stmt->close();
} else {
    echo "<p>No pet selected!</p>";
}

include "include/footer.inc";
