<footer>
  <div>
    <!-- Check the sesstion variable and read the username at the footer after logging in -->
    <?php if (isset($_SESSION['username'])): ?>
      <a href="user.php?username=<?php echo htmlspecialchars($_SESSION['username']); ?>" aria-label="View profile of <?php echo htmlspecialchars($_SESSION['username']); ?>">
        <?php echo htmlspecialchars($_SESSION['username']); ?>
      </a>
    <?php else: ?>
      <!-- Display the guest link when no user is logged in -->
      <a href="user.php" aria-label="Guest access">Guest</a>
    <?php endif; ?>

  </div>
  <b>&copy; Copyright s4038230. All rights reserved | Designed for Pets Victoria</b>
</footer>
</body>

</html>