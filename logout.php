<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (isset($_POST["logout"]) && $_POST["logout"] === "1") {
    session_destroy();
    session_unset();
    header("Location: index.php");
}
