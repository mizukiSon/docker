<?php
$server_name = getenv("SERVER_NAME") ?: "АПТ";
$current_page = basename($_SERVER["PHP_SELF"]);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? "АПТ" ?> - Ангарский политехнический техникум</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="container">
            <div class="header-top">
                <div class="logo">
                    <h1>🏫 Ангарский политехнический техникум</h1>
                    <p class="subtitle">Качество образования — успех выпускника!</p>
                </div>
                <div class="server-info-header">
                    <small><?= htmlspecialchars($server_name) ?></small>
                    <?php if (isset($_SESSION["username"])): ?>
                        <br><small>👋 <?= htmlspecialchars($_SESSION["username"]) ?> (<?= $_SESSION["user_role"] == "admin" ? "Админ" : "Пользователь" ?>)</small>
                    <?php endif; ?>
                </div>
            </div>
            <nav>
                <ul class="nav-menu">
                    <li class="<?= $current_page == "index.php" ? "active" : "" ?>">
                        <a href="index.php">🏠 Главная</a>
                    </li>
                    <li class="<?= $current_page == "about.php" ? "active" : "" ?>">
                        <a href="about.php">📖 О техникуме</a>
                    </li>
                    <li class="<?= $current_page == "contacts.php" ? "active" : "" ?>">
                        <a href="contacts.php">📞 Контакты</a>
                    </li>
                    <?php if (isset($_SESSION["user_id"])): ?>
                        <li class="<?= $current_page == "students.php" ? "active" : "" ?>">
                            <a href="students.php">👨‍🎓 Студенты</a>
                        </li>
                        <li class="<?= $current_page == "teachers.php" ? "active" : "" ?>">
                            <a href="teachers.php">👨‍🏫 Преподаватели</a>
                        </li>
                        <li>
                            <a href="logout.php">🚪 Выйти</a>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="login.php">🔐 Войти</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main>
