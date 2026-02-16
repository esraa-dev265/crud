<?php
require_once("connection.php");
if(isset($_POST["register"]))
{
	$email = mysqli_real_escape_string($link,$_POST["email"]);
	$password =mysqli_real_escape_string($link,$_POST["password"]);
	 if(empty($email) || empty($password))
	 {
		 echo "<script> alert('please fill all fields'); </script>";
		 
	 }
	else {
		$hash =hash('sha256',$password );
	 $check = mysqli_query($link,"select * from users_login where email ='$email'");
	if (mysqli_num_rows($check)>0)
	{
		echo "<script> alert('email already exist!'); </script>";
		
	}
	else {
		$result = mysqli_query($link,"insert into users_login (email,password) values ('$email','$hash')");
		if($result)
		{
		echo "<script> alert ('registered successfully');</script>";	
			
		}
		else 
		{echo "<script> alert ('registered failed');</script>";}
	}}
	
}
if(isset($_POST["back"]))
{
	header("location:login.php");
	exit;
	
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Register</title>

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

<h2>Register</h2>

<form method="POST">

<input type="email" name="email" placeholder="Email">

<input type="password" name="password" placeholder="Password">
<div class ="btn-group">
<button type="submit" name="back">back</button>
<button type ="submit" name="register" >Register</button>
</div>

</form>

</div>

</body>
</html>


