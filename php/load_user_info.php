<?php
    session_start();
    include 'dbconfig.php';

    

    if(!isset($_SESSION["username"])){
        header("Location: login.php");
        exit();
    }

    if(isset($_POST['username'])){
        $userToFind = $_POST['username'];
    }else{
        $userToFind =  $_SESSION['username'];
    }


    //Connessione al DB
    $conn = mysqli_connect($dbconfig["host"], $dbconfig["user"], $dbconfig["password"], $dbconfig["name"]) 
    or die("Errore: ".mysqli_connect_error());

    $query = "SELECT * FROM users WHERE username LIKE CONCAT ( '$userToFind', '%' ) ;";

    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

    if(mysqli_num_rows($res) == 0){
        echo json_encode(array('response' => false));  
        mysqli_close($conn); 
        exit();
    }

    $row = mysqli_fetch_assoc($res);
    $user[] = array('userid' => $row['id'], 
                    'username' => $row['username'],
                    'name' => $row['name'], 
                    'surname' => $row['surname'], 
                    'email' => $row['email'], 
                             'password' => $row['password'], 
                             'photo' => base64_encode($row['photo']),
                             'nposts' =>$row['nposts'],
                             'nlikes' => $row['nlikes'],
                             'ncomments' =>$row['ncomments'],
                            'response' => true);
    

    echo json_encode($user);
    mysqli_close($conn);

    exit();

?>