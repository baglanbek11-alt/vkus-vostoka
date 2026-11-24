<?php
header('Content-Type: text/html; charset=UTF-8');
require_once 'db.php';

$stmt = $pdo->query('SELECT id, name, email, subject, message, created_at FROM feedback ORDER BY id DESC');
$rows = $stmt->fetchAll();
$saved = isset($_GET['saved']) && $_GET['saved'] === '1';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Сохранённые обращения</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>Журнал обращений (SQLite)</h1>
    <nav>
      <a href="index.html">Главная</a>
      <a href="catalog.html">Каталог и меню</a>
      <a href="contacts.html">Контакты</a>
      <a href="messages.php" class="active">Обращения (БД)</a>
      <a href="diagnostic.php">Диагностика PHP</a>
    </nav>
  </header>
  <div class="container">
    <h2>Поступившие заявки</h2>
    <div class="badge">Всего записей в базе: <?= count($rows) ?></div>

    <?php if ($saved): ?>
      <div class="alert-ok">Ваше обращение успешно сохранено в базу данных!</div>
    <?php endif; ?>

    <?php if (empty($rows)): ?>
      <p>Обращений пока нет. <a href="contacts.html">Отправить первое сообщение</a>.</p>
    <?php else: ?>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Дата</th>
            <th>Имя</th>
            <th>Email</th>
            <th>Тема</th>
            <th>Сообщение</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $row): ?>
            <tr>
              <td><?= (int)$row['id'] ?></td>
              <td><?= htmlspecialchars($row['created_at'], ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars($row['subject'], ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= nl2br(htmlspecialchars($row['message'], ENT_QUOTES, 'UTF-8')) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
  <footer>© 2026 Кафе «Вкус Востока»</footer>
</body>
</html>