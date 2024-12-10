<?php
$title = "Register";
include "include/header.inc";
include "include/nav.inc";
include "include/db_connect.inc";


if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $sql = "INSERT INTO users (username, password, reg_date) VALUES (?, ?, NOW())";
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Use password_hash for secure password storage
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $hashed_password);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['usermsg'] = "You have successfully registered";
        $conn->close();
        header("Location: login.php");
        exit(0);
    } else {
        $_SESSION['err'] = "An error has occurred";
    }

    $conn->close();
}
?>

<main>
    <div class="text-center mb-5">
        <h1 class="display-5 mb-4" style="color: #264050; text-align: center; font-weight:bold;">Sign up</h1>
    </div>
    <form action="register.php" method="post">
        <?php
        if (isset($_SESSION['err'])) {
            echo "<p style='color:red'>" . $_SESSION['err'] . "</p>";
            unset($_SESSION['err']);
        }
        ?>
        <div class="user-input">
            <div>
                <label for="username">Username:</label>
                <input type="text" name="username" class="form-control" id="username" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>
        </div>
        <section class="old-new-user">
            <button id="register-button" type="submit">Register</button>
            <p>Already a member? <a href="login.php">Login here!</a></p>
        </section>
    </form>
</main>

<?php
include "include/footer.inc";
?>