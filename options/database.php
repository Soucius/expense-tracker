<?php

    $host = "localhost";
    $port = 3306;
    $databaseName = "expense-tracker";
    $databaseUsername = "root";
    $databasePassword = "";
    $username;

    try {
        $connection = new PDO("mysql:host=$host;dbname=$databaseName;charset=utf8mb4;", $databaseUsername, $databasePassword);
    } catch (PDOException $error) {
        echo $error->getMessage();
    }

    if (isset($_SESSION["user"])) {
        $userDetails = $connection->prepare("select * from users where username = ?");
        $userDetails->execute([$_SESSION["user"]]);
        $userDetailsNumber = $userDetails->rowCount();
        $userDetail = $userDetails->fetch(PDO::FETCH_ASSOC);

        if ($userDetailsNumber > 0) {
            $username = $userDetail["username"];
        }
    }