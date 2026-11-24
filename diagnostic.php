<?php
header('Content-Type: text/html; charset=UTF-8');
$projectName = 'Кафе «Вкус Востока»';
$serverDate = date('d.m.Y H:i:s');
$drivers = PDO::getAvailableDrivers();
$hasSqlite = in_array('sqlite', $drivers, true);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Диагностика PHP</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>Диагностика сервера</h1>
    <nav>
      <a href="index.html">Главная</a>
      <a href="catalog.html">Каталог и меню</a>
      <a href="contacts.html">Контакты</a>
      <a href="messages.php">Обращения (БД)</a>
      <a href="diagnostic.php" class="active">Диагностика PHP</a>
    </nav>
  </header>
  <div class="container">
    <h2>PHP успешно выполняется на сервере Apache</h2>
    <p><strong>Проект:</strong> <?= htmlspecialchars($projectName, ENT_QUOTES, 'UTF-8') ?></p>
    <p><strong>Текущая дата и время сервера:</strong> <?= $serverDate ?></p>
    <p><strong>Версия PHP:</strong> <?= PHP_VERSION ?></p>
    <p><strong>Драйвер PDO_SQLITE:</strong> <?= $hasSqlite ? 'Активен (sqlite доступен)' : 'НЕ НАЙДЕН (включите в php.ini)' ?></p>
  </div>
  <footer>© 2026 Кафе «Вкус Востока»</footer>
</body>
</html>