<?php
    //Avvia la sessione
    session_start();

    //Verifica se l'utente è loggato
    if(!isset($_SESSION["username"])){
        header("Location: php/login.php");
        exit();
    }

?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Home</title>
        <link rel="stylesheet" href="styles/home.css">
        <link rel="stylesheet" href="styles/modal-view.css">
        <link href="https://fonts.googleapis.com/css2?family=Belleza&family=Bodoni+Moda&family=Cinzel:wght@500&display=swap" 
    rel="stylesheet">
        <script  src="scripts/handle_likes.js" defer="true"></script>
        <script  src="scripts/handle_comments.js" defer="true"></script>
        <script  src="scripts/load_posts.js" defer="true"></script>
        
       
        <meta name="viewport"
    content="width=device-width, initial-scale=1">
    </head>

    <body>
    <header>
        <div id="overlay"></div>
         
        <div id="logo">
            Social Art Gallery
        </div>
        <nav>         
          <div id="links">
            <a id="home-button" class="current-page" href="home.php">Home</a>
            <a id="my-profile-button" href="my_profile.php">Profile</a>
            <a id="search-button" href="search_user.php">Search</a>
            <a  href="php/add_post.php" id="new-post-button">New Post</a>
            <a id="logout-button" href="php/logout.php">Logout</a>
          </div>
          
        </nav>     
    </header>
    <section id="scroll-view">
        <div id="posts_container">
        
        </div>
    </section>

    <section id="modal-view" class="hidden"> 
      <div id="post-modal">
        <div id="post-image">

        </div>
        <div id="comment-block">
          <div id="comments">
              
          </div>
          <div id="comment-input">
            <form>
              <textarea id="comment-entry" placeholder="Inserisci un commento..." rows="4" cols="32" maxlentgh="255"></textarea>
              <input class="button" id="post-comment" type='submit' value="Invia">
            </form>
          </div>
        </div>
      </div>
    </section>
    <a href="php/add_post.php"><button id="add-post" >+</button></a>
    <footer>
        <address>Gabriele Spagnuolo (1000002217)</address>
        <p>Web Programming Course <br/> 2022</p>
    </footer>
    </body>
</html>