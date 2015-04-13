<?php
session_start();

if(!isset($_SESSION['username'])) {
	$_SESSION['username'];
	$_SESSION['password'];
}

if (isset($_POST['submit'])) {
	$_SESSION['username'] = htmlentities($_POST['username']);
	$_SESSION['password'] = htmlentities($_POST['password']);
}

$username = $_SESSION['username'];
$password = $_SESSION['password'];

class account {

}

$oldmask = umask(0);
if(!mkdir("Files"))
	//die("Error: Failed to make folder.");
umask($oldmask);

$accounts_array = array();
$accounts_array = json_decode(file_get_contents("accounts.json"));

if (isset($_POST['submitter'])) {
	$target_dir = "Files/";
	$target_file = $target_dir . basename($_FILES["uploader"]["name"]);
	$uploadOk = 1;}

	if (move_uploaded_file($_FILES["uploader"]["tmp_name"], $target_file)) {
		$uploadOk = 1;
	}
	else {
		$uploadOk = 0;
	}
}
$found = 0;
foreach ($accounts_array as $value) {
	
	if ($value->username === $username) {
		if ($value->password === $password) {
			$found = 1;
		}
	}	
}
if (!$found)
	die("Incorrect username or password.");
?>

<html>
<head>
<title>Ben-Box</title>

</head>

<body>
<div align='center'><h1>Welcome to Ben-Box</div>

<br>
<h3>Hello, <?php echo $username;?>!
<br>
<br>
<form action="login.php" method="post">
<input type="submit" name="logout" value="Logout">
</form>

<br>
<h4>Files:
<br>
<form action="" method="post">
<?php 
$dir = "Files/";
if (isset($_POST['delete'])) {
	foreach($_POST['check_list'] as $key) {
		if ($key !== "delete") {
			$addy = $dir . $key;
			if (!unlink($addy))
				echo "Deletion failed.\n";
		}
	}	
}


$files = scandir($dir);

foreach($files as $value) {
	if ($value != "." && $value != "..") {
	echo "<input type=\"checkbox\" name=\"check_list[]\" value=\"" . $value . "\">";
	echo "<a href=\"/Files/" . $value . "\">" . $value . "</a>";
	echo "<br>";
	}
}
echo "<br>";
?>
<input type="submit" value="Delete Selected Files" name="delete">
</form>
<hr>
<h4>Upload a file:
<br>
<form action="" method="post" enctype="multipart/form-data">
<input type="file" name="uploader">
<br>
<input type="submit" name="submitter" value="Upload">
</form>

</body>
</html>
