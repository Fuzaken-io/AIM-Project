<?php
    include 'connection.php';
    $select_sql = "SELECT * FROM user";
    $result = $conn -> query ($select_sql);

    session_start();

    if (isset($_POST['newData']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
        $_SESSION['edit_id'] = $_POST['edit_id'];
        header("location: edit.php");
        exit();
    }

    if (isset($_POST['delete']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];
        $delete_sql = "DELETE FROM user WHERE id = $id";
        $conn -> query($delete_sql);
        header("location: welcome.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Employees</title>
    <link href="https://pro.fontawesome.com/releases/v6.0.0-beta3/css/all.css" rel="stylesheet"> 
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h3 {
            background-color: #34495e;
            color: white;
            padding: 15px;
            border-radius: 5px;
            text-align: left;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #34495e;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .btn {
            border: none;
            padding: 5px;
            border-radius: 5px;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .a{
            text-align: right;
        }
        .logout, .add-employee {

            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        .logout {
            background-color: #e74c3c;
        }

        .logout:hover {
            background-color: #c0392b;
        }

        .add-employee {
            background-color: #27ae60;
        }

        .add-employee:hover {
            background-color: #219150;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .button-group {
            display: flex;
            gap: 10px;
            align-items: center;
        }

    </style>
</head>
<body>

    <div class="container">
    <h3 class="header">
        <span>Manage User</span>
        <div class="button-group">
            <a href="register.php" class="add-employee">Add New Employee</a>
            <a href="login.php" class="logout">Logout</a>
        </div>
    </h3>
        <table>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Contact Number</th>
                <th>Username</th>
                <th>Password</th>
                <th>Actions</th>
            </tr>

            <?php

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "
            <tr>
                <td>{$row['id']}</td>
                <td>{$row['first_name']}</td>
                <td>{$row['last_name']}</td>
                <td>{$row['contact_number']}</td>
                <td>{$row['username']}</td>
                <td>{$row['password']}</td>
                <td class='actions'>
                    <form method='POST' style='display: inline;'>
                        <input type='hidden' name='id' value='{$row['id']}'>
                        <button class='btn delete' type='submit' onclick='return confirm(\"Are you sure?\")'name='delete'>
                            <i class='fas fa-trash-alt'></i>
                        </button>
                    </form>
                    <form method='POST' style='display: inline;'>
                        <input type='hidden' name='edit_id' value='{$row['id']}'>
                        <button class='btn edit' type='submit' name='newData'>
                            <i class='fas fa-edit'></i>
                        </button>
                    </form>
                </td>
            </tr>";
    }
}

?>

</body>
</html>
