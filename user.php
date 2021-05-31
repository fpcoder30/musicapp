<?php

    session_start();

    if (isset($_GET["logout"])) {
        session_destroy();
        header("Location: index.html");
        die(0);
    }

    try{
        $hostname = "localhost";
        $dbname = "my_pacefabio";
        $user = "root";
        $pass = "";
        $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname", $user, $pass);
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    if ($_POST["action"] == "signup") { signup(); }
    if ($_POST["action"] == "login") { login(); }


    function signup() {

        try{
            $hostname = "localhost";
            $dbname = "my_pacefabio";
            $user = "root";
            $pass = "";
            $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname", $user, $pass);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        $username = $_POST["username"];
        $password_input = $_POST["password"];

        $password_hashed = password_hash($password_input, PASSWORD_BCRYPT);

        $query = $pdo->query("INSERT INTO utenti(username, password) VALUES ('$username', '$password_hashed')");

        $_SESSION["username"] = $username;
        header("Location: index.html");

    }

    function login() {

        try{
        $hostname = "localhost";
        $dbname = "my_pacefabio";
        $user = "root";
        $pass = "";
        $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname", $user, $pass);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        $username = $_POST["username"];
        $password_input = $_POST["password"];

        $query = $pdo->query("SELECT password FROM utenti WHERE username='$username'");

        if ($query->rowCount() == 0) {

            http_response_code(401);
            header('Location: login.html');
            die(0);

        }

        $riga = $query->fetch();
        $password_corretta = password_verify($password_input, $riga["password"]);
        if ($password_corretta) {
            $_SESSION["username"] = $username;
            header("Location: index.html");
        }
    }

?>