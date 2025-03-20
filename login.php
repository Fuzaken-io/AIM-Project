<?php
    include 'connection.php';

    $select_sql = "SELECT * FROM user";
    $result = $conn -> query ($select_sql);
    $message = "";

    if (isset($_POST['login']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['uname'];
        $password = $_POST['pword'];
    
        $login = "SELECT * FROM user WHERE username = '$username'";
        $result = $conn -> query ($login);
    
        if ($result -> num_rows > 0) {
            $row = $result -> fetch_assoc();
    
            if ($row['password'] == $password) {
                header("Location: welcome.php");
                exit();
            } else {
                $message = "Invalid username or password. Please try again!";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                background-color: #f4f4f4;
                margin: 0;
            }
            .login {
                background: white;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                text-align: center;
                width: 300px;
            }
            h4 {
                margin-bottom: 20px;
            }
            input {
                width: 90%;
                padding: 10px;
                margin: 10px 0;
                border: 1px solid #ccc;
                border-radius: 5px;
            }
            button {
                width: 97%;
                padding: 10px;
                background-color: black;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                margin-top: 10px;
            }
            button:hover {
                background-color: #333;
            }
            p {
                margin-top: 10px;
            }
            .last {
                margin-top: 10px;
                font-size: 14px;
            }
            .last a {
                color: black;
                text-decoration: none;
                font-weight: bold;
            }

        </style>
    </head>
    <body>
        <div class="login">
            <form METHOD='POST'>
                <h4>Login</h4>
                
                <input type="text" name="uname" placeholder="Username" required><br>
                <input type="password" name="pword" placeholder="Password" required><br>

                <?php if ($message != ""): ?>
                    <p style="color: red;"><?= $message ?></p>
                <?php endif; ?>

                <button type="submit" name="login">Log in</button>
                
                <p class="last">Don't have an account? <a href="register.php">Sign up</a></p>
            </form> 
        </div>
    </body>
</html>
