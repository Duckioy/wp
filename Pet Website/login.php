<?php
$title = "Login";
include "include/header.inc";
include "include/nav.inc";
include "include/db_connect.inc"; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL to fetch the hashed password from the database
    $sql = "SELECT password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the stored hash
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        // Verify the provided password with the stored hash
        if (password_verify($password, $hashed_password)) {
            // Password is correct, log the user in
            $_SESSION['usermsg'] = "Login successful!";
            $_SESSION['username'] = $username; // Store the username in session to keep track of logged-in state
            header("Location: index.php"); // Redirect to index or another page
            exit(0);
        } else {
            // Password is incorrect
            $_SESSION['err'] = "Invalid username or password.";
            header("Location: login.php");
        }
    } else {
        // No user found with the given username
        $_SESSION['err'] = "Invalid username or password.";
        header("Location: login.php");
    }

    $conn->close();
    header("Location: login.php"); // Redirect back to the login page on failure
    exit(0);
}
?>

<main>
    <div class="text-center mb-5">
        <h1 class="display-5 mb-4" style="color: #264050; text-align: center; font-weight:bold;">Login</h1>
    </div>
    <form action="login.php" method="post">

        <!-- Display error messages if they exist -->
        <?php
        if (isset($_SESSION['err'])) {
            echo "<p style='color:red'>" . $_SESSION['err'] . "</p>";
            unset($_SESSION['err']);
        }
        ?>

        <div class="user-input">
            <div>
                <label for="username">Username:</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>
        </div>
        <section class="old-new-user">
            <button id="login-button" type="submit"><b>Login</b></button>
            <p>A New User? <a href="register.php">Register here!</a></p>
        </section>
    </form>
</main>

<?php
include "include/footer.inc";
