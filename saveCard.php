<?php

    include "options/database.php";

    $column = strip_tags(trim($_POST["column"]));
    $value = strip_tags(trim($_POST["value"]));
    $id = strip_tags(trim($_POST["id"]));

    if (!$column || !$value || !$id) {
        echo "<div class='container bg-warning'>empty</div>";
    } else {
        $update = $connection->prepare("update cards set {$column} =:u where id=:id");
        $update->execute([
            ":u" => $value,
            ":id" => $id
        ]);
    }