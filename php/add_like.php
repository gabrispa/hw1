<?php
    include 'dbconfig.php';
    session_start();
    $user = $_SESSION['id'];

    //Connessione al DB
    $conn = mysqli_connect($dbconfig["host"], $dbconfig["user"], $dbconfig["password"], $dbconfig["name"]) 
    or die("Errore: ".mysqli_connect_error());

    if(isset($_POST['post_id'])){
        $postID = mysqli_real_escape_string($conn, $_POST['post_id']);
    }else{
        echo json_encode(array('response' => false));   
        exit();
    }
    
    //Query di inserimento
    $insert_query = "INSERT INTO likes (user, post) 
            VALUES ('$user', '$postID')";

    $res = mysqli_query($conn, $insert_query) or die(mysqli_error($conn));
    if($res){
        echo json_encode(array('response' => true));   
    }else{
        echo json_encode(array('response' => false));   
    }

    mysqli_close($conn);
    exit();
?>