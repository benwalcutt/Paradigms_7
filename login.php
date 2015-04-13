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
<title>Ben-Box</title>

</head>

<body>
<div align='center'><h1>Welcome to Ben-Box</div>

<br>
<?php
if (isset($_POST['register'])) {
	echo "<h6>Account created successfully.";
}
?>
<h3>Please login to continue:
<form action="main.php" method="post">
<table style="width:25%">
<tr>
	<td>
	<h4>Username:
	</td>
	<td>
	<input type="text" name="username">
	</td>
</tr>
<tr>
	<td>
	<h4>Password:
	</td>
	<td>
	<input type="password" name="password">
	</td>
</tr>
<tr>
	<td>
	<input type="submit" name="submit" value="Login">
	</td>
</tr>
</table>

</form>

<br>
<hr>
<br>
<h3>If you do not already have an account, please create one:
<form action="<?php print($_SERVER['SCRIPT_NAME'])?>" method="post">
<table style="width:25%">
<tr>
	<td>
	<h4>Name:
	</td>
	<td>
	<input type="text" name="name">
	</td>
</tr>
<tr>
	<td>
	<h4>Email:
	</td>
	<td>
	<input type="text" name="email">
	</td>
</tr>
<tr>
	<td>
	<h4>Username:
	</td>
	<td>
	<input type="text" name="username">
	</td>
</tr>
<tr>
	<td>
	<h4>Password:
	</td>
	<td>
	<input type="password" name="password">
	</td>
</tr>
<tr>
	<td>
	<h4>Retype password:
	</td>
	<td>
	<input type="password" name="re_password">
	</td>
</tr>
<tr>
	<td>
	<input type="submit" value="Register" name="register">
	</td>
</tr>
</table>

<?php
if (isset($_POST["register"])) {
	$acct->name = htmlentities($_POST['name']);
	$acct->email = htmlentities($_POST['email']);
	$acct->username = htmlentities($_POST['username']);
	$acct->password = htmlentities($_POST['password']);
	$re_password = htmlentities($_POST['re_password']);
	
	$accounts_array []= $acct;
	
	if ($acct->password == $re_password) {
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
		echo "<h5>Passwords do not match.";
	}
}
?>	
</body>
</html>
