<?php
$title = "Pets'homepage";
include "include/header.inc";
include "include/nav.inc";
include "include/db_connect.inc";

// Fetch pets data for the carousel
$sql = "SELECT * FROM pets";
$result = mysqli_query($conn, $sql);

if ($result) {
    $pets = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Free the result and leave connection open for other pages
    mysqli_free_result($result);
} else {
    echo "Error fetching pets data: " . mysqli_error($conn);
}

// Check for error message in session and display it
if (isset($_SESSION['error_message'])) {
    echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
    unset($_SESSION['error_message']); // Clear the message after displaying it
}
?>
<main>
    <div class="mainbody">
        <div id="mainframe">
            <div class="pictureframe">
                <div id="carouselIndicators" class="carousel slide" data-bs-ride="carousel">
                    <!-- Carousel Indicators -->
                    <div class="carousel-indicators">
                        <?php foreach ($pets as $index => $pet): ?>
                            <button type="button"
                                data-bs-target="#carouselIndicators"
                                data-bs-slide-to="<?php echo $index; ?>"
                                class="<?php echo $index === 0 ? 'active' : ''; ?>"
                                aria-label="Slide <?php echo $index + 1; ?>"></button>
                        <?php endforeach; ?>
                    </div>

                    <!-- Carousel Inner -->
                    <div class="carousel-inner d-flex align-items-center">
                        <?php foreach ($pets as $index => $pet): ?>
                            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                <div class="flex-container">
                                    <a href="details.php?petid=<?php echo $pet['petid']; ?>">
                                        <img src="images/<?php echo htmlspecialchars($pet['image']); ?>" class="d-block" alt="Pet Image">
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Carousel Controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            
            <div id="labelign">
                <div class="fontbody1">
                    <p>PETS VICTORIA</p>
                </div>

                <div class="fontbody2">
                    <p>WELCOME TO PET</p>
                    <p>ADOPTION</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
    <form class="d-flex align-items-center gap-3" method="GET" action="search.php">
        <!-- Search input -->
        <div class="flex-grow-1">
            <input class="form-control" type="search" name="petname" placeholder="I am looking for ..." aria-label="Search">
        </div>
        <!-- Select input -->
        <div style="min-width: 200px;">
            <select class="form-select" name="type" aria-label="Select pet type" required>
                <option selected disabled>Select your pet type</option>
                <option value="dog">Dog</option>
                <option value="cat">Cat</option>
                <option value="others">Others</option>
            </select>
        </div>
        <!-- Search button -->
        <div>
            <button class="btn btn-primary w-100" type="submit">Search</button>
        </div>
    </form>
</div>

    <div class="para1">
        <div id="headtext1">
            <b>Discover Pets Victoria</b>
        </div>

        <div id = "text1">
            <p>
                Pets Victoria is a dedicated pet adoption organiazation based in
                Victoria, Australia, focused on providing a safe and loving
                environment for pet in need. With a compasionate approach, Pets
                Victoria works tirelessly to rescue, rehabilate, and rehome dogs,
                cats, and other animals. Their mission is to connect these deserving
                pets with caring individuals and families, creating lifelong bonds.
                The organiazation offers a range of services, including adoption
                counseling, pet education, and community support programs, all aimed
                at promoting responsible pet ownership and reducing the number of
                homeless animals.
            </p>
        </div>
    </div>
</main>
<?php
include "include/footer.inc";
?>