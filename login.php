<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function login($username, $password, $conn) {
    $md5password = md5($password);
    $stmt = $conn->prepare("SELECT `id`, `username` FROM `users` WHERE `username` = ? AND `password` = ?");
    $stmt->bind_param('ss', $username, $md5password);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION["userId"] = $user["id"];
        $_SESSION["username"] = $user["username"];
    } else {
        $_SESSION["userId"] = 0;
        $_SESSION["username"] = "";
    }
}
