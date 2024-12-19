<?php
    if(isset($_POST["login"])) {
        if($_POST["username"] == "admin" && $_POST["password"] == "123") {
            header("Location: admin.php");
            exit;
        } elseif ($_POST["username"] == "user" && $_POST["password"] == "456") {
            header("Location: user.php");
        } 
        else {
            echo "Username tidak ditemukan!";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Risiko Mitigasi</title>
    <style>
        h1{
            text-align: center;
            background-color: aquamarine;
            border: 50px;
            color: black;
        }
        a {
            background-color: antiquewhite;
            color: black;
        }
    </style>
</head>
<body>
    <h1>Aplikasi Manajemen Risiko</h1>
    <form action="" method="post">
        <ul>
            <li>
                <label for="username">Username: </label>
                <input type="text" name="username" id="username">
            </li>
            <li>
                <label for="password">Password: </label>
                <input type="password" name="password" id="password">
            </li>
            <li>
                <button type="submit" name="login">login</button>
            </li>
            
        </ul>
    </form>
    
</body>
</html>
