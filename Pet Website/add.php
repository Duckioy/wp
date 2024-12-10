<?php
$title = "Add a pet";
include "include/header.inc";
include "include/nav.inc";
include "include/db_connect.inc";


// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Collect form data
  $petname = trim($_POST['petname']);
  $type = trim($_POST['Choice']);
  $description = trim($_POST['description']);
  $caption = trim($_POST['img-caption']);
  $age = intval($_POST['age']); // Convert to integer
  $location = trim($_POST['location']);

  // Handle file upload
  if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $image = $_FILES['image']['name'];
    $temp = $_FILES['image']['tmp_name'];

    // Insert the data into the database using prepared statements
    if (!empty($petname) && !empty($type) && !empty($description) && !empty($caption) && !empty($age) && !empty($location) && !empty($image)) {
      // Prepare the SQL statement
      $sql = "INSERT INTO pets (petname, description, image, caption, age, location, type) VALUES (?, ?, ?, ?, ?, ?, ?)";
      $stmt = $conn->prepare($sql);

      if ($stmt) { // Check if statement preparation was successful
        // Bind the parameters to the statement
        $stmt->bind_param("ssssdss", $petname, $description, $image, $caption, $age, $location, $type);

        // Execute the statement
        if ($stmt->execute()){
        move_uploaded_file($temp, 'images/' . $image);
        header("Location: gallery.php" );
        }

        // Close the statement
        $stmt->close();
      };
    };
  };
};
?>

<main id="mainbody-3">
  <div id="fontbody5">
    <strong>Add a pet</strong>
  </div>

  <div id="fontbody6">
    <p>You can add a new pet here</p>
  </div>

  <form method="post" enctype="multipart/form-data">
    <label for="pname">Pet Name: <span class="required">*</span></label>
    <input type="text" class="box-style" name="petname" placeholder="Provide the name of the pet" required />

    <label for="type">Type: <span class="required">*</span></label>
    <div>
      <select id="opt-box" name="Choice" required>
        <option value selected>--Choose an option--</option>
        <option value="cat">Cat</option>
        <option value="dog">Dog</option>
        <option value="others">Others</option>
      </select>
    </div>

    <label for="description">Description: <span class="required">*</span></label>
    <div>
      <textarea name="description" placeholder="Describe the pet briefly" required></textarea>
    </div>

    <div>
      <label for="select-img">Select an image: <span class="required">*</span></label>
      <input type="file" name="image" required />
      <span class="required-image"><i>MAX IMAGE SIZE: 500PX</i></span>
    </div>

    <label for="img-caption">Image Caption: <span class="required">*</span></label>
    <div>
      <input type="text" class="box-style" name="img-caption" placeholder="Describe the image" required />
    </div>

    <label for="age">Age (months): <span class="required">*</span></label>
    <div>
      <input type="number" class="box-style" name="age" placeholder="Age of the pet in months" required />
    </div>

    <label for="locations">Location: <span class="required">*</span></label>
    <div>
      <input type="text" class="box-style" name="location" placeholder="Location of the pet" required />
    </div>

    <div>
      <button id="add-pet" type="submit" value="submit">
        <span id="icon-submit"><img src="images/addtask.png" /></span>Submit
      </button>

      <button id="cancel-button" type="reset" value="clear">
        <span id="icon-clear"><img src="images/close.png" /></span>Clear
      </button>
    </div>
  </form>
</main>

<?php
include "include/footer.inc";
?>