<?php

    session_start();

    include "options/database.php"; 

    include "partials/header.php";

    include "partials/nav.php";

    // isset($_REQUEST['page']) ? $pageCode = $_REQUEST['page'] : $pageCode = '';

    // if ($pageCode == 0 or $pageCode == "") {
    //     include "main.php";
    // } else {
    //     include $page[$pageCode];
    // }

    include "partials/footer.php";