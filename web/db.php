<?php
// Параметры подключения к БД
$host = getenv('DB_HOST') ?: 'db';
$dbname = getenv('DB_NAME') ?: 'teh';
$user = getenv('DB_USER') ?: 'mizuki';
$pass = getenv('DB_PASSWORD') ?: '5283mizuki';

try {
    // DSN с указанием кодировки
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
    ];
    
    $pdo = new PDO($dsn, $user, $pass, $options);
    
    // Принудительно устанавливаем кодировку
    $pdo->exec("SET NAMES utf8mb4");
    $pdo->exec("SET CHARACTER SET utf8mb4");
    $pdo->exec("SET character_set_client = utf8mb4");
    $pdo->exec("SET character_set_connection = utf8mb4");
    $pdo->exec("SET character_set_results = utf8mb4");
    $pdo->exec("SET collation_connection = utf8mb4_unicode_ci");
    
} catch(PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}
?>
