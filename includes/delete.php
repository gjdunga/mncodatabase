<!-- Footer -->
<?php include "../header.php" ?>

<?php
if (isset($_GET['delete'])) {
    $userid = $_GET['delete'];

    // Check if the user submitted a password
    if (isset($_POST['password'])) {
        $password = $_POST['password'];

        // Check if the password is correct
        if ($password === "HowdyNeighbor") {
            // Password is correct, proceed with deletion
            // SQL query to delete data from the neighbors table where id = $userid
            $query = "DELETE FROM neighbors WHERE id = {$userid}";
            $delete_query = mysqli_query($conn, $query);
            header("Location: home.php");
        } else {
            // Password is incorrect, display an error message
            echo "Incorrect password. Deletion canceled.";
        }
    }

    // Display the password input form
    echo '<form method="POST" action="">
            <label for="password">Enter Password:</label>
            <input type="password" name="password" required>
            <input type="submit" value="Delete">
          </form>';

    // Add a back button
    echo '<a href="../includes/home.php">Back to Home</a>';
}
?>

<!-- Footer -->
<?php include "../footer.php" ?>