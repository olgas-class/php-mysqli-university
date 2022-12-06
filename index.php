<?php
require __DIR__ . "/login.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Parte di connessione al database
define('DB_SERVERNAME', 'localhost:3306');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'classe73_mysqli_db');

$conn = new mysqli(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);

// var_dump($conn);

if ($conn && $conn->connect_error) {
    echo "Errore della connessione";
    exit();
}


// Login
if (isset($_POST["username"]) && isset($_POST["password"])) {
    login($_POST["username"], $_POST["password"], $conn);
}

if (isset($_SESSION["userId"]) && $_SESSION["userId"] !== 0) {
    $sql = "SELECT `name`, `email` FROM `departments`";
    $result = $conn->query($sql);
}

$conn->close();

// var_dump($result);

// if ($result && $result->num_rows > 0) {
//     while ($row = $result->fetch_assoc()) {
//         var_dump($row);
//     }
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <header>
        <nav class="navbar bg-light">
            <div class="container-fluid">
                <a class="navbar-brand">Navbar</a>
                <form action="logout.php" method="POST">
                    <input type="text" value="1" name="logout" hidden>
                    <button type="submit" class="btn btn-danger">logout</button>
                </form>
            </div>
        </nav>
    </header>

    <main>

        <?php if (!isset($_SESSION["userId"]) || $_SESSION["userId"] === 0) { ?>
            <section class="container login mt-5">
                <?php if (isset($_SESSION["userId"]) && $_SESSION["userId"] === 0) { ?>
                    <h4>Username o password sbagliati</h4>
                <?php } ?>
                <div class="row justify-content-center">
                    <div class="col-7">
                        <div class="card border-primary mb-3">
                            <div class="card-header">Fai login</div>
                            <div class="card-body text-primary">
                                <form action="index.php" method="POST">
                                    <label for="username">Username</label>
                                    <input class="form-control" type="text" id="username" name="username">
                                    <label for="password">Password</label>
                                    <input class="form-control" type="password" name="password" id="password">
                                    <button class="btn btn-success mt-4">Login</button>
                                </form>
                            </div>
                        </div>
                    </div>
            </section>
        <?php } else { ?>
            <section class="container">
                <?php if (isset($result) && $result->num_rows > 0) { ?>
                    <h2>La lista dei dipartimenti</h2>
                    <ul class="list-group list-group-flush">
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <li class="list-group-item">
                                <h4><?php echo $row["name"]; ?></h4>
                                <p>email: <?php echo $row["email"]; ?></p>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } else if (isset($result) && $result->num_rows === 0) { ?>
                    <h3>Non ci sono risultati</h3>
                <?php } ?>
            </section>
        <?php } ?>
    </main>

</body>

</html>