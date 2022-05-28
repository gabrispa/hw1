<?php
    include 'dbconfig.php';
    session_start();
    $user_id = $_SESSION['id'];

    //Connessione al DB
    $conn = mysqli_connect($dbconfig["host"], $dbconfig["user"], $dbconfig["password"], $dbconfig["name"]) 
    or die("Errore: ".mysqli_connect_error());

    //Controllo che esistano i campi del form
    if(!empty($_POST["post_id"]) && !empty($_POST["text"]))
    {
        //Salvo i campi del form
        $post_id = mysqli_real_escape_string($conn, $_POST["post_id"]);
        $comment_text = mysqli_real_escape_string($conn, $_POST["text"]);

        //Query di inserimento
        $insert_query = "INSERT INTO comments (user, post, text) 
            VALUES ('$user_id', '$post_id', '$comment_text')";

        $res = mysqli_query($conn, $insert_query) or die(mysqli_error($conn));

        if($res){
            echo json_encode(array('response' => true));   
        }else{
            echo json_encode(array('response' => false));   
        }

        mysqli_close($conn);
        exit();
    }


?>