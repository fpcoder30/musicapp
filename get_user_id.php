<?php

    session_start();

    try{
        $hostname = "localhost";
        $dbname = "my_pacefabio";
        $user = "root";
        $pass = "";
        $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname", $user, $pass);
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    if (!isset($_SESSION["username"])) {
        http_response_code(401);
        die(0);
    }

    $username = $_SESSION["username"];
    $query = $pdo->query("SELECT id_utente FROM utenti WHERE username='$username'");
    if ($query->rowCount() == 0) {
        http_response_code(401);
        die(0);
    }

    echo json_encode($query->fetch()["id_utente"]);

?>