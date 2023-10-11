<?php include "../header.php"; ?>

<?php
// Retrieve the user_id from the URL
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    if (isset($_POST['submit'])) {

        $currentTimestamp = date('Y-m-d H:i:s');
      
        $query = "INSERT INTO timestamps (shopperid, Timestamp) VALUES ('$user_id', '$currentTimestamp')";

        $insertTimestampWithShopperID = mysqli_query($conn, $query);

        if ($insertTimestampWithShopperID) {
            echo "<p class='text-success'>Check-in successful! Timestamp and user_id recorded.</p>
";
        } else {
            echo "<p class='text-danger'>Error recording timestamp with user_id: " . mysqli_error($conn) . "</p>
";
        }
    }

    // Display the user ID
    $shopper_id = $_GET['user_id']; // Assuming you have the 'user_id' in the URL
} else {
    // Handle the case when 'user_id' is not provided in the URL
    echo "<p class='text-danger'>User ID not provided.</p>
";
}
?>

<div class="container">
    <h1 class="text-center">MMO Check-In</h1>
    <p>Are you checking in this person?</p>

    <form action="mmo.php?user_id=<?php echo $user_id; ?>" method="post">
        <!-- Hidden input to pass the user_id -->
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />

        <div class="form-group">
            <label>User ID:</label>
            <p>
                <?php echo $user_id; ?>
            </p>
            <!-- Display the user ID -->
        </div>

        <div class="form-group">
            <input type="submit" name="submit" value="Correct" class="btn btn-primary" />
            <a href="home.php" class="btn btn-warning">Back</a>
        </div>
    </form>
</div>

<!-- Footer -->
<?php include "../footer.php" ?>
