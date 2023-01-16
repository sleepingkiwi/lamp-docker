<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Hello!</title>

	<style>
		html {
			height: 100%;
		}

		body {
			min-height: 100%;
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
		}
	</style>
</head>
<body>
<h1>
	<?php
		echo('👻');
	?>
</h1>

<pre>
<?php
// The MySQL service name from docker-compose.yml.
$host = 'db_example_site';

$user = 'local';
$pass = 'local';

$conn = new mysqli($host, $user, $pass);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo("Connected to MySQL server successfully!");
}
?>
<pre>
</body>
</html>
