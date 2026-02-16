<?php
session_start();
require_once("connection.php");
if (isset($_POST["login"]))
{
	$email = mysqli_real_escape_string($link,$_POST["email"]);
	$password =mysqli_real_escape_string($link,$_POST["password"]);
	
	if(empty($email)|| empty($password))
	{echo "<script> alert('please fill all fields'); </script>";}
else {
	$hash = hash('sha256' ,$password);
	$result =mysqli_query($link,"select * from users_login where email ='$email' and password ='$hash'");

	if (mysqli_num_rows($result)>0)
	{
		$username = explode('@',$email)[0];
		
		
		echo "<script> alert('welcome ".$username."'); </script>";	
$_SESSION['username'] =$username;		
		header('Location:index.php');
		exit;
	}
	else {
		echo "<script> alert('wrong email or password'); </script>";
		
	}
}
}
if(isset($_POST["register"]))
{
	header("Location: register.php");
	exit;
	
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Login</title>

<style>
body{
    background:linear-gradient(to right,#4facfe,#00f2fe);
    font-family:Arial;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.box{
    background:white;
    padding:30px;
    width:300px;
    border-radius:10px;
    box-shadow:0 0 15px rgba(0,0,0,0.3);
}

h2{text-align:center;}

input{
    width:100%;
    padding:8px;
    margin-top:10px;
}

.btn-group{
    display:flex;
    gap:10px;
    margin-top:15px;
}
.btn-group button{
    flex:1;
    padding:12px;
    border:none;
    border-radius:12px;
    background:linear-gradient(135deg,#4facfe,#00c6fb);
    color:white;
    font-size:16px;
    font-weight:bold;
    cursor:pointer;
    transition:all 0.3s ease;
    box-shadow:0 6px 15px rgba(0,0,0,0.2);
}
.btn-group button:hover{
    transform:translateY(-3px);
    box-shadow:0 10px 20px rgba(0,0,0,0.3);
}
.btn-group button:active{
    transform:scale(0.97);
}
</style>

</head>

<body>

<div class="box">

<h2>LOGIN</h2>

<form method="POST">

<input type="email" name="email" placeholder="Email">

<input type="password" name="password" placeholder="Password">
<a href="pass.php">forget password</a>
<div class ="btn-group">
<button type="submit" name="login">login</button>
<button type ="submit" name="register" >Register</button>
</div>
</form>

</div>

</body>
</html>