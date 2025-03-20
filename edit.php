<?php
    include 'connection.php';
    session_start();

    $user_id;

    if (isset($_SESSION['edit_id'])) {
        $user_id = $_SESSION['edit_id'];
    } else {
        $user_id = "No ID received!";
    }

    $data = "SELECT * FROM user WHERE id = $user_id";
    $result = $conn -> query($data);
    $row = "";

    if ($result->num_rows > 0) {
        $row = $result -> fetch_assoc();
    } else {
        echo "No data found";
    }

    $message = "";

    if (isset($_POST['newData']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $id = $_POST['id'];
        $newf = $_POST['fname'];
        $newl = $_POST['lname'];
        $newNum = $_POST['cnum'];
        $newUN = $_POST['uname'];
        $newPW = $_POST['pword'];

        if (strlen($newNum) != 11) {
            $message = "Invalid Contact Number! Contact number must be 11 digits long.";
        } else {
            $checkUsername = "SELECT * FROM user WHERE username = '$newUN' AND id != $id";
            $usernameResult = $conn -> query($checkUsername);

            if ($usernameResult -> num_rows > 0) {
                $message = "This username is in use. Try adding numbers or symbols.";
            } else if ($newPW == $row['password']) {
                $message = "Please enter a new Password.";
            } else {
                $newUps = "UPDATE user 
                            SET first_name = '$newf', 
                                last_name = '$newl', 
                                contact_number = '$newNum', 
                                username = '$newUN', 
                                password = '$newPW' 
                            WHERE id = $id";

                if ($conn -> query($newUps) == TRUE) {
                    header("location: welcome.php");
                    exit();
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
    <link href="https://pro.fontawesome.com/releases/v6.0.0-beta3/css/all.css" rel="stylesheet">
    <title>Edit User</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }
        h4 {
            color: #333;
            margin-bottom: 15px;
        }
        input {
            width: 95%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        button {
            width: 101%;
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
            color: red;
            font-weight: bold;
        }
        .cancel {
            text-align: right;
        }
    </style>
</head>
<body>
    <form method="POST">
        <div class="cancel">
        <a href="welcome.php" title="Cancel">
            <i class="fas fa-times" style="font-size: 24px; color: black;"></i></a>

        </div>
        
        <h4>UPDATE</h4>

        <input type="hidden" name="id" value="<?= $row['id'] ?>">
        <input type="text" name="fname" placeholder="First Name" value="<?= $row['first_name'] ?>" required> <br>
        <input type="text" name="lname" placeholder="Last Name" value="<?= $row['last_name'] ?>" required> <br>
        <input type="number" name="cnum" placeholder="Contact Number" value="<?= $row['contact_number'] ?>" required> <br>
        <input type="text" name="uname" placeholder="Username" value="<?= $row['username'] ?>" required> <br>
        <input type="password" name="pword" placeholder="New Password" required> <br>

        <?php if ($message != ""): ?>
            <p><?= $message ?></p>
        <?php endif; ?>

        <button type="submit" name="newData">Submit</button>
    </form>
</body>
</html>
