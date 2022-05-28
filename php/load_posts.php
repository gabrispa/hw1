<?php
    session_start();
    include 'dbconfig.php';

    

    if(!isset($_SESSION["username"])){
        header("Location: login.php");
        exit;
    }

    if(isset($_POST['type'])){
        $type = $_POST['type'];
    }else{
        echo json_encode(array('response' => "type not set"));   
        exit();
    }

    $conn = mysqli_connect($dbconfig["host"], $dbconfig["user"], $dbconfig["password"], $dbconfig["name"]) 
    or die("Errore: ".mysqli_connect_error());

    $userid = $_SESSION['id'];

    if($type == 'home'){
        $query = "SELECT users.id AS userid, 
        users.username AS username, 
        users.name AS name, 
        users.surname AS surname, 
        users.photo AS userphoto,
        posts.id AS postid, 
        posts.text AS posttext,
        posts.type AS posttype,
        posts.photo AS postphoto,
        posts.gif_link AS postgif,
        posts.time AS time,
        EXISTS(SELECT user FROM likes WHERE post = posts.id AND user = '$userid') AS liked, 
        posts.nlikes AS nlikes, 
        posts.ncomments AS ncomments
        FROM posts JOIN users ON posts.user = users.id  ORDER BY postid DESC";
    }elseif ($type == 'my-profile') {
        $query = "SELECT users.id AS userid, 
        users.username AS username, 
        users.name AS name, 
        users.surname AS surname, 
        users.photo AS userphoto,
        posts.id AS postid, 
        posts.text AS posttext,
        posts.type AS posttype,
        posts.photo AS postphoto,
        posts.gif_link AS postgif,
        posts.time AS time,
        EXISTS(SELECT user FROM likes WHERE post = posts.id AND user = '$userid') AS liked, 
        posts.nlikes AS nlikes, 
        posts.ncomments AS ncomments
        FROM posts JOIN users ON posts.user = users.id 
        WHERE users.id ='$userid' ORDER BY postid DESC";
    }elseif ($type == 'search-user') {
        $usernameSearched = $_POST['searched'];
        $idSearched = $_POST['searched-id'];
        $query = "SELECT users.id AS userid, 
        users.username AS username, 
        users.name AS name, 
        users.surname AS surname, 
        users.photo AS userphoto,
        posts.id AS postid, 
        posts.text AS posttext,
        posts.type AS posttype,
        posts.photo AS postphoto,
        posts.gif_link AS postgif,
        posts.time AS time,
        EXISTS(SELECT user FROM likes WHERE post = posts.id AND user = '$userid') AS liked, 
        posts.nlikes AS nlikes, 
        posts.ncomments AS ncomments
        FROM posts JOIN users ON posts.user = users.id 
        WHERE users.username LIKE CONCAT ( '$usernameSearched', '%' ) 
            AND users.id = '$idSearched' 
            ORDER BY postid DESC";
    }


    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

    $posts = array();
    while($row = mysqli_fetch_assoc($res)) {
        $posts[] = array('userid' => $row['userid'], 
                            'username' => $row['username'],
                             'name' => $row['name'], 
                             'surname' => $row['surname'],
                             'userphoto' => base64_encode($row['userphoto']),
                             'postid' => $row['postid'], 
                             'posttext' => $row['posttext'], 
                             'postphoto' => base64_encode($row['postphoto']),
                             'postgif'=> $row['postgif'],
                             'posttype'=>$row['posttype'],
                             'time' => getTime($row['time']),
                             'liked' => $row['liked'],
                             'nlikes' => $row['nlikes'], 
                             'ncomments' => $row['ncomments']);
    }

    echo json_encode($posts);

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