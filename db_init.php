<?php
session_start();
require 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear_db'])) {
    clearAndInitDB();
    $_SESSION['message'] = "База данных 'university' успешно создана и инициализирована.";
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>База данных</title>
    <link rel="stylesheet" href="./styles/styles.css">
    <script>
        function showAlert(message) {
            alert(message);
        }
    </script>
</head>
<body>
<header>
    <h1>Подготовьте базу данных к работе</h1>
</header>
<main>
    <article>
        <form method="post" action="">
            <button type="submit" name="clear_db" class="db_button">Очистить и инициализировать базу данных</button>
        </form>
        <?php
        if (isset($_SESSION['message'])) {
            echo "<script>showAlert('" . addslashes($_SESSION['message']) . "');</script>";
            unset($_SESSION['message']);
        }
        ?>
    </article>
</main>
<footer>
    <a href="index.php">Назад на главную</a>
</footer>
</body>
</html>
