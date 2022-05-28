<?php
    include 'dbconfig.php';
    session_start();

    //Array per gli errori di validazione
    $errors = array();

    //Connessione al DB
    $conn = mysqli_connect($dbconfig["host"], $dbconfig["user"], $dbconfig["password"], $dbconfig["name"]) 
    or die("Errore: ".mysqli_connect_error());

    //Controllo che esistano i campi del form
    if(!empty($_POST["name"]) && !empty($_POST["surname"]) && !empty($_POST["username"]) && !empty($_POST["email"]) &&
        !empty($_POST["password"]) && !empty($_POST["conf-password"]) && isset($_FILES['propic']['name']))
    {
        //Salvo i campi del form
        $name = mysqli_real_escape_string($conn, $_POST["name"]);
        $surname = mysqli_real_escape_string($conn, $_POST["surname"]);
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $password = mysqli_real_escape_string($conn, $_POST["password"]);
        $conf_password = mysqli_real_escape_string($conn, $_POST["conf-password"]);
        $image = $_FILES["propic"]["tmp_name"];
        $imgContent = addslashes(file_get_contents($image));

        //Controlla unicità Username e Email
        $check_username_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email' ";
        $res = mysqli_query($conn, $check_username_query) or die(mysqli_error($conn));;
        $row = mysqli_fetch_assoc($res);

        if($row){
            if ($row['username'] === $username) {
                $errors['username'] = 'Username già in uso con un altro account.';
            }
        
            if ($row['email'] === $email) {
                $errors['email'] = 'E-mail già in uso con un altro account.';
            }
        }

        if(count($errors) == 0)
        {
            //Password Criptata
            $password_criptata = password_hash($password, PASSWORD_BCRYPT);

            $insert_query = "INSERT INTO users (username, name, surname, email, password, photo) 
            VALUES ('$username', '$name', '$surname', '$email', '$password_criptata', '$imgContent')";

            if(mysqli_query($conn, $insert_query)){
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['id'] =  mysqli_insert_id($conn);
                mysqli_close($conn);
                mysqli_free_result($res);
                header("Location: ../home.php");
            } else{
                array_push($errors, "Errore nella richiesta al database del server.");
            }
        }

    }
?>



<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Signup</title>
        <link rel="stylesheet" href="../styles/login_style.css">
        <link href="https://fonts.googleapis.com/css2?family=Belleza&family=Bodoni+Moda&family=Cinzel:wght@500&display=swap" 
    rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="../scripts/signup.js" defer="true"></script>
    </head>
    <body>
        <main>
            <div id="overlay"></div>
            <div id="signup-block">
                <h1>Signup</h1>
                <form id="signup-form" method="post" name="signup-form"  enctype="multipart/form-data">
                    <?php if (count($errors) > 0) : ?>
                        <div id="top-error" class="error">
                            <?php foreach ($errors as $error){
                             echo $error."</br>" ;
                            }?>
                        </div>
                    <?php  endif ?>    


                    <div class="field">
                        <input id="entry-name" type='text' name='name' placeholder="Nome" onblur="checkName()">
                        <div id="error-name" class="error hidden">Inserisci il tuo nome.</div>
                    </div>
                    <div class="field">
                        <input id="entry-surname" type='text' name='surname' placeholder="Cognome" onblur="checkSurname()">
                        <div id="error-surname" class="error hidden">Inserisci il tuo cognome.</div>
                    </div>
                    <div class="field">
                        <input id="entry-username" type='text' name='username' placeholder="Username" onblur="checkUsername()">
                        <div id="error-username" class="error hidden" >NULL.</div>
                    </div>
                    <div class="field">
                        <input id="entry-email" type='text' name='email' placeholder="E-mail" onblur="checkEmail()">
                        <div id="error-email" class="error hidden">NULL</div>
                    </div>
                    <div class="field">  
                        <input id="entry-password" type='password' name='password' placeholder="Password" onblur="checkPassword()">
                        <div id="error-password" class="error hidden">Password non valida. Minimo 8 caratteri, tra cui una lettera maiuscola, 
                            una minuscola e un numero.</div>
                    </div>    
                    <div class="field">
                        <input id="entry-confpassword" type='password' name='conf-password' placeholder="Conferma Password" onblur="checkConfPassword()">
                        <div id="error-confpassword" class="error hidden">Le due password non coincidono.</div>
                    </div>
                    <div class="field">
                        <label for="entry-propic" class="custom-file-upload" ><input id="entry-propic" type='file' name='propic'onchange="checkPropic()">
                        Scegli una foto profilo</label>    
                        <div id="error-propic" class="error hidden">Inserisci una foto profilo.</div>
                    </div>
                    <p id="file-name" class="field"></p>
                  
                    <input class="button" id="signup-button" type='submit' value="Registrati">
                    
                </form>
                
            </div>
        </main>
    </body>
</html>