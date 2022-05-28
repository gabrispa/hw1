<?php
    //Avvia la sessione
    session_start();

    //Verifica se l'utente è loggato
    if(!isset($_SESSION["username"])){
        header("Location: login.php");
        exit();
    }

?>


<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Search</title>
        
        <link rel="stylesheet" href="styles/my_profile.css">
        <link rel="stylesheet" href="styles/search.css">
        <link rel="stylesheet" href="styles/modal-view.css">
        <link href="https://fonts.googleapis.com/css2?family=Belleza&family=Bodoni+Moda&family=Cinzel:wght@500&display=swap" 
    rel="stylesheet">
        <script src="scripts/search_user.js" defer="true"></script>
        <script  src="scripts/handle_likes.js" defer="true"></script>
        <script  src="scripts/handle_comments.js" defer="true"></script>
        <script  src="scripts/load_posts.js" defer="true"></script>
        <script src="scripts/load_user_info.js" defer="true"></script>
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>

    <body>
    <header>
        <div id="overlay"></div>
         
        <div id="logo">
            Social Art Gallery
        </div>
        <nav>         
          <div id="links">
            <a id="home-button" href="home.php">Home</a>
            <a id="my-profile-button"  href="my_profile.php">Profile</a>
            <a id="search-button" href="search_user.php" class="current-page">Search</a>
            <a  href="php/add_post.php" id="new-post-button">New Post</a>
            <a id="logout-button" href="php/logout.php">Logout</a>
          </div>
         
        </nav>     
    </header>

    <section id="search-user-section">
      <h2>Cerca il profilo di un utente</h2>
      <form id="search-user-form">
        <input type="text" id="user-to-find">
        <input type="submit" id="search" value="Cerca">
      </form>
      <h2 id="user-not-found" class="hidden">Nessun utente trovato con questo username.</h2>
    </section>

    <div class="hidden" id="profile-info">
          <img id="profile-photo" />
          <div id="info-container">
            <div id="name-surname-username">
              <h2 id="name-surname"></h2>
              <h2 id="username"></h2>
            </div>
            <div class="stats">
                <div>
                  <h4 class="stats-num">Posts</h4>
                  <h4  id="nposts" class="stats-num"></h4>
                </div>
                <div>
                  <h4 class="stats-num">Likes</h4>
                  <h4 id="nlikes" class="stats-num"></h4>
                </div>
                <div>
                  <h4 class="stats-num">Comments</h4>
                  <h4 id="ncomments" class="stats-num"></h4>
                </div>    
            </div>
          </div>
    </div>

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