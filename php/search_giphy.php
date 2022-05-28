<?php
    $apikey = 'Dx1NrFXUNyMIrckSH9NDBI00QRniPiRB';
    
    $query = urlencode($_POST["q"]);
    $url = "http://api.giphy.com/v1/gifs/search?q=".$query."&api_key=".$apikey."&limit=5";
    
   //CURL Handler
    $ch = curl_init($url);
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
    $data = curl_exec($ch); //Richiesta eseguita
    
    
    $json = json_decode($data, true);
    
    curl_close($ch);

    $newJson = array();
    //Restituisco nel nuovo json solo i campi che mi interessano
    for ($i = 0; $i < count($json['data']); $i++) {
        $newJson[] = array('id' => $json['data'][$i]['id'], 'preview' => $json['data'][$i]['images']['downsized_medium']['url']);
    }

    echo json_encode($newJson, JSON_UNESCAPED_SLASHES);

?>