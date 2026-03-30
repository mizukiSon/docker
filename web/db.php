<?php
// Подключение к базе данных на Railway
// Используем переменные окружения от Railway

$host = getenv('MYSQLHOST');      // Railway использует MYSQLHOST (без подчеркивания)
$port = getenv('MYSQLPORT');      // MYSQLPORT
$dbname = getenv('MYSQL_DATABASE'); // MYSQL_DATABASE
$user = getenv('MYSQLUSER');      // MYSQLUSER
$password = getenv('MYSQLPASSWORD'); // MYSQLPASSWORD

// Если переменные не найдены, пробуем другие варианты
if (!$host) {
    $host = getenv('MYSQL_HOST');
    $port = getenv('MYSQL_PORT');
    $dbname = getenv('MYSQL_DATABASE');
    $user = getenv('MYSQL_USER');
    $password = getenv('MYSQL_PASSWORD');
}

// Если все еще нет, используем значения по умолчанию из ваших переменных
if (!$host) $host = 'mysql.railway.internal';
if (!$port) $port = '3306';
if (!$dbname) $dbname = 'railway';
if (!$user) $user = 'root';
if (!$password) $password = 'fmFGCZVyhxooKQEivpVgYiLVytEKTmzX';

// Логирование для отладки
error_log("=== Database Connection ===");
error_log("Host: $host:$port");
error_log("Database: $dbname");
error_log("User: $user");

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
    
    error_log("✅ Database connected successfully");
    
} catch (PDOException $e) {
    error_log("❌ Database connection failed: " . $e->getMessage());
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}
?>