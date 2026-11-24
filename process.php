<?php
header('Content-Type: text/html; charset=UTF-8');
require_once 'db.php';

// Защита при прямом GET-запросе без отправки формы
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo '<!DOCTYPE html><html lang="ru"><head><meta charset="UTF-8"><link rel="stylesheet" href="style.css"><title>Ошибка доступа</title></head><body>';
    echo '<div class="container"><div class="alert-err">Эта страница предназначена только для обработки данных формы.</div>';
    echo '<a href="contacts.html">← Вернуться к форме обратной связи</a></div></body></html>';
    exit;
}

// Получение и очистка входных данных
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

$errors = [];
if ($name === '') {
    $errors[] = 'Поле «Ваше имя» обязательно для заполнения.';
}
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Укажите корректный адрес электронной почты.';
}
if ($message === '') {
    $errors[] = 'Поле «Текст сообщения» не может быть пустым.';
}

// Вывод ошибок валидации
if (!empty($errors)) {
    echo '<!DOCTYPE html><html lang="ru"><head><meta charset="UTF-8"><link rel="stylesheet" href="style.css"><title>Ошибка ввода</title></head><body>';
    echo '<div class="container"><h2>Исправьте ошибки в форме</h2><div class="alert-err"><ul>';
    foreach ($errors as $err) {
        echo '<li>' . htmlspecialchars($err, ENT_QUOTES, 'UTF-8') . '</li>';
    }
    echo '</ul></div><a href="contacts.html">← Вернуться и исправить</a></div></body></html>';
    exit;
}

// Безопасная запись в SQLite через подготовленное выражение
try {
    $stmt = $pdo->prepare('
        INSERT INTO feedback (name, email, subject, message, created_at)
        VALUES (:name, :email, :subject, :message, :created_at)
    ');
    $stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':subject' => $subject !== '' ? $subject : 'Без темы',
        ':message' => $message,
        ':created_at' => date('Y-m-d H:i:s')
    ]);

    // Шаблон POST/Redirect/GET против повторной отправки при обновлении страницы
    header('Location: messages.php?saved=1');
    exit;
} catch (PDOException $e) {
    die('Не удалось сохранить обращение. Попробуйте позже.');
}