<?php
    include 'connection.php';

    $message = "";
    if (isset($_POST['insert']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
        $firstname = $_POST['fname'];
        $lastname = $_POST['lname'];
        $contact = $_POST['cnum'];
        $username = $_POST['uname'];
        $password = $_POST['pword'];

        if (strlen($contact) != 11) {
            $message =  "Invalid contact number! It must be exactly 11 digits.";
        } else {
            $checkUsername = "SELECT * FROM user WHERE username = '$username'";
            $checkNum = "SELECT * FROM user WHERE contact_number = '$contact'";
            $usernameResult = $conn->query($checkUsername);
            $checkNumResult = $conn->query($checkNum);
    
            if ($usernameResult->num_rows > 0) {
                $message = "Username already exists! Please choose a different username.";
            } else if ($checkNumResult->num_rows > 0) {
                $message = "This contact number is already in use. Please enter a different one.";
            } else {
                $insert_sql = "INSERT INTO user (first_name, last_name, contact_number, username, password) 
                VALUES ('$firstname', '$lastname', '$contact', '$username', '$password')";
    
                if ($conn->query($insert_sql) === TRUE) {
                    header("location: login.php");
                    exit();
                } else {
                    $message = "Error: " . $conn->error;
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }
        h2 {
            color: #333;
        }
        label {
            display: block;
            text-align: left;
            margin: 10px 0 5px;
            font-weight: bold;
            color: #555;
        }
        input {
            width: 90%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 97%;
            padding: 10px;
            background: #000000;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #333;
        }
        p {
            margin-top: 10px;
        }
        a {
            color: #444;
            text-decoration: none;
            font-weight: bold;
        }
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="register.php" method="POST">
            <h2>Registration</h2>
            
            <label for="fname">First Name</label>
            <input type="text" id="fname" name="fname" value="<?= isset($_POST['fname']) ? $_POST['fname'] : '' ?>" required>
    
            <label for="lname">Last Name</label>
            <input type="text" id="lname" name="lname" value="<?= isset($_POST['lname']) ? $_POST['lname'] : '' ?>" required>
    
            <label for="cnum">Contact Number</label>
            <input type="tel" id="cnum" name="cnum" value="<?= isset($_POST['cnum']) ? $_POST['cnum'] : '' ?>" required>
    
            <label for="uname">Username</label>
            <input type="text" id="uname" name="uname" value="<?= isset($_POST['uname']) ? $_POST['uname'] : '' ?>" required>
    
            <label for="pword">Password</label>
            <input type="password" id="pword" name="pword" required>
            
            <button type="submit" name="insert">Register Now</button>
            
            <?php if (!empty($message)): ?>
                <p class="error-message"> <?= $message ?> </p>
            <?php endif; ?>
            
            <p>Already have an account? <a href="login.php">Login</a></p>
        </form>
    </div>
</body>
</html>
