<?php
  require_once('../private/initialize.php');

	$firstName = "";
	$lastName = "";
	$email = "";
	$username = "";

	// If the values are posted, update the defaults. If not, the form was not submitted.
	if (isSubmitted()) {
		$firstName = htmlentities($_POST["firstName"]);
		$lastName = htmlentities($_POST["lastName"]);
		$email = htmlentities($_POST["email"]);
		$username = htmlentities($_POST["username"]);
	}

	// This function checks if there is any values in the fields. If there is, it returns
	// true. If none of the fields have values, the function returns false.
	function isSubmitted() {
		if (isset($_POST["firstName"]) || isset($_POST["lastName"]) || isset($_POST["email"]) || isset($_POST["username"])) {
			return true;
		}
		return false;
	}

	function printForm($firstName, $lastName, $email, $username) {
		echo '
		<form class="col s6" action="" method="POST">';
		printName($firstName, $lastName);
		printEmail($email);
		printUsername($username);
		echo '<input type="submit" value="Submit">
		</form>
		';
	}

	function printName($firstName, $lastName){
		echo '<p><span>First Name: <input type="text" name="firstName" value="' . $firstName . '"></span>';
		echo '<p><span>Last Name: <input type="text" name="lastName" value="' . $lastName . '"></span>

		</p>';
	}
	function printEmail($email){
		echo '<p><span>E-mail: <input type="text" name="email" value="' . $email . '"></span>';
	}
	function printUsername($username){
		echo '<p><span>Username: <input type="text" name="username" value="' . $username . '"></span>';
	}

	function hasErrors($firstName, $lastName, $email, $username){
		if(!hasFieldData($firstName)){
			return true;
		}
		else if(!hasAtLeast($firstName, 2) || !isLessThan($firstName, 255)){
			return true;
		}

		//last Name
		if(!hasFieldData($lastName)){
			return true;
		}
		else if(!hasAtLeast($lastName, 2) || !isLessThan($lastName, 255)){
			return true;
		}

		//email
		if(!hasFieldData($email)){
			return true;
		}
		else if(!isLessThan($email, 255)){
			return true;
		}
		else if(!containsAtSymbol($email)){
			return true;
		}

		//username
		if(!hasFieldData($username)){
			return true;
		}
	  if(!hasAtLeast($username,8) || !isLessThan($username, 255)){
			return true;
		}
		return false;
	}

	//Checks if there are any errors with the values. If there is not, submit the values
	//If there is, then prompt the user to correct their values!
	function errorCheck($firstName, $lastName, $email, $username, $db){
		if(isSubmitted()){
			if(hasErrors($firstName, $lastName, $email, $username)){
				printErrors($firstName, $lastName, $email, $username);
			}
			else{
				//submit the values the mySQL server and then redirect to the registration success page
        // Write SQL INSERT statement
        $sql = "INSERT INTO users
        (first_name, last_name, email, username, created_at)
        VALUES ('" . mysqli_real_escape_string($db, $firstName) . "', '".
        mysqli_real_escape_string($db, $lastName)."', '".mysqli_real_escape_string($db, $email)
        ."','".mysqli_real_escape_string($db, $username)."', '".date("Y-m-d H:i:s")."');";

        // For INSERT statments, $result is just true/false
        $result = db_query($db, $sql);
        if($result) {
          db_close($db);
            header('Location: registration_success.php');
        } else {
        //   // The SQL INSERT statement failed.
        //   // Just show the error, not the form
        echo db_error($db);
        db_close($db);
        }
			}
		}
	}

	//Print the errors found with the given inputs
	function printErrors($firstName, $lastName, $email, $username){
  		echo '<p>Please fix the following errors: </p>';
  	echo '<ul>';

  	//first Name
  	if(!hasFieldData($firstName)){
  		echo '<li>First name cannot be blank</li>';
  	}
  	else if(!hasAtLeast($firstName, 2) || !isLessThan($firstName, 255)){
  		echo '<li>First name must be between 2 and 255 characters</li>';
  	}

  	//last Name
  	if(!hasFieldData($lastName)){
  		echo '<li>Last name cannot be blank</li>';
  	}
  	else if(!hasAtLeast($lastName, 2) || !isLessThan($lastName, 255)){
  		echo '<li>Last name must be between 2 and 255 characters</li>';
  	}

  	//email
  	if(!hasFieldData($email)){
  		echo '<li>Email cannot be blank</li>';
  	}
  	else if(!isLessThan($email, 255)){
  		echo '<li>Email must be less than 255 characters</li>';
  	}
  	else if(!containsAtSymbol($email)){
  		echo '<li>Email must be a valid format</li>';
  	}

  	//username
  	if(!hasFieldData($username)){
  		echo '<li>Username cannot be blank</li>';
  	}
  	else if(!hasAtLeast($username,8) || !isLessThan($username, 255)){
  		echo '<li>Username must be between 8 and 255 characters</li>';
  	}
  	echo '</ul>';
	}

?>

<?php $page_title = 'Register'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <h1>Register</h1>
  <p>Register to become a Globitek Partner.</p>

  <?php
	errorCheck($firstName, $lastName, $email, $username, $db);
	printForm($firstName, $lastName, $email, $username);
	?>

</div>

<?php include(SHARED_PATH . '/footer.php');?>
