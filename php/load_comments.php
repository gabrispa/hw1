<?php
    session_start();
    include 'dbconfig.php';

    if(isset($_POST['post_id'])){
        $postID = $_POST['post_id'];
    }else{
        echo json_encode(array('response' => false));   
        exit();
    }

    if(!isset($_SESSION["username"])){
        header("Location: login.php");
        exit();
    }

    //Connessione al DB
    $conn = mysqli_connect($dbconfig["host"], $dbconfig["user"], $dbconfig["password"], $dbconfig["name"]) 
    or die("Errore: ".mysqli_connect_error());

    $query = "SELECT users.id as userid,
    users.username AS username, 
    users.name AS name, 
    users.surname AS surname, 
    posts.id AS postid,
    comments.id AS commentid,
    comments.text AS commenttext,
    comments.time AS commenttime
    FROM comments JOIN posts on comments.post = '$postID' JOIN users ON comments.user = users.id
	GROUP BY commentid
    ORDER BY commentid DESC";

    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

    if(!$res){
        echo json_encode(array('response' => false));  
        mysqli_close($conn); 
        exit();
    }

    $comments = array();
    while($row = mysqli_fetch_assoc($res)) {
        $comments[] = array('userid' => $row['userid'], 
                            'username' => $row['username'],
                             'name' => $row['name'], 
                             'surname' => $row['surname'], 
                             'postid' => $row['postid'], 
                             'commentid' => $row['commentid'], 
                             'text' => $row['commenttext'],
                             'time' => getTime($row['commenttime']));
    }

    echo json_encode($comments);
    mysqli_close($conn);

    exit();

    function getTime($timestamp) {      
        // Calcola il tempo trascorso dalla pubblicazione del post       
        $old = strtotime($timestamp); 
        $diff = time() - $old;           
        $old = date('d/m/y', $old);

        if ($diff /60 <1) {
            return intval($diff%60)."s"; 
        } else if ($diff / 60 < 60) {
            return intval($diff/60)."m";
        } else if ($diff / 3600 <24) {
            return intval($diff/3600) ."h";
        } else if ($diff/86400 < 30) {
            return intval($diff/86400) ."gg";
        } else {
            return $old; 
        }
    }


?>