<?php

    $db_server = "localhost";
    $db_user = "root";
    $db_password = "";
    $db_name = "user_database";
    $conn = "";

        $conn = mysqli_connect(
            $db_server,
            $db_user,
            $db_password,        
            $db_name
        );

        try {   
            $conn = mysqli_connect(
                $db_server,
                $db_user,
                $db_password,        
                $db_name
            );
        }
        catch (mysqli_sql_exception) {
            echo "Failed to connect to database "; 
        }   
        if ($conn) {
            // echo "Connected to database:";
        } else {
            echo "Failed to connect to database:";
        }
?>