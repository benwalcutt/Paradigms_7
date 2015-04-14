<?php
session_start();

if(!isset($_SESSION['username'])) {
	$_SESSION['username'];
	$_SESSION['password'];
}

if(isset($_POST['logout'])) {
	$_SESSION['username'] = "";
	$_SESSION['password'] = "";
}

$accounts_array = array();
$accounts_array = json_decode(file_get_contents("accounts.json"));
?>

<html>
<head>
<title>Welcome</title>

</head>

<body>
<div align='center'>Welcome</div>

<br>

Please login to continue:
<form action="main.php" method="post">
Username:
<input type="text" name="username">
Password:
<input type="password" name="password">
<input type="submit" name="submit" value="Login">

</form>

<br>
If you do not already have an account, please create one:
<form action="<?php print($_SERVER['SCRIPT_NAME'])?>" method="post">
Name:
<input type="text" name="name">
Email:
<input type="text" name="email">
Username:
<input type="text" name="username">
Password:
<input type="password" name="password">
Retype password:
<input type="password" name="re_password">
<input type="submit" value="Register" name="register">
</form>

<?php
if (isset($_POST["register"])) {
	$account->name = htmlentities($_POST['name']);
	$account->email = htmlentities($_POST['email']);
	$account->username = htmlentities($_POST['username']);
	$account->password = htmlentities($_POST['password']);
	$re_password = htmlentities($_POST['re_password']);
	
	$accounts_array []= $account;
	
	if ($account->password == $re_password) {
		$fh = fopen("accounts.json", 'w');
		if($fh === false)
			die("Failed to open accounts.json for writing.");
		else
		{
		fwrite($fh, json_encode($accounts_array));
		fclose($fh);
		}
	}
	else {
		echo "Passwords do not match.";
	}
}
?>	
</body>
</html>
