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
        if (isset($_GET["internazionale"])) {
            echo get_artisti_int($_GET["internazionale"]);
            die(0);
        }

        $query = $pdo->query("SELECT DISTINCT artista FROM canzoni");
        $artisti = array();
        while ($riga = $query->fetch()) {
            array_push($artisti, array(
                "nome" => $riga["artista"],
            ));
        }

        echo json_encode($artisti);
    }

    function get_artisti_int($internazionale){

        try{
            $hostname = "localhost";
            $dbname = "my_pacefabio";
            $user = "root";
            $pass = "";
            $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname", $user, $pass);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        $query = $pdo->query("SELECT DISTINCT artista FROM canzoni WHERE internazionale = $internazionale");
        $artisti = array();
        while ($riga = $query->fetch()) {
            array_push($artisti, array(
                "nome" => $riga["artista"],
            ));
        }

        echo json_encode($artisti);

    }


?>
