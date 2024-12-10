<?php
$title = "User's Collection";
include "include/header.inc";
include "include/nav.inc";
include "include/db_connect.inc";

// Initialize variables
$pets = [];
$error_message = '';
$is_logged_in = isset($_SESSION['username']);

try {
    // Fetch all pets from the database
    $sql = "SELECT * FROM pets";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        throw new Exception("Database error: " . mysqli_error($conn));
    }

    $pets = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
} catch (Exception $e) {
    $error_message = "An error occurred: " . htmlspecialchars($e->getMessage());
    error_log($e->getMessage());
}

$conn->close();
?>
<?php if ($error_message): ?>
    <div class="alert alert-danger">
        <?php echo $error_message; ?>
    </div>
<?php endif; ?>
<main id="mainbody-5">
    <?php if ($is_logged_in): ?>
        <h1 aria-label="View profile of <?php echo htmlspecialchars($_SESSION['username']); ?>">
            <?php echo htmlspecialchars($_SESSION['username']); ?>'s collection
        </h1>
    <?php else: ?>
        <h1 aria-label="Guest access">Guest's Collection</h1>
    <?php endif; ?>

    <div class="usersframe">
    <?php foreach ($pets as $pet): ?>
        <div class="pet-container">
            <div class="info-img">
                <img id="mainpicture-3" src="images/<?php echo htmlspecialchars($pet['image']); ?>" alt="Picture of <?php echo htmlspecialchars($pet['petname']); ?>">
                
                <div class="icon-details">
                    <span>
                        <img src="images/alarm.png" alt="Age icon">
                        <p><?php echo htmlspecialchars($pet['age']); ?> months</p>
                    </span>
                    <span>
                        <img src="images/paw.png" alt="Type icon">
                        <p><?php echo htmlspecialchars($pet['type']); ?></p>
                    </span>
                    <span>
                        <img src="images/location.png" alt="Location icon">
                        <p><?php echo htmlspecialchars($pet['location']); ?></p>
                    </span>
                </div>

                <?php if ($is_logged_in): ?>
                    <div class="action-buttons">
                        <a href="edit.php?petid=<?php echo $pet['petid']; ?>" class="btn btn-primary" style="background-color:#008080;">Edit</a>
                        <a href="delete.php?petid=<?php echo $pet['petid']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this pet?');">Delete</a>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="fontbody-5">
                <h1><?php echo htmlspecialchars($pet['petname']); ?></h1>
                <p><?php echo htmlspecialchars($pet['caption']); ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>

</main>

<?php
include "include/footer.inc";
?>