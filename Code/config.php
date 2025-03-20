<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "db_sim_bgdeva";

    $conn = new mysqli($host, $user, $pass, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>