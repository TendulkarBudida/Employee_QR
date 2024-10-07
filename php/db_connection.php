<?php

    //connection parameters
    $servername = "127.0.0.1";
    $username_db = "root";
    $password_db = "";
    $dbname = "emp_qr";

    // Connect to the database
    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

?>