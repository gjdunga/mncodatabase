<!-- Header -->
<?php include "../header.php" ?>

<?php
$currentTimestamp = date('Y-m-d H:i:s');


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $requiredFields = ['firstname', 'lastname', 'streetaddress', 'city', 'state', 'zip'];
    $binaryFields = ['isveteran', 'shopperscard', 'newneighbor', 'hasbenefits'];
    $numericFields = ['seniors', 'adults', 'kids', 'cats', 'dogs'];
    $errors = [];

    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $errors[] = "The field '{$field}' is required.";
        }
    }

    foreach ($binaryFields as $field) {
        if (isset($_POST[$field]) && !in_array($_POST[$field], [0, 1])) {
            $errors[] = "The field '{$field}' must be either 0 or 1.";
        }
    }

    foreach ($numericFields as $field) {
        if (isset($_POST[$field]) && !is_numeric($_POST[$field])) {
            $errors[] = "The field '{$field}' must be a number or 0.";
        }
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO neighbors(regdate, firstname, lastname, streetaddress, city, state, zip, isveteran, veterandep, shopperscard, newneighbor, hasbenefits, seniors, adults, kids, cats, dogs, ethnicity)
                                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        // Handle checkboxes that might not be set
        $isVeteran = isset($_POST['isveteran']) ? $_POST['isveteran'] : 0;
        $veteranDep = isset($_POST['veterandep']) ? 1 : 0;
        $shopperscard = isset($_POST['shopperscard']) ? $_POST['shopperscard'] : 0;
        $newneighbor = isset($_POST['newneighbor']) ? $_POST['newneighbor'] : 0;
        $hasbenefits = isset($_POST['hasbenefits']) ? $_POST['hasbenefits'] : 0;
                
        $stmt->bind_param("ssssssiiiiiiiiiiis", $currentTimestamp, $_POST['firstname'], $_POST['lastname'], $_POST['streetaddress'], $_POST['city'], $_POST['state'], $_POST['zip'], $isVeteran, $veteranDep, $shopperscard, $newneighbor, $hasbenefits, $_POST['seniors'], $_POST['adults'], $_POST['kids'], $_POST['cats'], $_POST['dogs'], $_POST['ethnicity']);
        if (!$stmt->execute()) {
            echo "Something went wrong: " . $stmt->error;
        } else {
            echo "<script type='text/javascript'>alert('User added successfully!')</script>";
        }
    } else {
        foreach ($errors as $error) {
            echo "<p>{$error}</p>";
        }
        echo '<a href="create.php" class="btn btn-warning mt-2">Back</a>';
    }
}
?>

<h1 class="text-center">Add User details </h1>
 
 <div class="container">
    <form action="create.php" method="post">

       <div class="form-group">
            <label for="regdate">Date Registered</label>
            <input type="text" name="regdate" class="form-control" value="<?php echo $currentTimestamp ?>" />
        </div>
        <small id="regdateHelp" class="form-text text-muted">Date person first signed up.</small>

        <div class="form-group">
            <label for="firstname">First Name</label>
            <input type="text" name="firstname" class="form-control" value="" />
        </div>
        <small id="firstnameHelp" class="form-text text-muted">Persons First Name.</small>

        <div class="form-group">
            <label for="lastname">Last Name</label>
            <input type="text" name="lastname" class="form-control" value="" />
        </div>
        <small id="LastnameHelp" class="form-text text-muted">Persons Last Name.</small>

        <div class="form-group">
            <label for="streetaddress">Street Address</label>
            <input type="text" name="streetaddress" class="form-control" value="" />
        </div>
        <small id="streetaddressHelp" class="form-text text-muted">Mailing Address.</small>

        <div class="form-group">
            <label for="city">City</label>
            <input type="text" name="city" class="form-control" value="" />
        </div>
        <small id="cityHelp" class="form-text text-muted">City person resides in.</small>

        <div class="form-group">
            <label for="state">State</label>
            <input type="text" name="state" class="form-control" value="" />
        </div>
        <small id="emailHelp" class="form-text text-muted">State Person resides in.</small>


        <div class="form-group">
            <label for="zip">Zip Code</label>
            <input type="number" name="zip" class="form-control" value="" />
        </div>
        <small id="zipHelp" class="form-text text-muted">Zip Code Person Resides In.</small>

        <div class="form-group">
            <label for="isveteran">Is A Veteran</label>
            <input type="checkbox" name="isveteran" value="1" class="form-check-input" />
        </div>
        <small id="isvetranHelp" class="form-text text-muted">Checked is True (1) Unchecked is false (0).</small>


        <div class="form-group">
            <label for="veterandep">Number of Veteran Dependants.</label>
            <input type="number" name="veterandep" class="form-control">
        </div>
        <small id="veterandepHelp" class="form-text text-muted">If Person is a Veteran, Count all people in household as dependants!</small>


        <div class="form-group">
            <label for="shopperscard">Does Family have a Cupboard Shoppers Card?</label>
            <input type="checkbox" name="shopperscard" value="1" class="form-check-input">
        </div>
        <small id="shopperscardHelp" class="form-text text-muted">Checked is True (1) Unchecked is false (0).</small>


        <div class="form-group">
            <label for="newneighbor">Has never been to a MMO Event Before?</label>
            <input type="checkbox" name="newneighbor" value="1" class="form-check-input" >
        </div>
        <small id="newneighborHelp" class="form-text text-muted">Checked is True (1) Unchecked is false (0).</small>


        <div class="form-group">
            <label for="hasbenefits">Has Goverment Benefits</label>
            <input type="checkbox" name="hasbenefits" value="1" class="form-check-input" />
        </div>
        <small id="hasbenefitsHelp" class="form-text text-muted">Checked is True (1) Unchecked is false (0).</small>


        <div class="form-group">
            <label for="seniors">Number of 60+ Seniors in the household?</label>
            <input type="number" name="seniors" class="form-control" value="" />
        </div>
        <small id="SeniorHelp" class="form-text text-muted">Number of 60+ year old People in the family.</small>

        <div class="form-group">
            <label for="adults">Number of Adults (18 - 59) in the household?</label>
            <input type="number" name="adults" class="form-control" value="" />
        </div>
        <small id="adultsHelp" class="form-text text-muted">Number of 18 - 59 Year old people in the family.</small>

        <div class="form-group">
            <label for="kids">Children (0 - 17) In the Household?</label>
            <input type="number" name="kids" class="form-control" value="" />
        </div>
        <small id="kidsHelp" class="form-text text-muted">Number of children in the family.</small>

        <div class="form-group">
            <label for="cats">Number of Cats in the household?</label>
            <input type="number" name="cats" class="form-control" value="" />
        </div>
        <small id="catsHelp" class="form-text text-muted">Number of Cats in the family.</small>

        <div class="form-group">
            <label for="dogs">Number of Dogs in the household?</label>
            <input type="number" name="dogs" class="form-control" value="" />
        </div>
        <small id="dogsHelp" class="form-text text-muted">Number of dogs in the family.</small>
             
  <div class="form-group">
            <label for="ethnicity">ethnicity ?</label>
            <input type="text" name="ethnicity" class="form-control" value="" />
        </div>
        <small id="ethnicityHelp" class="form-text text-muted">Latino = L /White = W /Black = B /Asian = A /Hawaian = H /Indian = I /2 or more = 2 /Refuse = N </small>
        
            
        
        <div class="form-group">
        <input type="submit"  name="create" class="btn btn-primary mt-2" value="submit">
      </div>
    </form> 
  </div>
 
   <!-- a BACK button to go to the home page -->
  <div class="container text-center mt-5">
    <a href="home.php" class="btn btn-warning mt-5"> Back </a>
  <div>

<!-- Footer -->
<?php include "../footer.php" ?>
