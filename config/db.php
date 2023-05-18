<?php // PDO Database Connection

$host = 'localhost';
$db_name = 'feedback_app';
$user = 'root';
$pass = '';

try {
	$dsn = new PDO('mysql:host=' . $host . ';dbname=' . $db_name, $user, $pass);
	$dsn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	// echo 'Connection successful, perform further operations here';

} catch (PDOException $e) {
	// Connection failed, handle the error
	echo die('<h3>Connection failed: ' . $e->getMessage() . '</h3>');
}

?>