<?php // Feedback List

include 'inc/header.php';

// PDO DB Connection
$host = 'localhost';
$db = 'feedback_app';
$user = 'root';
$pass = '';

try {
	$dsn = "mysql:host=$host;dbname=$db;charset=utf8";
	$options = [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES => false,
	];
	$conn = new PDO($dsn, $user, $pass, $options);

	$sql = 'SELECT * FROM feedback';
	$stmt = $conn->query($sql);
	$feedback = $stmt->fetchAll(PDO::FETCH_ASSOC);

	if (empty($feedback)) {
		echo '<p class="lead mt-3">There is no feedback</p>';
	} else {
		foreach ($feedback as $item) {
			echo '
            <div class="card my-3 w-75">
                <div class="card-body text-center">
                    ' . $item['feedback_body'] . '
                    <div class="text-secondary mt-2">By ' . $item['feedback_user_name'] . ' on ' . date_format(date_create($item['feedback_date']), 'g:ia \o\n l jS F Y') . '</div>
                </div>
            </div>
            ';
		}
	}
} catch (PDOException $e) {
	echo 'Error: ' . $e->getMessage();
}

include 'inc/footer.php';
?>