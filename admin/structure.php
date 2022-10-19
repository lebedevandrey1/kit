<?php
session_start();

require_once '../db.php';
require_once 'functions.php';

// Проверяем, есть ли доступ на страницу администратора
if(!isset($_COOKIE['login']))
{
    $page = "Доступ закрыт";
    header('Location: ../404.php?msg='.$page);
    return;
}
?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru">
<head>
    <meta name="http-equiv" content="Content-type: text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="../css/style.css" rel="stylesheet" type="text/css" />
    <title>Структура данных</title>
</head>
<body>
<?php require_once '../template/header.php';?>

<div class="add_button">
    <a href="add.php">Добавить запись</a>
</div>

<?php
// Для вывода ошибок
if (isset($_SESSION['flash'])) {
    echo '<div class="form_success">'.$_SESSION['flash'].'</div>';
    unset($_SESSION['flash']);
}

// Выводим каталог со всеми родителями и потомками
$result = get_cat();
view_cat($result);
?>

</body>
</html>