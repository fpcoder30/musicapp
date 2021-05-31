<?php

    //SET DB
    try{
        $hostname = "localhost";
        $dbname = "my_pacefabio";
        $user = "root";
        $pass = "";
        $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname", $user, $pass);
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET") { //RITORNO RICHIESTE ATTUALI per il suonatore

        $id_suonatore = $_GET["id_suonatore"];
        $result = $pdo->query("SELECT * FROM richieste WHERE id_suonatore = $id_suonatore");
        
        $richieste_attuali = array();

        while ($riga = $result->fetch()) { //scorro ogni richiesta

            $parametri_canzone = new stdClass();

            $id_canzone = $riga["id_canzone"]; //id canzone da cercare nel db canzoni

            $canzone = $pdo->query("SELECT titolo, artista FROM canzoni WHERE id_canzone = $id_canzone");
            
            $riga_unica = $canzone->fetch();

            $parametri_canzone -> id_canzone = $id_canzone;
            $parametri_canzone -> titolo = $riga_unica["titolo"];
            $parametri_canzone -> artista = $riga_unica["artista"];

            array_push($richieste_attuali, $parametri_canzone);

        }

        //ritorno array di oggetti ricieste, con i vari parametri
        echo json_encode($richieste_attuali);
        
    } else if ($_SERVER["REQUEST_METHOD"] == "POST") { //AGGIUNGO UNA RICHIESTA

        $id_suonatore = $_POST["suonatore"]; //id suonatore a cui richiedere
        $id_canzone = $_POST["id_canzone"]; //id canzone richiesta

        $query = $pdo->query("INSERT INTO richieste(id_suonatore, id_canzone) VALUES ('$id_suonatore', '$id_canzone')");
        //$success = $query->execute([$_POST["artista"], $_POST["titolo"]]);

        if($success) {
            http_response_code(200);
        } else {
            echo var_dump($success);
            http_response_code(400);
        }

    } else if ($_SERVER["REQUEST_METHOD"] == "DELETE") { //ELIMINO UNA RICHIESTA

        session_start();

        if (!isset($_SESSION["username"])) {
            http_response_code(401);
            die(0);
        }

        if (!isset($_GET["id_canzone"])) {
            http_response_code(400);
            die(0);
        }

        $username = $_SESSION["username"];
        $id_suonatore = $_GET["id_suonatore"];
        $id_canzone = $_GET['id_canzone'];

        $query = $pdo->query("DELETE richieste FROM richieste JOIN utenti ON utenti.id_utente = richieste.id_suonatore WHERE utenti.username = '$username' AND richieste.id_canzone = '$id_canzone'");

        echo json_encode($query);
    }

?>