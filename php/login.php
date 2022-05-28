<?php
    include 'dbconfig.php';
    session_start();
    
    $errors = array(); //Array per gli errori di validazione
    
    //Se l'utente è loggato reindirizza alla home
    if(isset($_SESSION["username"]))
    {
        header("Location: ../home.php");
        exit();
    }

    //Verifica l'esistenza di dati POST
    if(isset($_POST["username"]) && isset($_POST["password"]))
    {
        //Connessione al DB
        $conn = mysqli_connect($dbconfig["host"], $dbconfig["user"], $dbconfig["password"], $dbconfig["name"]) 
    or die("Errore: ".mysqli_connect_error());

        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        $query = "SELECT username, password, id FROM users WHERE username = '$username'";
        $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
        $row = mysqli_fetch_assoc($res);

        if($row){     
            if (password_verify($password, $row['password'])){
                $_SESSION['username'] = $username;
                $_SESSION['id'] = $row['id'];

                header("Location: ../home.php");
                mysqli_free_result($res);
                mysqli_close($conn);
                exit();
            }else{
                array_push($errors, "Password errata.");
            }
        }else{
            array_push($errors, "Username errato.");
        }    
    }
?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Login</title>
        <link rel="stylesheet" href="../styles/login_style.css">
        <link href="https://fonts.googleapis.com/css2?family=Belleza&family=Bodoni+Moda&family=Cinzel:wght@500&display=swap" 
    rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="../scripts/login.js" defer="true"></script>
    </head>
    <body>
        <main>
            <div id="overlay"></div>
            <div id="login-block">
                <h1>Login</h1>
                <form id="login-form" method="post" name="login-form">
                    <?php if (count($errors) > 0) : ?>
                        <div id="top-error" class="error">
                            <?php foreach ($errors as $error) : ?>
                            <?php echo $error."</br>" ?>
                            <?php endforeach ?>
                        </div>
                    <?php  endif ?>
                    <div class="field">
                        <input id="entry-user" type='text' name='username' placeholder="Username" onblur="checkUsername()">
                        <div id="error-user" class="error hidden">Inserisci uno username.</div>
                    </div>
                    <div class="field">
                        <input id="entry-password" type='password' name='password' placeholder="Password" onblur="checkPassword()">
                        <div id="error-password" class="error hidden">Inserisci una password.</div>
                    </div>
                    
                    <input class="button" id="login-button" type='submit' value="Accedi">
                </form>
                <h4 id="signup">Non hai ancora un account? <a href="signup.php">Registrati.</a> </h4>
            </div>
        </main>
    </body>
</html>