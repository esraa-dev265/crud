<?php
session_start();
require_once("connection.php");

$message = ""; // رسالة النجاح أو الخطأ

if (isset($_POST["save"])) {
    $email = mysqli_real_escape_string($link, $_POST["email"]);
    $password = mysqli_real_escape_string($link, $_POST["password"]);
    $confirm = mysqli_real_escape_string($link, $_POST["confirm"]);

    if (empty($email) || empty($password) || empty($confirm)) {
        $message = "Please fill all fields.";
    } elseif ($password !== $confirm) {
        $message = "Passwords do not match.";
    } else {
        // التحقق من وجود البريد
        $check = mysqli_query($link, "SELECT * FROM users_login WHERE email='$email'");
        if (mysqli_num_rows($check) > 0) {
            $hash = hash('sha256',$password);
            $result = mysqli_query($link, "UPDATE users_login SET password='$hash' WHERE email='$email'");
            if ($result) {
                $message = "Password updated successfully. <a href='login.php'>Go to login</a>.";
            } else {
                $message = "Update failed. Try again.";
            }
        } else {
            $message = "Email not found.";
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Reset Password</title>
<style>
body{
    background: linear-gradient(to right,#4facfe,#00f2fe);
    font-family: Arial, sans-serif;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}
.box{
    background:white;
    padding:30px;
    width:350px;
    border-radius:15px;
    box-shadow:0 0 20px rgba(0,0,0,0.3);
}
h2{text-align:center;margin-bottom:20px;}
input[type=email], input[type=password]{
    width:100%;
    padding:10px;
    margin:8px 0;
    border:1px solid #ccc;
    border-radius:8px;
}
.btn-group{
    display:flex;
    gap:10px;
    margin-top:15px;
}
button{
    flex:1;
    padding:12px;
    border:none;
    border-radius:12px;
    background:linear-gradient(135deg,#4facfe,#00c6fb);
    color:white;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}
button:hover{transform:translateY(-2px);}
.show-pass{
    margin-top:5px;
    font-size:14px;
    cursor:pointer;
    color:#007acc;
    background:none;
    border:none;
}
.message{
    margin-top:10px;
    text-align:center;
    color:red;
    font-weight:bold;
}
</style>
</head>
<body>

<div class="box">
<h2>Reset Password</h2>
<form method="POST">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="New Password" id="pass" required>
    <input type="password" name="confirm" placeholder="Confirm Password" id="confirm" required>
    <button type="button" class="show-pass" onclick="togglePassword()">Show/Hide Password</button>
    <div class="btn-group">
        <button type="submit" name="save">Save</button>
		<button type="button" onclick="window.location='login.php';">Back</button>
    </div>
    <?php if($message!=""){ echo "<div class='message'>$message</div>"; } ?>
</form>
</div>

<script>
function togglePassword(){
    let pass = document.getElementById("pass");
    let confirm = document.getElementById("confirm");
    if(pass.type === "password"){
        pass.type = "text";
        confirm.type = "text";
    } else {
        pass.type = "password";
        confirm.type = "password";
    }
}
</script>

</body>
</html>
