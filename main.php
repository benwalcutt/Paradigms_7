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
if(!mkdir("Files")) {
	//die("Error: Failed to make folder.");
}
umask($oldmask);

$accounts_array = array();
$accounts_array = json_decode(file_get_contents("accounts.json"));

if (isset($_POST['upload'])) {
	$target_dir = "Files/";
	$target_file = $target_dir . basename($_FILES["upload_file"]["name"]);

	move_uploaded_file($_FILES["upload_file"]["tmp_name"], $target_file);
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
<title>Files page</title>

</head>

<body>
<div align='center'>Files</div>

<br>
Hi, <?php echo $username;?>!
<br>
<br>
<form action="login.php" method="post">
<input type="submit" name="logout" value="Logout">
</form>

<br>
Files:
<br>
<form action="" method="post">
<?php 
$dir = "Files/";
if (isset($_POST['delete'])) {
	foreach($_POST['check_list'] as $key) {
		if ($key !== "delete") {
			$address = $dir . $key;
			if (!unlink($address))
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
<input type="submit" value="Delete" name="delete">
</form>
<hr>
Upload:
<br>
<form action="" method="post" enctype="multipart/form-data">
<input type="file" name="upload_file">
<br>
<input type="submit" name="upload" value="Upload">
</form>

</body>
</html>
