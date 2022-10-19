<?php
session_start();
?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru">
<head>
    <meta name="http-equiv" content="Content-type: text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="../css/style.css" rel="stylesheet" type="text/css" />
    <title>Вход на страницу администрирования</title>
</head>
<body>


<div class="form_auth_block">
    <div class="form_auth_block_content">
        <p class="form_auth_block_head_text">Авторизация</p>
                <?php
                    if (isset($_SESSION['flash'])) {
                        echo '<div class="form_error">'.$_SESSION['flash'].'</div>';
                        unset($_SESSION['flash']);
                    }
                ?>
        <form class="form_auth_style" action="check.php" method="post">
            <input type="text" name="login" placeholder="Введите логин" required >
            <input type="password" name="pass" placeholder="Введите пароль" required >
            <button class="form_auth_button" type="submit" name="form_auth_submit">Войти</button>
        </form>
    </div>
</div>

</body>
</html>