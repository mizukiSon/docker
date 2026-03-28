<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'db.php';

function getUserRole() {
    return $_SESSION['user_role'] ?? 'guest';
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

function isUser() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'user';
}

function login($username, $password) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['user_fullname'] = $user['full_name'];
            return true;
        }
        return false;
    } catch (PDOException $e) {
        error_log("Login error: " . $e->getMessage());
        return false;
    }
}

function register($username, $password, $full_name, $email) {
    global $pdo;
    
    try {
        // Проверяем, существует ли пользователь
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            return false;
        }
        
        // Хэшируем пароль
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Добавляем пользователя
        $stmt = $pdo->prepare("INSERT INTO users (username, password, full_name, email, role) VALUES (?, ?, ?, ?, 'user')");
        return $stmt->execute([$username, $hashed_password, $full_name, $email]);
    } catch (PDOException $e) {
        error_log("Register error: " . $e->getMessage());
        return false;
    }
}

function logout() {
    session_destroy();
}
?>
