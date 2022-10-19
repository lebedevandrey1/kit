<?php
require_once 'db.php';
require_once 'functions.php';

// Если есть GET, надо его обработать
if(isset($_GET['show']))
{
    $result = $conn->query("SELECT * FROM category WHERE(`id` = '" . $_GET['show'] . "') ");
    $var = $result->fetch_assoc();
    $description = $var['description'];
}
else
{
    // Если GET отсутствует, делаем пустое поле, чтобы ошибка на странице не выводилась
    $description = '';
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru">
<head>
    <meta name="http-equiv" content="Content-type: text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="css/style_main.css" rel="stylesheet" type="text/css" />
    <title>Title</title>
</head>
<body>
<div class="admin_line">
    <div>
        <div class="authorize"><a href="admin/index.php">Авторизация</a></div>
    </div>
</div>

<?php
global $conn;
$cats = $conn->query("SELECT * FROM category");
$category = $cats->fetch_all(MYSQLI_ASSOC);
$category = convert($category);
?>

<table>
    <tbody>
    <tr>
        <td><?=out_tree_checkbox($category)?></td>
        <td class="desc"><?=$description?></td>
    </tr>
    </tbody>
</table>


</body>
</html>