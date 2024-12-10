<?php
$title = "Assessment 2.2";
include "include/header.inc";
include "include/nav.inc";
include "include/db_connect.inc";
// Fetch pets data
$sql = "SELECT * FROM pets";
$result = mysqli_query($conn, $sql);
$pets = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Free the result and leave connection open for other pages
mysqli_free_result($result);
?>
<main id="mainbody-2">
    <div id="fontbody3">
        <strong>Discover Pets Victoria</strong>
    </div>

    <div id="fontbody4">
        <b>
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
        </b>
    </div>

    <img id="mainpicture-2" src="images/pets.jpeg" alt="2 dogs and 2 cats" />

    <table class="details-link">
        <tr>
            <th>Pet</th>
            <th>Type</th>
            <th>Age</th>
            <th>Location</th>
        </tr>
        <?php foreach ($pets as $pet): ?>
            <tr>
                <td>
                    <a href="details.php?petid=<?php echo $pet['petid']; ?>">
                        <u><?php echo htmlspecialchars($pet['petname']); ?></u>
                    </a>
                </td>
                <td><?php echo htmlspecialchars($pet['type']); ?></td>
                <td><?php echo htmlspecialchars($pet['age']); ?> months</td>
                <td><?php echo htmlspecialchars($pet['location']); ?></td>
            </tr>
        <?php endforeach; ?>

    </table>
</main>
<?php
include "include/footer.inc";
