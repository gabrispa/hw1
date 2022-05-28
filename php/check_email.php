<?php
    include 'dbconfig.php';

    //Connessione al DB
    $conn = mysqli_connect($dbconfig["host"], $dbconfig["user"], $dbconfig["password"], $dbconfig["name"]) 
    or die("Errore: ".mysqli_connect_error());

    $email = mysqli_real_escape_string($conn, $_GET['q']);
    $query = "SELECT * FROM users WHERE email = '$email'";
    $res = mysqli_query($conn, $query);

    echo json_encode(array('exists' => mysqli_num_rows($res) > 0 ? true : false));
    mysqli_close($conn);
    exit();
?>