<?php

include 'inc/header.php';

// Set vars to empty values
$name = $email = $body = '';
$nameErr = $emailErr = $bodyErr = '';

// Form submit
if (isset($_POST['submit'])) {
	// Validate name
	if (empty($_POST['name'])) {
		$nameErr = 'Name is required';
	} else {
		$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	// Validate email
	if (empty($_POST['email'])) {
		$emailErr = 'Email is required';
	} else {
		$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
	}

	// Validate body
	if (empty($_POST['body'])) {
		$bodyErr = 'Body is required';
	} else {
		$body = filter_input(INPUT_POST, 'body', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	if (empty($nameErr) && empty($emailErr) && empty($bodyErr)) {
		try {
			// PDO DB Connection
			$host = 'localhost';
			$db = 'feedback_app';
			$user = 'root';
			$pass = '';

			$dsn = "mysql:host=$host;dbname=$db;charset=utf8";
			$options = [
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				PDO::ATTR_EMULATE_PREPARES => false,
			];
			$conn = new PDO($dsn, $user, $pass, $options);

			// Prepare the SQL statement
			$sql = "INSERT INTO feedback (`feedback_user_name`, `feedback_user_email`, `feedback_body`) VALUES (:name, :email, :body)";
			$stmt = $conn->prepare($sql);

			// Bind the parameters
			$stmt->bindParam(':name', $name);
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':body', $body);

			// Execute the statement
			$stmt->execute();

			// Success
			header('Location: feedback.php');
			exit();
		} catch (PDOException $e) {
			// Error
			echo 'Error: ' . $e->getMessage();
		}
	}
}
?>

<h2>Feedback</h2>
<?php echo isset($name) ? $name : ''; ?>
<p class="lead text-center">Leave feedback for Traversy Media</p>

<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="mt-4 w-75">
	<div class="mb-3">
		<label for="name" class="form-label">Name</label>
		<input type="text" class="form-control <?php echo !$nameErr ?: 'is-invalid'; ?>" id="name" name="name"
			placeholder="Enter your name" value="<?php echo $name; ?>">
		<div id="validationServerFeedback" class="invalid-feedback">
			Please provide a valid name.
		</div>
	</div>

	<div class="mb-3">
		<label for="email" class="form-label">Email</label>
		<input type="email" class="form-control <?php echo !$emailErr ?: 'is-invalid'; ?>" id="email" name="email"
			placeholder="Enter your email" value="<?php echo $email; ?>">
	</div>

	<div class="mb-3">
		<label for="body" class="form-label">Feedback</label>
		<textarea class="form-control
				<?php echo !$bodyErr ?: 'is-invalid'; ?>" id="body" name="body"
			placeholder="Enter your feedback"><?php echo $body; ?></textarea>
	</div>
	<div class="mb-3">
		<input type="submit" name="submit" value="Send" class="btn btn-dark w-100">
	</div>
</form>

<?php include 'inc/footer.php'; ?>