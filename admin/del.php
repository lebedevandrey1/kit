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

// Если сюда были отправлены данные POST, значит пользователь редактирует данные
if(isset($_POST['form_auth_submit']))
{
    // Стерилизуем данные
    $post  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    // Отправляем данные в функцию
    del_cat($post);
    return;
}

// Принимаем GET и сразу обрабатываем его
$id = filter_var(trim($_GET['id']), FILTER_SANITIZE_STRING);
// Обращаемся к функции за данными
$result = edit($id);
// Если пользователь сделал что-то не так, отправляем его на страницу ошибки
if($result == 'Выбрана неверная запись!')
{
    header('Location: ../404.php?msg='.$result);
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
    <title>Редактирование данных</title>
</head>
<body>
<?php require_once '../template/header.php';?>

<div class="form_auth_block">
    <div class="form_auth_block_content">
        <p class="form_auth_block_head_text">Удаление данных</p>
        <form class="form_auth_style" action="del.php" method="post">
            <div class="form_block_delete">Вы уверены, что хотите удалить запись <b>"<?=$result['title']?>"</b>?</div>
            <input type="hidden" name="id" value="<?=$result['id']?>" required>
            <button class="form_auth_button" type="submit" name="form_auth_submit">Удалить</button>
            <a href="structure.php" class="form_auth_a">Отмена</a>
        </form>
    </div>
</div>

</body>
</html>