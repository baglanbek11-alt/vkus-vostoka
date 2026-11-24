<?php
// База данных хранится вне каталога htdocs для защиты от прямого скачивания
$dbDir = 'C:/xampp/site-data';
$dbPath = $dbDir . '/vkus_vostoka.sqlite';

try {
    if (!is_dir($dbDir)) {
        mkdir($dbDir, 0777, true);
    }
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Создание таблицы без удаления существующих данных
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS feedback (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT NOT NULL,
            subject TEXT,
            message TEXT NOT NULL,
            created_at TEXT NOT NULL
        )
    ");
} catch (PDOException $e) {
    die('Ошибка подключения к базе данных. Обратитесь к администратору.');
}