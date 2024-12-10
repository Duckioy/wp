<?php
$title = "Assessment 2.5";
include "include/header.inc";
include "include/nav.inc";
include "include/db_connect.inc";

// Check if 'petid' is set in the URL
if (isset($_GET['petid'])) {
    $petid = $_GET['petid'];

    // Prepare SQL to fetch the pet details by petid
    $sql = "SELECT * FROM pets WHERE petid = ?";
    //Prevent SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $petid);
    $stmt->execute();
    //Retrieve and handle the result of the SQL query executed by the prepared statement.
    $result = $stmt->get_result();
    $pet = $result->fetch_assoc();

    // If the pet exists, display its details
    if ($pet) {
?>
        <main id="mainbody-5">
            <div>
                <img id="mainpicture-3" src="images/<?php echo htmlspecialchars($pet['image']); ?>" alt="pets'picture">
            </div>
            <div>
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

            </div>
            <div class="fontbody-5">
                <h2><?php echo htmlspecialchars($pet['petname']); ?></h2>
                <p><?php echo htmlspecialchars($pet['caption']); ?></p>
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
