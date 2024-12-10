<?php
$title = "Edit a Pet";
include "include/header.inc";
include "include/nav.inc";
include "include/db_connect.inc";

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Check if 'petid' is set in the URL
if (isset($_GET['petid'])) {
    $petid = $_GET['petid'];

    // Fetch the pet details from the database
    $sql = "SELECT * FROM pets WHERE petid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $petid);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the pet exists
    if ($result->num_rows > 0) {
        $pet = $result->fetch_assoc();

        // If the form is submitted, update the pet details
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $petname = $_POST['petname'];
            $age = intval($_POST['age']);
            $type = $_POST['type'];
            $location = $_POST['location'];
            $caption = $_POST['caption'];
            $description = $_POST['description'];

            // Handle optional image upload
            $image = $pet['image'];
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $image = $_FILES['image']['name'];
                $temp = $_FILES['image']['tmp_name'];
                move_uploaded_file($temp, 'images/' . $image);
            }

            // Update pet details in the database
            $updateSql = "UPDATE pets SET petname = ?, age = ?, type = ?, location = ?, caption = ?, description = ?, image = ? WHERE petid = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("sisssssi", $petname, $age, $type, $location, $caption, $description, $image, $petid);

            if ($updateStmt->execute()) {
                $_SESSION['usermsg'] = "Pet details updated successfully!";
                header("Location: details.php?petid=" . $petid);
                exit();
            } else {
                $_SESSION['err'] = "Error updating pet details: " . $updateStmt->error;
            }

            $updateStmt->close();
        }
    } else {
        $_SESSION['err'] = "Pet not found!";
        header("Location: pets.php");
        exit();
    }

    // Close statement
    $stmt->close();
} else {
    $_SESSION['err'] = "No pet selected for editing.";
    header("Location: pets.php");
    exit();
}

// Close the database connection
$conn->close();
?>

<main id="mainbody-3">
    <h1>Edit Pet Details</h1>

    <?php
    if (isset($_SESSION['err'])) {
        echo "<p style='color:red'>" . $_SESSION['err'] . "</p>";
        unset($_SESSION['err']);
    }
    if (isset($_SESSION['usermsg'])) {
        echo "<p style='color:green'>" . $_SESSION['usermsg'] . "</p>";
        unset($_SESSION['usermsg']);
    }
    ?>

    <!-- Editable Form with Pre-filled Values -->
    <form method="post" enctype="multipart/form-data" action="edit.php?petid=<?php echo $petid; ?>">
        <label for="petname">Pet Name: <span class="required">*</span></label>
        <input type="text" id="petname" class="box-style" name="petname" placeholder="Provide the name of the pet" value="<?php echo htmlspecialchars($pet['petname']); ?>" required />

        <label for="type">Type: <span class="required">*</span></label>
        <div>
            <select id="opt-box" name="type" required>
                <option value="">--Choose an option--</option>
                <option value="cat" <?php if ($pet['type'] === 'cat') echo 'selected'; ?>>Cat</option>
                <option value="dog" <?php if ($pet['type'] === 'dog') echo 'selected'; ?>>Dog</option>
                <option value="others" <?php if ($pet['type'] === 'others') echo 'selected'; ?>>Others</option>
            </select>
        </div>

        <label for="description">Description: <span class="required">*</span></label>
        <div>
            <textarea id="description" name="description" placeholder="Describe the pet briefly" required><?php echo htmlspecialchars($pet['description']); ?></textarea>
        </div>

        <label for="image">Select an image:</label>
        <input type="file" id="image" name="image" accept="image/*" />
        <span class="required-image"><i>MAX IMAGE SIZE: 500PX</i></span>
        <div id="current-img">
            <p id="current-label">Current Image:
                <?php if ($pet['image']): ?>
                    <img src="images/<?php echo htmlspecialchars($pet['image']); ?>" alt="Current pet image" width="100">
                <?php else: ?>
                    <span>No image uploaded</span>
                <?php endif; ?>
            </p>
        </div>

        <label for="caption">Image Caption: <span class="required">*</span></label>
        <div>
            <input type="text" id="caption" class="box-style" name="caption" placeholder="Describe the image" value="<?php echo htmlspecialchars($pet['caption']); ?>" required />
        </div>

        <label for="age">Age (months): <span class="required">*</span></label>
        <div>
            <input type="number" id="age" class="box-style" name="age" placeholder="Age of the pet in months" value="<?php echo htmlspecialchars($pet['age']); ?>" required />
        </div>

        <label for="location">Location: <span class="required">*</span></label>
        <div>
            <input type="text" id="location" class="box-style" name="location" placeholder="Location of the pet" value="<?php echo htmlspecialchars($pet['location']); ?>" required />
        </div>

        <div class="button-group">
            <button type="submit" id="add-pet">
                <span id="icon-submit"><img src="images/addtask.png" alt="Submit" /></span>Update Pet
            </button>

            <button href="details.php?petid=<?php echo $petid; ?>" id="cancel-button" >
                <span id="icon-clear"><img src="images/close.png" alt="Cancel" /></span>Cancel
            </button>
        </div>
    </form>
</main>

<?php include "include/footer.inc"; ?>