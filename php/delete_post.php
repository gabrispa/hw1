<?php
    session_start();
    include 'dbconfig.php';
    
    $conn = mysqli_connect($dbconfig["host"], $dbconfig["user"], $dbconfig["password"], $dbconfig["name"]) 
    or die("Errore: ".mysqli_connect_error());

    if(isset($_POST['post-id'])){
        $postId = mysqli_real_escape_string($conn, $_POST['post-id']);
    }else{
        echo json_encode(array('response' => false));   
        exit();
    }

    
    
    $delete_query = "DELETE FROM posts WHERE id = '$postId'";
    $res = mysqli_query($conn, $delete_query) or die(mysqli_error($conn));
    

    if($res){
        echo json_encode(array('response' => 'delete success'));   
    }else{
        echo json_encode(array('response' => 'delete error'));   
    }  


    mysqli_close($conn);

    exit();

?>