<?php

    try{
        $hostname = "localhost";
        $dbname = "my_pacefabio";
        $user = "root";
        $pass = "";
        $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname", $user, $pass);
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (isset($_GET["id_canzone"])) {
            echo get_canzone($_GET["id_canzone"]);
            die(0);
        }
        if (isset($_GET["artista"])) {
            echo get_canzoni_artista($_GET["artista"]);
            die(0);
        }

        /*$query = $pdo->query("SELECT id_canzone, titolo, artista FROM canzoni");
        $output = array();
        while ($riga = $query->fetch()) {
            array_push($output, array(
                "id_canzone" => $riga["id_canzone"],
                "titolo" => $riga["titolo"],
                "artista" => $riga["artista"]
                "internazionale" => $riga["internazionale"]
            ));
        }

        echo json_encode($output);*/
    }

    function get_canzone($id_canzone) {

        try{

            $hostname = "localhost";
            $dbname = "my_pacefabio";
            $user = "root";
            $pass = "";
            $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname", $user, $pass);

        } catch (Exception $e) {        
            echo $e->getMessage();
        }
        
        $query = $pdo->query("SELECT * FROM canzoni WHERE id_canzone = '$id_canzone' LIMIT 1");

        $canzone = $query->fetch();
        return json_encode($canzone);

    }

    function get_canzoni_artista($artista) {

        try{

            $hostname = "localhost";
            $dbname = "my_pacefabio";
            $user = "root";
            $pass = "";
            $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname", $user, $pass);

        } catch (Exception $e) {        
            echo $e->getMessage();
        }
        
        $query = $pdo->query("SELECT * FROM canzoni WHERE artista = '$artista'");

        $canzoni = array();
        while ($riga = $query->fetch()) {
            array_push($canzoni, array(
                "id_canzone" => $riga["id_canzone"],
                "titolo" => $riga["titolo"],
            ));
        }

        return json_encode($canzoni);

    }

?>
