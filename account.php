<?php
    include "partials/header.php";
    include "partials/nav.php";
    session_start();

    if (isset($_SESSION["user"])) {
        echo "<h3>{$_SESSION['user']}'in hesabi</h3>";
    } else {
        echo "hata";
    }
?>

<?php include "partials/footer.php"; ?>