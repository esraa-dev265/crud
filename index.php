<?php
session_start();
require_once("connection.php");

if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit;
}

// متغيرات الفورم
$id = "";
$name = "";
$address = "";
$age = "";

/* ================= SAVE ================= */
if(isset($_POST["save"])){

    $name = mysqli_real_escape_string($link,$_POST["name"]);
    $address = mysqli_real_escape_string($link,$_POST["address"]);
    $age = (int)$_POST["age"];

    if(!empty($name) && !empty($address) && !empty($age)){
        mysqli_query($link,"INSERT INTO users(name,address,age)
                            VALUES('$name','$address','$age')");
        header("Location: index.php");
        exit;
    } else {
        echo "<script>alert('Please fill all fields');</script>";
    }
}

/* ================= EDIT FETCH ================= */
if(isset($_GET["edit"])){
    $id = (int)$_GET["edit"];
    $resultEdit = mysqli_query($link,"SELECT * FROM users WHERE id=$id");
    $rowEdit = mysqli_fetch_assoc($resultEdit);

    $name = $rowEdit['name'];
    $address = $rowEdit['address'];
    $age = $rowEdit['age'];
}

/* ================= UPDATE ================= */
if(isset($_POST["update"])){

    $id = (int)$_POST["id"];
    $name = mysqli_real_escape_string($link,$_POST["name"]);
    $address = mysqli_real_escape_string($link,$_POST["address"]);
    $age = (int)$_POST["age"];

    mysqli_query($link,"UPDATE users SET
                        name='$name',
                        address='$address',
                        age='$age'
                        WHERE id=$id");

    header("Location: index.php");
    exit;
}

/* ================= DELETE ================= */
if(isset($_GET["delete"])){
    $id = (int)$_GET["delete"];
    mysqli_query($link,"DELETE FROM users WHERE id=$id");
    header("Location: index.php");
    exit;
}

/* ================= DISPLAY TABLE ================= */
$showTable = false;
if(isset($_POST['configure'])){
    $showTable = true;
    $result = mysqli_query($link,"SELECT * FROM users");
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>CRUD System</title>

<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{
    font-family: Arial, sans-serif;
    background: linear-gradient(to right,#4facfe,#00f2fe);
    min-height:100vh;
}
/* HEADER */
.header{
    width:100%;
    padding:15px 30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    background: linear-gradient(to right,#4facfe,#00c6fb);
    color:white;
    box-shadow:0 3px 10px rgba(0,0,0,0.2);
}
.logout-btn{
    background:white;
    color:#4facfe;
    padding:6px 15px;
    border-radius:20px;
    text-decoration:none;
    font-weight:bold;
}
/* CONTAINER */
.container{
    background:white;
    width:400px;
    margin:40px auto;
    padding:25px;
    border-radius:15px;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
}
h1{text-align:center;margin-bottom:20px;}
label{display:block;margin-top:10px;font-weight:bold;}
input[type=text]{width:100%;padding:10px;margin-top:5px;border:1px solid #ccc;border-radius:8px;}

/* BUTTONS */
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

/* TABLE */
table{
    margin-top:25px;
    width:100%;
    border-collapse:collapse;
}
th{
    background:#4facfe;
    color:white;
    padding:8px;
}
td{
    padding:8px;
    text-align:center;
    border-bottom:1px solid #ddd;
}
.edit-btn{color:green;font-weight:bold;text-decoration:none;margin-right:5px;}
.delete-btn{color:red;font-weight:bold;text-decoration:none;}
@media(max-width:450px){.container{width:90%;}}
</style>
</head>

<body>

<div class="header">
    <div>Welcome, <?php echo $_SESSION['username']; ?></div>
    <a href="logout.php" class="logout-btn">Logout</a>
</div>

<div class="container">

<h1>CRUD System</h1>

<form method="POST">

<input type="hidden" name="id" value="<?php echo $id; ?>">

<label>Name</label>
<input type="text" name="name" value="<?php echo $name; ?>">

<label>Address</label>
<input type="text" name="address" value="<?php echo $address; ?>">

<label>Age</label>
<input type="text" name="age" value="<?php echo $age; ?>">

<div class="btn-group">
    <?php if($id==""){ ?>
        <button type="submit" name="save">Save</button>
    <?php } else { ?>
        <button type="submit" name="update">Update</button>
    <?php } ?>
    <button type="submit" name="configure">Configure</button>
</div>

</form>

<?php if($showTable){ ?>
<table>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Address</th>
    <th>Age</th>
    <th>Action</th>
</tr>
<?php while($row = mysqli_fetch_assoc($result)){ ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['address']; ?></td>
    <td><?php echo $row['age']; ?></td>
    <td>
        <a class="edit-btn" href="index.php?edit=<?php echo $row['id']; ?>">Edit</a>
        |
        <a class="delete-btn" onclick="return confirm('Delete this record?')" href="index.php?delete=<?php echo $row['id']; ?>">Delete</a>
    </td>
</tr>
<?php } ?>
</table>
<?php } ?>

</div>

</body>
</html>
