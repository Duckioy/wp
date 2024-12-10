<?php
$title = "Pet's gallery";
include "include/header.inc";
include "include/nav.inc";
include "include/db_connect.inc";

$type = isset($_GET['type']) ? mysqli_real_escape_string($conn, $_GET['type']) : '';

$sql = "SELECT * FROM pets";
if (!empty($type)) {
    $sql .= " WHERE type = '$type'";
}
$result = mysqli_query($conn, $sql);
$pets = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result);
?>

<main class="container py-5">
    <!-- Hero Section -->
    <div class="text-center mb-5">
        <h1 class="display-5 mb-4" style="color: #264050; text-align: center; font-weight:bold;">Pets Victoria has a lot to offer!</h1>
        <p class="text-muted mx-auto" style="max-width: 1200px; line-height: 1.8; letter-spacing: 0.5px;">
            For almost two decades, Pets Victoria has helped in creating true social change by bringing pet adoption into the mainstream. Our work has helped make a difference to the Victorian rescue community and thousands of pets in need of rescue and rehabilitation. But, until every pet is safe, respected, and loved, we all still have big, hairy work to do.
        </p>
    </div>

    <!-- Filter Dropdown -->
    <div id="search-box" class="mb-4">
    <form id="filterForm">
      <select name="type" class="form-select" onchange="filterPets(this.value)">
        <option value="">All Pets</option>
        <option value="Dog" <?php echo ($type === 'Dog') ? 'selected' : ''; ?>>Dogs</option>
        <option value="Cat" <?php echo ($type === 'Cat') ? 'selected' : ''; ?>>Cats</option>
        <option value="Others" <?php echo ($type === 'Others') ? 'selected' : ''; ?>>Others</option>
      </select>
    </form>
  </div>

    <!-- Pets Grid -->
    <div class="row g-4 justify-content-center">
        <?php if (count($pets) > 0): ?>
            <?php foreach ($pets as $pet): ?>
                <div class="col-md-4">
                    <div class="pet-card">
                        <a href="details.php?petid=<?php echo $pet['petid']; ?>" class="text-decoration-none">
                            <div class="card rounded-3 border-0 h-100">
                                <div class="card-img-wrapper">
                                    <img src="images/<?php echo htmlspecialchars($pet['image']); ?>" 
                                         class="card-img-top" 
                                         alt="<?php echo htmlspecialchars($pet['petname']); ?>">
                                    <div class="overlay">
                                        <div class="discover-more">
                                            <span class="material-symbols-outlined white size-40">search</span>
                                            <p>Discover more!</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body text-center">
                                    <h5 class="pet-name"><?php echo htmlspecialchars($pet['petname']); ?></h5>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <p class="text-muted">No pets found matching your search criteria. Please try again.</p>
            </div>
        <?php endif; ?>
    </div>
</main>

<script>
  function filterPets(type) {
    // Get the current URL
    let url = new URL(window.location.href);

    // Update or remove the type parameter
    if (type) {
      url.searchParams.set('type', type);
    } else {
      url.searchParams.delete('type');
    }

    // Redirect to the new URL
    window.location.href = url.toString();
  }

  //Highlight the current selection
  document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const currentType = urlParams.get('type');
    if (currentType) {
      document.querySelector('select[name="type"]').value = currentType;
    }
  });
</script>

<?php
include "include/footer.inc";
