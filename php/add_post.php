<?php
    session_start();
    include 'dbconfig.php';
    
    $conn = mysqli_connect($dbconfig["host"], $dbconfig["user"], $dbconfig["password"], $dbconfig["name"]) 
    or die("Errore: ".mysqli_connect_error());

    $userid = $_SESSION['id'];

    if(isset($_POST['text-entry']) && ($_FILES['upload-image']['name'] != null)){
        
        
        $text =  mysqli_real_escape_string($conn, $_POST['text-entry']);
        $image = $_FILES["upload-image"]["tmp_name"];

        $imgContent =addslashes(file_get_contents($image));

        $insert_query = "INSERT INTO posts(user, text, photo, type) VALUES('$userid', '$text', '$imgContent', 0);";
        $res = mysqli_query($conn, $insert_query) or die(mysqli_error($conn));
        header("Location: ../home.php");
    }

    if(isset($_POST['text-entry']) && ($_POST['id-gif'] != null)){
        $text =  mysqli_real_escape_string($conn, $_POST['text-entry']);
        $gif = $_POST['id-gif'];


        $insert_query = "INSERT INTO posts(user, text, gif_link, type) VALUES('$userid', '$text', '$gif', 1);";
        $res = mysqli_query($conn, $insert_query) or die(mysqli_error($conn));
        header("Location: ../home.php");
    }

    mysqli_close($conn);

?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>New Post</title>
        <link rel="stylesheet" href="../styles/create_post_style.css"> 
        <link href="https://fonts.googleapis.com/css2?family=Belleza&family=Bodoni+Moda&family=Cinzel:wght@500&display=swap" 
    rel="stylesheet">
        <script  src="../scripts/create_post.js" defer="true"></script>
        <meta name="viewport"
    content="width=device-width, initial-scale=1">
    </head>
    <body>
        <a href="../home.php"> <img id="back" src="../images/back-arrow.png" /> </a>
        <h1>Crea un nuovo post</h1>
        <div id="create-post-block">
           
                <form method="POST" action="" enctype="multipart/form-data" name="upload-form" id="upload-form">
                    <div id="add-photo">
                        <div id="radio-buttons">
                            <input type="radio" id="upload-choice" name="choice" >
                            <label for="upload-choice">Carica immagine</label>
                            <input type="radio" id="search-choice" name="choice" >
                            <label for="search-choice">Cerca GIF</label>
                        </div>
                        <input  class="hidden" id="upload-image" type="file" name="upload-image"  accept=".png, .jpg, .jpeg"> 
                        <div id="search-gif" class="hidden">
                            <input id="search-gif-entry" type="text" name="search-gif-entry">
                            <input class="button" id="search-gif-button" type="submit" value="Cerca">
                            <input type="hidden" name="id-gif" id="id-gif">
                        </div>
                    </div>
                    <div id="add-text">
                        <textarea form="upload-form" id="text-entry" name="text-entry" placeholder="Inserisci il testo del tuo post..." 
                                rows="23" cols="32" maxlentgh="512"></textarea>
                        <input class="button" id="send-post" type="submit" value="Invia"> 
                    </div>             
                </form>
        </div>
    </body>

</html>